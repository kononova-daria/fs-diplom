<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->integer('hall_id');
            $table->foreign('hall_id')->references('id')->on('halls');
            $table->integer('row');
            $table->integer('num');
            $table->integer('type_id');
            $table->foreign('type_id')->references('id')->on('seat_types');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('places');
    }
};
