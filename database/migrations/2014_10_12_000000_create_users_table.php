<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
          $table->id();
          $table->string('username')->unique();
          $table->string('name');
          $table->string('email')->unique();
          $table->dateTime('email_verified_at')->nullable();
          $table->string('password');
          $table->string('avatar')->nullable();
          $table->integer('area');
          $table->integer('branch');
          $table->integer('role');
          $table->integer('status');
          $table->integer('inputby');
          $table->dateTime('lastlogin')->nullable();
          $table->rememberToken();
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
