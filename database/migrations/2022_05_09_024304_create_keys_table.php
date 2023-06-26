<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeysTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('keys', function (Blueprint $table) {
      $table->id();
      $table->string('name')->nullable();
      $table->string('status_active')->nullable();
      $table->tinyInteger('status_um')->default(0);
      $table->tinyInteger('status_rm')->default(0);
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
    Schema::dropIfExists('keys');
  }
}
