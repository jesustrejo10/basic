<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 40);
            $table->string('last_name', 40);
            $table->string('email')->unique();
            $table->string('password',400);
            $table->string('passport_number')->nullable();
            $table->string('passport_img_url')->nullable();
            $table->string('profile_img_url')->nullable();
            $table->integer('country_id');
            $table->integer('active')->default('1');
            $table->integer('ready_to_withdraw')->default('0');
            $table->integer('in_verified_process')->default('0');
            $table->integer('verified')->default('0');
            $table->integer('wallet_id')->nullable();
            $table->integer('account_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
