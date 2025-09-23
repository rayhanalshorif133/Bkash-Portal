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
            $redirect_url = $request->redirect_url;
            $amount = $request->amount;
            
            if (!$keyword || !$msisdn) {
                return redirect()->back()->with('error', 'Invalid request parameters');
            }
            $service = Service::select()->where('keyword', $keyword)->first();
            if($redirect_url){
                $service->redirect_url = $redirect_url;
            }

            if($amount){
                $service->amount = $amount;
            }

            $service->save();
            $token = $this->getToken($service->mode);
            return $this->createPayment($token, $msisdn, $service);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }


    

    

    
}
