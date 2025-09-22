<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Traits\BkashTrait;


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


    

    

    
}
