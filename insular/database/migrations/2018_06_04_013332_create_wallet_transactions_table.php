<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wallet_id');
            $table->string('stripe_id')->nullable();
            $table->integer('status')->nullable();
            $table->integer('refund')->default(0);
            $table->integer('wallet_transaction_id_refund')->nullable()->unique();
            $table->float('amount',8,2);
            $table->float('fee',8,2)->default('0');
            $table->float('total_amount',8,2)->default('0');
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
        Schema::dropIfExists('wallet_transactions');
    }
}
