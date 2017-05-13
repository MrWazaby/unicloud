<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('idUser');
            $table->string('mail');
            $table->string('password');
            $table->string('promo');
            $table->dateTime('registerDate');
            $table->dateTime('lastLogin');
            $table->string('lastName');
            $table->string('firstName');
            $table->string('avatar');
            $table->boolean('certified');
            $table->text('token');
            $table->string('ip');
            $table->bigInteger('score');
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
        Schema::dropIfExists('users');
    }
}
