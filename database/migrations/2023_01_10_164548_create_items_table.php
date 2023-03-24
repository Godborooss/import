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
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('qty');
            $table->integer('price');
            $table->integer('netto');
            $table->integer('brutto');
            $table->integer('package');


            $table->string('country')->nullable()->default('cn');
            $table->string('nameofproduct')->nullable();
            $table->integer('taxcode')->nullable();

            $table->integer('pack_id')->unsigned()->nullable();



            $table->foreign('pack_id')->references('id')->on('packs');
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
        Schema::dropIfExists('items');
    }
};
