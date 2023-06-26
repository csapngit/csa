<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramHasProductTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('program_has_product', function (Blueprint $table) {
			$table->id();
			$table->foreignId('program_id')->nullable()->constrained()->cascadeOnDelete();
			// $table->foreignId('master_inventory_id')->nullable()->constrained()->cascadeOnDelete();
			$table->string('inventory_id')->index()->nullable();
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
		Schema::dropIfExists('program_has_product');
	}
}
