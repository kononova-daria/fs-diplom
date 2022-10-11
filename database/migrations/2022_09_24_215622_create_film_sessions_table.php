<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('film_sessions', function (Blueprint $table) {
            $table->id();
            $table->integer('start');
            $table->integer('end');
            $table->integer('film_id');
            $table->foreign('film_id')->references('id')->on('films');
            $table->integer('hall_id');
            $table->foreign('hall_id')->references('id')->on('halls');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('film_sessions');
    }
};
