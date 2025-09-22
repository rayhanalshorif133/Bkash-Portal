<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use App\Models\Subscriber;
use App\Models\SubUnsubLog;
use App\Models\ChargeLog;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

trait SubscriptionTrait
{
    public function subscription($payment, $trxID, $service)
    {
        try {
            $subsDate = Carbon::now();
            $unsubsDate = null;

            $subs = new Subscriber();
            $subs->msisdn = $payment->msisdn;
            $subs->payment_id = $payment->payment_id;
            $subs->trx_id = $trxID;
            $subs->keyword = $service->keyword;
            $subs->status = 1;
            $subs->subs_date = $subsDate;
            $subs->unsubs_date = $unsubsDate;
            $subs->save();

            // Charge logs
            $chargeLog = new ChargeLog();
            $chargeLog->payment_id = $payment->id;
            $chargeLog->msisdn = $payment->msisdn;
            $chargeLog->keyword = $service->keyword;
            $chargeLog->amount = $service->amount;
            $chargeLog->type = 'subs';
            $chargeLog->charge_date = $subsDate->toDateString();
            $chargeLog->save();

            // update payment status
            $payment->transaction_status = 'Paid';
            $payment->save();



            // sub and unsub date update
            $subsUnsubs = new SubUnsubLog();
            $subsUnsubs->msisdn = $payment->msisdn;
            $subsUnsubs->keyword = $service->keyword;
            $subsUnsubs->status = 'Subs';
            $subsUnsubs->flag = 'On Demand';
            $subsUnsubs->opt_date = $subsDate->toDateString();
            $subsUnsubs->opt_time = $subsDate->toTimeString();
            $subsUnsubs->save();

            return true;
        } catch (\Throwable $th) {
            Log::error('Subscription Error: ' . $th->getMessage());
            return false;
        }
    }
}
