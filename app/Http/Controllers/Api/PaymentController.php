<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Service;
use App\Models\PaymentQuery;
use App\Models\PaymentExecute;
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
            return $this->createPayment($token, $msisdn, $service);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
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

    public function executePayment($paymentID)
    {
        $payment = Payment::select()->where('payment_id', $paymentID)->first();

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


            $payment_url = $serviceProvider->base_url . '/payment/execute/' . $paymentID;
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => $token,
                'x-app-key' => $serviceProvider->app_key,
            ])->timeout(30)->post($payment_url);

            $result = $response->json();
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
            $isPaymentSuccess = $this->queryPayment($paymentID);

            if($isPaymentSuccess){
                // $this->subs, charge, active, deactive
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Payment completed successfully'
                ], 200);
            }else{
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Payment not completed, please try again'
                ], 400);
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function queryPayment($paymentID)
    {
        $payment = Payment::select()->where('payment_id', $paymentID)->first();
        $service = Service::select()->where('keyword', $payment->keyword)->first();
        $serviceProvider = ServiceProvider::select()->where('mode', $service->mode)->first();
        $token = $this->getToken($service->mode);


        try {

            sleep(1);


            $payment_url = $serviceProvider->base_url . '/payment/query/' . $paymentID;

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
                'payment_id' => $paymentID,
                'trx_id' => $result['trxID'] ?? null,
                'transaction_status' => $result['transactionStatus'] ?? null,
                'amount' => $result['amount'] ?? null,
                'merchant_invoice_number' => $result['merchantInvoiceNumber'] ?? null,
                'customer_msisdn' => $result['customerMsisdn'] ?? null,
                'response' => json_encode($result),
                'errorMessage' => $result['errorMessage'] ?? null,
                'errorCode' => $result['errorCode'] ?? null,
            ]);

            if($pay_query->transaction_status == 'Completed'){
                return true;
            }else{
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
