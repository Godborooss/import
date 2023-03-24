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
        Schema::create('xmlpackitems', function (Blueprint $table) {
            $table->increments('id');



            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('qty')->nullable();
            $table->string('brutto')->nullable();
            $table->string('netto')->nullable();
            $table->string('price')->nullable();
            $table->string('country_name')->nullable();
            $table->string('country_code')->nullable();
            $table->string('currency_name')->nullable();
            $table->string('currency_rate')->nullable();
            $table->string('unit_name')->nullable();
            $table->string('unit_code')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_from')->nullable();
            $table->string('package_quantity')->nullable();



            $table->integer('xmlpack_id')->unsigned()->nullable();

            $table->foreign('xmlpack_id')->references('id')->on('xmlpacks');
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
        Schema::dropIfExists('xmlpackitems');
    }
};
