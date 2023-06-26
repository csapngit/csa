<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramTiersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('program_tiers', function (Blueprint $table) {
      $table->id();
      $table->foreignId('program_id')->nullable()->constrained();
      $table->foreignId('incentive_type_id')->nullable()->constrained();
      $table->string('name')->nullable();
      $table->string('display')->nullable();
      $table->decimal('monthly_display')->nullable();
      $table->decimal('monthly_volume')->nullable();
      $table->foreignId('voucher_type_id')->nullable()->constrained();
			$table->decimal('minimum_purchase', 15, 4)->nullable();
			$table->decimal('maximum_purchase', 15, 4)->nullable();
			$table->integer('minimum_pcs')->nullable();
			$table->integer('maximum_pcs')->nullable();
			$table->decimal('cashback')->nullable();
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
    Schema::dropIfExists('program_tiers');
  }
}
