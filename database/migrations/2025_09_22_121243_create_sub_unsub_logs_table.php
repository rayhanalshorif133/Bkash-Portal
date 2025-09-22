<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubUnsubLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_unsub_logs', function (Blueprint $table) {
            $table->id();
            $table->string('msisdn')->nullable();
            $table->string('keyword')->nullable();
            $table->string('status')->nullable();
            $table->string('flag', 10)->nullable();
            $table->date('opt_date')->nullable();
            $table->string('opt_time')->nullable();
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
        Schema::dropIfExists('sub_unsub_logs');
    }
}
