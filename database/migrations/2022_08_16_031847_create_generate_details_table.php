<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenerateDetailsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('generate_details', function (Blueprint $table) {
      $table->id();
      $table->foreignId('key_id')->constrained();
      $table->string('custId');
      $table->string('shipperid')->nullable();
      $table->string('invcnbr')->nullable();
      $table->float('TotInvc', 8, 10)->nullable();
      $table->tinyInteger('printed')->nullable();
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
    Schema::dropIfExists('generate_details');
  }
}
