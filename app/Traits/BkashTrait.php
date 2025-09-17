<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use App\Models\Service;
use App\Models\ServiceProvider;
use App\Models\GrantToken;
use Illuminate\Http\Request;
use Carbon\Carbon;

trait BkashTrait
{
    public function getToken($mode)
    {

        $serviceProvider = ServiceProvider::select()->where('mode', $mode)->first();
        $bkashApiBase = $serviceProvider->base_url . '/token/';
        $grantToken = GrantToken::orderBy('id', 'desc')
            ->where('mode', $mode)
            ->first();

        // IF the table is empty, create a new grant token

        if (!$grantToken) {

            $payload =    [
                'app_key'    => $serviceProvider->app_key,
                'app_secret' => $serviceProvider->app_secret,
            ];

            $response = $this->callBkashApi($bkashApiBase . 'grant', $serviceProvider, $payload);



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


            $response = $this->callBkashApi($bkashApiBase . 'refresh', $serviceProvider, $payload);


            // Check after the refresh token is expired, if it is expired, then create a new grant token
            if (isset($response['status']) && $response['status'] == 'fail') {
                $payload =    [
                    'app_key'    => $serviceProvider->app_key,
                    'app_secret' => $serviceProvider->app_secret,
                ];

                $response = $this->callBkashApi($bkashApiBase . 'grant', $serviceProvider, $payload);
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


    public function callBkashApi($url, $serviceProvider, $payload)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'username' => $serviceProvider->username,
            'password' => $serviceProvider->password,
            'content-type' => 'application/json',
        ])->post($url, $payload);

        if ($response->successful()) {
            return $response->json();
        } else {
            return response()->json([
                'error' => $response->status(),
                'message' => $response->body(),
            ], $response->status());
        }
    }
}
