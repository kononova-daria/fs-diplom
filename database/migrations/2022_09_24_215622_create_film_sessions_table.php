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
            $table->integer('film');
            $table->foreign('film')->references('id')->on('films');
            $table->integer('hall');
            $table->foreign('hall')->references('id')->on('halls');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('film_sessions');
    }
};
