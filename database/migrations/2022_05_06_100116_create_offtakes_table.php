<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfftakesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('offtakes', function (Blueprint $table) {
      $table->id();
      $table->string('month_date')->nullable();
      $table->string('customer_id')->nullable();
      $table->string('name')->nullable();
      $table->string('segment')->nullable();
      $table->string('sku_code')->nullable();
      $table->string('description')->nullable();
      $table->float('qty_pcs', 8, 10)->nullable();
      $table->float('qty_cardboard', 8, 10)->nullable();
      $table->decimal('pgww', 15, 4)->nullable();
      $table->decimal('totmerch', 15, 4)->nullable();
      $table->decimal('totinv', 15, 4)->nullable();
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
    Schema::dropIfExists('offtakes');
  }
}
