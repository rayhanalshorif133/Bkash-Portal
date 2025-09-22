<?php

use App\Models\PaymentQuery;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreatePaymentQueriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_queries', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id', 50)->unique();
            $table->string('trx_id', 30)->nullable();
            $table->string('transaction_status', 20)->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('merchant_invoice_number', 20)->nullable();
            $table->string('customer_msisdn', 20)->nullable();
            $table->text('response')->nullable();
            $table->string('errorMessage')->nullable();
            $table->string('errorCode')->nullable();
            $table->dateTime('update_time');
            $table->dateTime('create_time');
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
        Schema::dropIfExists('payment_queries');
    }
}
