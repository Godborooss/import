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
        Schema::create('infos', function (Blueprint $table) {
            $table->id();
            $table->string('container_number')->nullable();
            $table->string('currency')->nullable();
            $table->string('car_number')->nullable();
            $table->string('method')->nullable();
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
        Schema::dropIfExists('infos');
    }
};
