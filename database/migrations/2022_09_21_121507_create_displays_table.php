<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisplaysTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('displays', function (Blueprint $table) {
      $table->id();
      $table->string('periode')->nullable();
      $table->string('customer_id')->nullable();
      $table->decimal('target', 15, 4)->nullable()->default(0);
      $table->integer('actual')->nullable();
      $table->tinyInteger('psku')->nullable()->default(0);
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
    Schema::dropIfExists('displays');
  }
}
