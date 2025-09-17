<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceProvider;
use Illuminate\Http\Request;
use App\Traits\BkashTrait;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{

    use BkashTrait;

    public function payment(Request $request)
    {
        try {
            $keyword = $request->keyword;
            $msisdn = $request->msisdn;

            if (!$keyword || !$msisdn) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Msisdn & Keyword is required'
                ], 400);
            }
            $service = Service::select()->where('keyword', $keyword)->first();
            $token = $this->getToken($service->mode);
            return $this->createPayment($token, $msisdn, $service->mode);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }


    public function createPayment($token, $msisdn, $mode)
    {


        $serviceProvider = ServiceProvider::select()->where('mode', $mode)->first();
        $url = $serviceProvider->base_url . '/payment/create';

        $requestData = [
            'amount' => '10',
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => '023',
        ];


        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $token,
            'x-app-key' => $serviceProvider->app_key,
        ])->timeout(30)->post($url, $requestData);

        $result = $response->json(); // decode JSON response as array

        // create payment data store
        /* 
        {
  "amount": "10",
  "createTime": "2025-09-17T15:04:34:736 GMT+0600",
  "currency": "BDT",
  "hash": "aMSkYvrPg(lTH8DKLtMwQI0HJ)56eXgmtPBZbdy4y-KG7yO!XL8rI0Hf2yc0-40mG)lYZSqJ*d-73zFBv*CIRt9kHy!FRX1LjZPH1758099874727",
  "intent": "sale",
  "merchantInvoiceNumber": "023",
  "orgLogo": "https://s3-ap-southeast-1.amazonaws.com/merchantlogo.sandbox.bka.sh/merchant-default-logo.png",
  "orgName": "TestCheckoutMerchant2",
  "paymentID": "CH0011MThcn6P1758099874727",
  "transactionStatus": "Initiated"
}

        */

        return $result;
    }

    public function getInvoiceNo()
    {

        $invoice_no = rand(111111, 999999);

        // $findIsExist = PaymentCreate::select()->where('invoice_no', $invoice_no)->first();

        return $invoice_no;
    }
}
