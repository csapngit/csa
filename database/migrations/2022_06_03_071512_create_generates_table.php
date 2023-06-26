<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneratesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('generates', function (Blueprint $table) {
      $table->id();
      $table->string('area')->nullable();
      $table->foreignId('key_id')->nullable()->constrained();
      $table->foreignId('program_id')->nullable()->constrained();
      $table->foreignId('master_branch_id')->nullable()->constrained();
      $table->string('customer_id')->nullable();
      $table->string('name')->nullable();
      $table->string('sales_person')->nullable();
      $table->decimal('target', 15, 4)->nullable();
      $table->decimal('offtakes', 15, 4)->nullable();
      $table->tinyInteger('is_active_display')->nullable();
      $table->decimal('incentive_display', 15, 4)->nullable();
      $table->decimal('incentive_volume', 15, 4)->nullable();
      $table->tinyInteger('pkp')->nullable();
      $table->decimal('tax_display_pkp', 15, 4)->nullable();
      $table->decimal('tax_display_non_pkp', 15, 4)->nullable();
      $table->decimal('tax_volume_pkp', 15, 4)->nullable();
      $table->decimal('tax_volume_non_pkp', 15, 4)->nullable();
      $table->tinyInteger('is_company')->nullable();
      $table->decimal('tax_company', 15, 4)->nullable();
      $table->string('description')->nullable();
      $table->float('qty_pcs', 8, 10)->nullable();
      $table->float('qty_carton', 8, 10)->nullable();
      $table->tinyInteger('voucher_publish')->nullable();
      $table->string('shipperid')->nullable();
      $table->string('invcnbr')->nullable();
      $table->decimal('TotInvc', 15, 4)->nullable();
      $table->tinyInteger('printed')->nullable();
      $table->dateTime('start_date')->nullable();
      $table->dateTime('end_date')->nullable();
			$table->tinyInteger('can_publish')->nullable();
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
    Schema::dropIfExists('generates');
  }
}
