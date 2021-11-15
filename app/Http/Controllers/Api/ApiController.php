<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function __construct() {
        $this->email = env("PAGSEGURO_EMAIL");
        $this->token = '.env("PAGSEGURO_TOKEN").';
    }

    public function api($provider, $fields, $headers, $method = 'POST') {

        $email = $this->email;
        $token = $this->token;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://ws.sandbox.pagseguro.uol.com.br/$provider?email=$email&token=$token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }
}
