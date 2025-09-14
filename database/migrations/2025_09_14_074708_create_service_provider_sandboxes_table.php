<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceProviderSandboxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // ::TODO::Sandbox
        // BKASH_SCRIPT_URL: https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout-sandbox.js
        // app_key:"5tunt4masn6pv2hnvte1sb5n3j",
        // app_secret:"1vggbqd4hqk9g96o9rrrp2jftvek578v7d2bnerim12a87dbrrka"
        // username:"sandboxTestUser",
        // password:"hWD@8vtzw0"
        Schema::create('service_provider_sandboxes', function (Blueprint $table) {
            $table->id();
            $table->string('base_url');
            $table->string('app_key');
            $table->string('app_secret');
            $table->string('username');
            $table->string('password');
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
        Schema::dropIfExists('service_provider_sandboxes');
    }
}
