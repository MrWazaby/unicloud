<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSheetsquizzsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sheetsquizzs', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('author');
            $table->bigInteger('course');
            $table->string('title');
            $table->text('content');
            $table->dateTime('creationDate');
            $table->dateTime('modificationDate');
            $table->smallInteger('score');
            $table->boolean('quizz');
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
        Schema::dropIfExists('sheetsquizzs');
    }
}
