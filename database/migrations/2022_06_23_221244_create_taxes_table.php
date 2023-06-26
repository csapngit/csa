<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('taxes', function (Blueprint $table) {
      $table->id();
      $table->decimal('display_pkp')->nullable();
      $table->decimal('display_non_pkp')->nullable();
      $table->decimal('volume_pkp')->nullable();
      $table->decimal('volume_non_pkp')->nullable();
      $table->decimal('company')->nullable();
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
    Schema::dropIfExists('taxes');
  }
}
