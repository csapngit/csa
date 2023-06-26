<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assets', function (Blueprint $table) {
			$table->id();
			$table->string('barcode')->unique()->nullable();
			$table->foreignId('category_id')->nullable()->constrained('asset_categories');
			$table->string('brand')->nullable();
			$table->string('serial_number')->nullable();
			$table->timestamp('purchase_date')->nullable();
			$table->string('name')->nullable();
			$table->foreignId('division_id')->nullable()->constrained();
			$table->foreignId('branch_id')->nullable()->constrained('master_branches');
			$table->timestamp('lend_date')->nullable();
			$table->timestamp('return_date')->nullable();
			$table->string('description')->nullable();
			$table->timestamps();
			$table->timestamp('deleted_at')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('assets');
	}
}
