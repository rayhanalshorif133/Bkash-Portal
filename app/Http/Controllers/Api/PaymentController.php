<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceProvider;
use App\Models\GrantToken;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function subscription(Request $request)
    {


        try {
            $keyword = $request->keyword;
            if (!$keyword) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Keyword is required'
                ], 400);
            }
            $service = Service::select()->where('keyword', $keyword)->first();
            return $this->getToken($service->mode);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }


    public function getToken($mode)
    {

        $serviceProvider = ServiceProvider::select()->where('mode', $mode)->first();



        // https://checkout.pay.bka.sh/v1.2.0-beta/checkout/token/
        // https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/
        $bkashApiBase = $serviceProvider->base_url . 'token/';

        $appKey = $serviceProvider->app_key;
        $appSecret = $serviceProvider->app_secret;



        $grantToken = GrantToken::orderBy('id', 'desc')
            ->where('mode', $mode)
            ->first();

        // IF the table is empty, create a new grant token

        if (!$grantToken) {
            $requestData = [
                'app_key' => $appKey,
                'app_secret' => $appSecret,
            ];

            $response = $this->callBkashApi($bkashApiBase . 'grant', $requestData, $serviceProvider);

            $grantToken = new GrantToken();
            $grantToken->msisdn        = null;
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


            $requestData = [
                'app_key' => $appKey,
                'app_secret' => $appSecret,
                'refresh_token' => $grantToken->refresh_token,
            ];


            $response = $this->callBkashApi($bkashApiBase . 'refresh', $requestData, $serviceProvider);


            // Check after the refresh token is expired, if it is expired, then create a new grant token
            if (isset($response['status']) && $response['status'] == 'fail') {
                $requestData = [
                    'app_key' => $appKey,
                    'app_secret' => $appSecret,
                ];

                $response = $this->callBkashApi($bkashApiBase . 'grant', $requestData, $serviceProvider);
            }

            DB::connection('mysql2')->table('grant_token')->insert([
                'msisdn' => null,
                'id_token' => $response['id_token'],
                'expires_in' => 3600,
                'refresh_token' => $response['refresh_token'],
                'expire_time' => Carbon::now()->addHour()->format('Y-m-d H:i:s'),
                'status' => null,
                'msg' => null,
                'created' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);


            return $response['id_token'];
        }
    }


    public function callBkashApi($url, $requestData, $serviceProvider)
    {

        $headers = array(
            'Content-Type:application/json',
            'username:' . $serviceProvider->username,
            'password:' . $serviceProvider->password
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);



        if ($error) {
            throw new \Exception("cURL Error: " . $error);
        }



        return json_decode($response, true);
    }
}
