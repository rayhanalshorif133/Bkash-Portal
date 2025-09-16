<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrantTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grant_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('msisdn')->nullable();
            $table->text('id_token');
            $table->integer('expires_in')->default(3600);
            $table->text('refresh_token');
            $table->enum('mode', ['app','web', 'sandbox'])->default('app');
            $table->timestamp('expire_time');
            $table->string('status')->nullable();
            $table->string('msg')->nullable();
            $table->timestamp('created')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grant_tokens');
    }
}
