<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNaturalPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('natural_people', function (Blueprint $table) {
            $table->increments('id');
            //todo Quitar los nulable
            $table->string('legal_name',40);
            $table->string('account_type',1)->nullable();
            $table->string('account_number',20)->nullable();
            $table->string('email')->nullable();
            $table->string('cedula')->nullable();
            $table->string('rif')->nullable();
            $table->string('address')->nullable();
            $table->integer('bank_id')->nullable();
            $table->string('person_type',1)->nullable();
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
        Schema::dropIfExists('natural_people');
    }
}
