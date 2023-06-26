<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramDetailsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('program_details', function (Blueprint $table) {
			$table->id();
			$table->foreignId('program_id')->index()->constrained()->cascadeOnDelete();
			$table->string('master_brand_id')->index()->nullable();
			$table->string('program_display_type_id')->index()->nullable();
			$table->string('sku_group_id')->index()->nullable();
			$table->tinyInteger('promo')->nullable();
			$table->decimal('depth')->nullable();
			$table->decimal('cut_price', 15, 4)->nullable();
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
		Schema::dropIfExists('program_details');
	}
}
