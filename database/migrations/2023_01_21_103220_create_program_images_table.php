<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramImagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('program_images', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
			$table->foreignId('program_id')->nullable()->constrained()->cascadeOnDelete();
			$table->string('customer_id')->nullable();
			$table->string('inventory_id')->nullable();
			$table->decimal('normal_price', 15, 4)->nullable();
			$table->decimal('promo_price', 15, 4)->nullable();
			$table->decimal('depth')->nullable();
			$table->string('text')->nullable();
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
		Schema::dropIfExists('program_images');
	}
}
