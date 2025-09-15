<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('keyword')->unique();
            $table->enum('type', ['subscription', 'on-demand'])->default('on-demand');
            $table->enum('mode', ['production', 'sandbox'])->default('production');
            $table->string('validity')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('api_url')->nullable();
            $table->string('redirect_url')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('services');
    }
}
