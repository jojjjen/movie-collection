<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('genre', 100);
            $table->unsignedSmallInteger('release_year');
            $table->string('director');
            $table->enum('status', ['Watched', 'Unwatched'])->default('Unwatched');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
