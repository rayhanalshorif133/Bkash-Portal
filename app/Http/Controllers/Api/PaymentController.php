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

    public function createBkashPayment()
    {
        $url = "https://checkout.sandbox.bka.sh/v1.2.0-beta/checkout/payment/create";

        $response = Http::withHeaders([
            'Authorization' => 'YOUR_ACCESS_TOKEN', // 👈 Replace with the token you got from grant/refresh
            'X-APP-Key'     => '5tunt4masn6pv2hnvte1sb5n3j',
            'accept'        => 'application/json',
            'content-type'  => 'application/json',
        ])->post($url, [
            'amount'               => '10',
            'currency'             => 'BDT',
            'intent'               => 'sale',
            'merchantInvoiceNumber' => '819983', // 👈 unique each time
        ]);

        if ($response->successful()) {
            return $response->json(); // ✅ paymentID + status
        }

        return response()->json([
            'error'   => $response->status(),
            'message' => $response->body(),
        ], $response->status());
    }

    public function createPayment($token, $msisdn, $mode)
    {


        $serviceProvider = ServiceProvider::select()->where('mode', $mode)->first();
        $url = $serviceProvider->base_url . '/payment/create';

        dd($url);

        $request_data = array(
            'amount'                =>  '10',
            'currency'                => 'BDT',
            'intent'                => 'sale',
            'merchantInvoiceNumber'    =>  '01920298',
        );



        $url = curl_init('https://checkout.pay.bka.sh/v1.2.0-beta/checkout/payment/create');
        $request_data_json = json_encode($request_data);
        $header = array(
            'Content-Type:application/json',
            "authorization: $token",
            'x-app-key:2l6u3m4i01ed69foin29vp42m'
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $request_data_json);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($url, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($url);

        curl_close($url);



        $response = json_decode($response, true);



        $payCreate->payment_id = $response['paymentID'];
        $payCreate->amount = $response['amount'];
        $payCreate->response = $response;
        $payCreate->save();

        return $response;
    }

    public function getInvoiceNo()
    {

        $invoice_no = rand(111111, 999999);

        // $findIsExist = PaymentCreate::select()->where('invoice_no', $invoice_no)->first();

        return $invoice_no;
    }
}
