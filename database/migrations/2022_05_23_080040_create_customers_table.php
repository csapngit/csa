<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('customers', function (Blueprint $table) {
      $table->id();
      $table->foreignId('program_id')->nullable()->constrained()->cascadeOnDelete();
      $table->string('customer_id')->nullable();
      $table->decimal('target', 15, 4)->nullable();
      $table->foreignId('program_tier_id')->nullable()->constrained();
      $table->tinyInteger('can_publish')->nullable()->default(0);
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
    Schema::dropIfExists('customers');
  }
}
