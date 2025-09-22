<?php

use App\Models\PaymentExecute;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentExecutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_executes', function (Blueprint $table) {
            $table->id();
            $table->string('paymentID', 50)->nullable();
            $table->string('trxID', 30)->nullable();
            $table->string('transactionStatus', 20)->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('currency', 10)->nullable();
            $table->string('intent', 20)->nullable();
            $table->string('merchantInvoiceNumber', 20)->nullable();
            $table->string('customerMsisdn', 20)->nullable();
            $table->decimal('maxRefundableAmount', 10, 2)->nullable();
            $table->dateTime('createTime');
            $table->dateTime('updateTime');
            $table->timestamps();
        });

        PaymentExecute::create([
            'paymentID' => 'CH0011wZJD5t11758433356191',
            'createTime' => now(),
            'updateTime' => now(),
            'trxID' => 'CIL60NGFWA',
            'transactionStatus' => 'Completed',
            'amount' => 10,
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => '779445',
            'customerMsisdn' => '01929918378',
            'maxRefundableAmount' => 10,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_executes');
    }
}
