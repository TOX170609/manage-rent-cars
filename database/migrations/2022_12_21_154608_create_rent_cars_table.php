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
        Schema::create('rent_cars', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('brand');
            $table->integer('yearProduce');
            $table->integer('carMileage');
            $table->string('color');
            $table->boolean('active')->nullable();
            $table->boolean('renovation')->nullable();
            $table->boolean('rented')->nullable();
            $table->integer('driverID')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rent_cars');
    }
};
