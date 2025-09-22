<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('msisdn')->nullable();
            $table->string('amount')->nullable();
            $table->string('currency', 10)->nullable();
            $table->string('keyword');
            $table->text('hash')->nullable();
            $table->string('intent', 20)->nullable();
            $table->string('merchant_invoice_number');
            $table->timestamp('create_time')->nullable();
            $table->string('org_logo')->nullable();
            $table->string('org_name');
            $table->string('payment_id')->unique();
            $table->string('transaction_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
