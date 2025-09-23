<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use App\Models\Service;
use App\Models\ServiceProvider;
use App\Models\PaymentQuery;
use App\Models\GrantToken;
use App\Models\PaymentExecute;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Traits\SubscriptionTrait;

trait BkashTrait
{

    use SubscriptionTrait;

    public function getToken($mode)
    {

        $serviceProvider = ServiceProvider::select()->where('mode', $mode)->first();
        $bkashApiBase = $serviceProvider->base_url;
        $grantToken = GrantToken::orderBy('id', 'desc')
            ->where('mode', $mode)
            ->first();





        $username = $serviceProvider->username;
        $password = $serviceProvider->password;





        // IF the table is empty, create a new grant token

        if (!$grantToken) {

            $payload =    [
                'app_key'    => $serviceProvider->app_key,
                'app_secret' => $serviceProvider->app_secret,
            ];

            $response = $this->callBkashApi($bkashApiBase . '/token/grant', $username, $password, $payload);





            $grantToken = new GrantToken();
            $grantToken->id_token      = $response['id_token'];
            $grantToken->expires_in    = 3600;
            $grantToken->refresh_token = $response['refresh_token'];
            $grantToken->expire_time   = Carbon::now()->addHour()->format('Y-m-d H:i:s');
            $grantToken->status        = null;
            $grantToken->msg           = null;
            $grantToken->mode           = $mode;
            $grantToken->created       = Carbon::now()->format('Y-m-d H:i:s');
            $grantToken->save();

            return $response['id_token'];
        }



        if ($grantToken && Carbon::parse($grantToken->expire_time)->gt(Carbon::now())) {
            return $grantToken->id_token;
        } else {

            $payload =    [
                'app_key'    => $serviceProvider->app_key,
                'app_secret' => $serviceProvider->app_secret,
                'refresh_token' => $grantToken->refresh_token,
            ];


            $response = $this->callBkashApi($bkashApiBase . '/token/refresh', $username, $password, $payload);


            // Check after the refresh token is expired, if it is expired, then create a new grant token
            if (isset($response['status']) && $response['status'] == 'fail') {
                $payload =    [
                    'app_key'    => $serviceProvider->app_key,
                    'app_secret' => $serviceProvider->app_secret,
                ];

                $response = $this->callBkashApi($bkashApiBase . '/token/grant', $username, $password, $payload);
            }


            $grantToken = new GrantToken();
            $grantToken->id_token      = $response['id_token'];
            $grantToken->expires_in    = 3600;
            $grantToken->refresh_token = $response['refresh_token'];
            $grantToken->expire_time   = Carbon::now()->addHour()->format('Y-m-d H:i:s');
            $grantToken->status        = null;
            $grantToken->msg           = null;
            $grantToken->mode           = $mode;
            $grantToken->created       = Carbon::now()->format('Y-m-d H:i:s');
            $grantToken->save();


            return $response['id_token'];
        }
    }


    public function callBkashApi($url, $username, $password, $payload)
    {


        $response = Http::withHeaders([
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'username' => $username,
            'password' => $password,
        ])->post($url, $payload);


        return $response->json();
    }

    public function createPayment($token, $msisdn, $service)
    {


        $serviceProvider = ServiceProvider::select()->where('mode', $service->mode)->first();
        $invoice_no = $this->getInvoiceNo();

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'Authorization' => $token,
            'X-APP-Key' => $serviceProvider->app_key,
        ])->post($serviceProvider->base_url . '/payment/create', [
            "amount" => $service->amount,
            "currency" => "BDT",
            "intent" => "sale",
            "merchantInvoiceNumber" => $invoice_no,
        ]);

        $result =  $response->json();



        // create payment data store
        $payment = new Payment();
        $payment->amount = $result['amount'] ?? null;
        $payment->msisdn = $msisdn ?? null;
        $payment->keyword = $service->keyword ?? null;
        $payment->create_time = now();
        $payment->currency = $result['currency'] ?? null;
        $payment->hash = $result['hash'] ?? null;
        $payment->intent = $result['intent'] ?? null;
        $payment->merchant_invoice_number = $result['merchantInvoiceNumber'] ?? null;
        $payment->org_logo = $result['orgLogo'] ?? null;
        $payment->org_name = $result['orgName'] ?? null;
        $payment->payment_id = $result['paymentID'] ?? null;
        $payment->transaction_status = $result['transactionStatus'] ?? null;
        $payment->save();

        return $result;
    }


    public function executePayment($payment_id)
    {
        $payment = Payment::select()->where('payment_id', $payment_id)->first();

        if (!$payment) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Payment ID not found, please try again'
            ], 404);
        }

        $service = Service::select()->where('keyword', $payment->keyword)->first();
        $serviceProvider = ServiceProvider::select()->where('mode', $service->mode)->first();
        $token = $this->getToken($service->mode);


        try {

            sleep(1);


            $payment_url = $serviceProvider->base_url . '/payment/execute/' . $payment_id;
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => $token,
                'x-app-key' => $serviceProvider->app_key,
            ])->timeout(30)->post($payment_url);

            $result = $response->json();


            if (isset($result['transactionStatus']) && $result['transactionStatus'] === "Completed") {
                $paymentExecute = new PaymentExecute();
                $paymentExecute->paymentID = $result['paymentID'];
                $paymentExecute->createTime = now();
                $paymentExecute->updateTime = now();
                $paymentExecute->trxID = $result['trxID'];
                $paymentExecute->transactionStatus = $result['transactionStatus'];
                $paymentExecute->amount = $result['amount'];
                $paymentExecute->currency = $result['currency'];
                $paymentExecute->intent = $result['intent'];
                $paymentExecute->merchantInvoiceNumber = $result['merchantInvoiceNumber'];
                $paymentExecute->customerMsisdn = $result['customerMsisdn'];
                $paymentExecute->maxRefundableAmount = $result['maxRefundableAmount'];
                $paymentExecute->save();


                // check payment status
                sleep(13);
                $isPaymentSuccess = $this->queryPayment($payment_id);

                if ($isPaymentSuccess) {

                    // create subscription
                    $this->subscription($payment, $paymentExecute->trxID, $service);
                    $url = $service->redirect_url . '?status=success&msisdn=' . $payment->msisdn . '&amount=' . $payment->amount . '&trxID=' . $paymentExecute->trxID . '&invoice_no=' . $payment->merchant_invoice_number;
                    return redirect($url);
                } else {
                    $url = $service->redirect_url . '?status=failed&msisdn=' . $payment->msisdn . '&amount=' . $service->amount;
                    return redirect($url);
                }
            } else {
                $url = $service->redirect_url . '?status=failed&msisdn=' . $payment->msisdn . '&amount=' . $service->amount;
                return redirect($url);
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function queryPayment($payment_id)
    {
        $payment = Payment::select()->where('payment_id', $payment_id)->first();
        $service = Service::select()->where('keyword', $payment->keyword)->first();
        $serviceProvider = ServiceProvider::select()->where('mode', $service->mode)->first();
        $token = $this->getToken($service->mode);


        try {

            sleep(1);


            $payment_url = $serviceProvider->base_url . '/payment/query/' . $payment_id;

            $response = Http::withHeaders([
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'Authorization' => $token,
                'X-APP-Key' => $serviceProvider->app_key,
            ])->get($payment_url);

            $result = $response->json();

            $pay_query = PaymentQuery::create([
                'create_time' => now(),
                'update_time' => now(),
                'payment_id' => $payment_id,
                'trx_id' => $result['trxID'] ?? null,
                'transaction_status' => $result['transactionStatus'] ?? null,
                'amount' => $result['amount'] ?? null,
                'merchant_invoice_number' => $result['merchantInvoiceNumber'] ?? null,
                'customer_msisdn' => $result['customerMsisdn'] ?? null,
                'response' => json_encode($result),
                'errorMessage' => $result['errorMessage'] ?? null,
                'errorCode' => $result['errorCode'] ?? null,
            ]);

            if ($pay_query->transaction_status == 'Completed') {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function getInvoiceNo()
    {

        $invoice_no = rand(111111, 999999);

        $findIsExist = Payment::select()->where('merchant_invoice_number', $invoice_no)->first();
        if ($findIsExist) {
            $this->getInvoiceNo();
        }

        return (string)$invoice_no;
    }
}
