<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use Illuminate\Http\Request;

class AgreementController extends Controller
{
    public function index() {
        $data = Agreement::all();

        $agreements = [];

        foreach ($data as $item) {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://ws.sandbox.pagseguro.uol.com.br/pre-approvals/'.$item->code.'?email='.env("PAGSEGURO_EMAIL").'&token='.env("PAGSEGURO_TOKEN").'',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Accept: application/vnd.pagseguro.com.br.v3+json;charset=ISO-8859-1'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $agreements[] = json_decode($response);

        }

        return response()->json($agreements);
    }

    public function test() {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ws.sandbox.pagseguro.uol.com.br/pre-approvals/43FC7E118787299334146F81B3961539?email='.env("PAGSEGURO_EMAIL").'&token='.env("PAGSEGURO_TOKEN").'',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/vnd.pagseguro.com.br.v3+json;charset=ISO-8859-1'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);


        return json_decode($response)->status;
    }

    public function suspend() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ws.sandbox.pagseguro.uol.com.br/pre-approvals/43FC7E118787299334146F81B3961539/status?email='.env("PAGSEGURO_EMAIL").'&token='.env("PAGSEGURO_TOKEN").'',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS =>'{
                "status":"SUSPENDED"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/vnd.pagseguro.com.br.v3+json;charset=ISO-8859-1'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
}
