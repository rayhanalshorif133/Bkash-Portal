<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('msisdn')->nullable();
            $table->string('payment_id', 50)->nullable();
            $table->string('trx_id', 30)->nullable();
            $table->string('keyword')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 = inactive, 1 = active');
            $table->dateTime('subs_date')->nullable();
            $table->dateTime('unsubs_date')->nullable();
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
        Schema::dropIfExists('subscribers');
    }
}
