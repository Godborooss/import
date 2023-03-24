<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packs', function (Blueprint $table) {

            $table->increments('id');
            $table->string('nameofpack')->nullable();
            $table->integer('receiver_id')->unsigned()->nullable();
            $table->integer('sender_id')->unsigned()->nullable();
            $table->integer('broker_id')->unsigned()->nullable();
            $table->string('method')->nullable();
            $table->string('container')->nullable();
            $table->string('shipping_term')->nullable();
            $table->string('currency')->nullable();
            $table->string('car_number')->nullable();


            $table->integer('user_id')->unsigned();




            $table->foreign('broker_id')->references('id')->on('brokers');
            $table->foreign('receiver_id')->references('id')->on('receivers');
            $table->foreign('sender_id')->references('id')->on('senders');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('packs');
    }
};
