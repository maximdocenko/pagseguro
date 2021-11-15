<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\Listing;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{

    public function __construct()
    {
        $this->ApiController = new ApiController;
    }

    public function checkout()
    {

        $response = $this->ApiController->api('v2/sessions', '', $this->headers('x-www-form-urlencoded'));

        try {



            $user = Auth::user();

            $xml = simplexml_load_string($response);

            $session = $xml->id;

            $form = $user->user_plan->plan->type;

            if($form == 'one_time') {

                $listings = Listing::where(['status' => 'pending', 'user_id' => $user->id])->get();

                return view('content.checkout', ['listings' => $listings, 'form' => $form, 'session' => $session]);

            }

            if($form == 'subscription') {

                $agreement = Agreement::where(['user_id' => $user->id])->first();

                if($agreement) {
                    if($agreement->status == 'active') {
                        return view('content.checkout', ['form' => $form, 'session' => $session, 'status' => $agreement->status]);
                    }
                }else{
                    return view('content.checkout', ['form' => $form, 'session' => $session]);
                }

            }

        }catch (\Throwable $e) {
            return 'Please try again later';
        }


    }

    public function submit(Request $request) {

        $user = Auth::user();

        $func = $user->user_plan->plan->type;

        $result = ['errors' => [], 'message' => ''];

        return $this->$func($request, $user, $result);

    }

    public function one_time(Request $request, $user, $result) {

        $request->validate([
            'creditCardToken' => 'required',
            'listing_id' => 'required',
            'brand' => 'required',
        ], [
            'creditCardToken.required' => 'Some problems with card',
            'listing_id.required' => 'Please select listing',
            'brand.required' => 'Credit card brand incorrect',
        ]);

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $installmentValue = 0;
        foreach ($data['listing_id'] as $k => $listing_id) {
            $k+=1;
            $price = Listing::find($listing_id)->listing_plan->plan->price;
            $data['itemId'.$k] = $k;
            $data['itemDescription'.$k] = 'Desc'.$k;
            $data['itemAmount'.$k] = $price;
            $data['itemQuantity'.$k] = 1;
            $installmentValue += $price;
        }

        $data['installmentQuantity'] = 1;
        $data['installmentValue'] = number_format($installmentValue, '2', '.', '');

        $listings = $data['listing_id'];

        $url = 'v2/transactions';

        $fields = http_build_query($data);

        $response = $this->ApiController->api($url, $fields, $this->headers('x-www-form-urlencoded'));

        try {

            $xml = simplexml_load_string($response);

            if(isset($xml)) {

                $this->create_transaction($xml->code, $user->id);

                foreach ($listings as $listing) {
                    $item = Listing::find($listing);
                    $item->status = 'active';
                    $item->save();
                }

                $result['message'] = 'Success';

            }

        }catch (\Throwable $exception) {

            $result['errors'] = ['There is some error with transparent transaction'];

        }

        return $result;

    }

    public function subscription(Request $request, $user, $result) {

        $request->validate([
            'paymentMethod.creditCard.token' => 'required',
            'brand' => 'required',
        ], [
            'paymentMethod.creditCard.token.required' => 'Some problems with card',
            'brand.required' => 'Credit card brand incorrect',
        ]);

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $data['plan'] = $user->user_plan->plan->plan_code->code;

        $agreement = Agreement::where(['user_id' => $user->id])->first();

        unset($data['_token']);
        unset($data['cardNumber']);
        unset($data['cvv']);
        unset($data['expirationMonth']);
        unset($data['expirationYear']);
        unset($data['brand']);

        if($agreement) {

            $this->activate($agreement->code);

            return $this->charge($user, $agreement, $result);
        }else{
            $agreement = $this->agreement($user, $data, $result);

            if(isset($agreement->code)) {
                return $this->charge($user, $agreement, $result);
            }

            if(isset($agreement->errors)) {
                return $this->errors($agreement->errors);
            }

        }

        return $result;

    }



    public function agreement($user, $data, $result) {

        $url = 'pre-approvals';

        $fields = json_encode($data);

        $response = $this->ApiController->api($url, $fields, $this->headers('json', 'v1'));

        try {

            $agreement = json_decode($response);

            if(isset($agreement->code)) {

                return $this->create_agreement($agreement->code, $user);

            }

            if(isset($agreement->errors)) {
                return $agreement;
            }


        }catch (\Throwable $exception) {

            $result['errors'] = ['Agreement creation Error'];

        }

        return $result;

    }

    public function charge($user, $agreement, $result) {

        $url = 'pre-approvals/payment';

        $price = number_format($user->user_plan->plan->price, 2, '.', '');
        $code = $agreement->code;

        $fields = "<payment>
                            <items>
                                <item>
                                    <id>0001</id>
                                    <description>Cobranca 123</description>
                                    <amount>$price</amount>
                                    <quantity>1</quantity>
                                </item>
                            </items>
                            <reference>REF1234-1</reference>
                            <preApprovalCode>$code</preApprovalCode>
                        </payment>";


        $response = $this->ApiController->api($url, $fields, $this->headers('xml', 'v3'));

        try {

            $transaction = json_decode($response);

            if(isset($transaction->transactionCode)) {

                $this->create_transaction($transaction->transactionCode, $user->id);

                $listings = Listing::where(['user_id' => $user->id])->get();

                foreach ($listings as $listing) {
                    $item = Listing::find($listing->id);
                    $item->status = 'active';
                    $item->save();
                }

                $agreement = Agreement::where(['code' => $code])->first();
                $agreement->status = 'active';
                $agreement->save();

                $result['message'] = 'Transaction created successfully';

            }
            if(isset($transaction->errors)) {
                return $this->errors($transaction->errors);
            }

        }catch (\Throwable $exception) {

            $result['errors'] = ['Transaction error'];

        }

        return $result;
    }

    public function create_transaction($transactionCode, $user_id) {

        return Transaction::create(['code' => $transactionCode, 'user_id' => $user_id]);

    }

    public function create_agreement($agreementCode, $user) {

        return Agreement::create(['code' => $agreementCode, 'user_id' => $user->id, 'status' => 'pending']);

    }

    public function activate($agreement) {
        $this->ApiController->api("pre-approvals/$agreement/status", '{"status":"ACTIVE"}', $this->headers('json', 'v3'), 'PUT');
    }

    public function headers($type = '', $v = '') {
        $headers = [];
        if($type) {
            $headers[0] = "Content-Type: application/$type";
        }
        if($v) {
            $headers[1] = "Accept: application/vnd.pagseguro.com.br.$v+json;charset=ISO-8859-1";
        }
        return $headers;
    }

    public function errors($errors)
    {
        foreach ($errors as $error) {
            $result['errors'][] = $error;
        }

        return $result;
    }

}
