<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
class PaymentController extends Controller
{
    function getPayment(){
        $client = new Client();
        
        try {
            $res = $client->request('GET','http://127.0.0.1:8000/coba', []);
            $data = json_decode($res->getBody()->getContents());

            dd($data);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
