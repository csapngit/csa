<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetDsrsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('target_dsrs', function (Blueprint $table) {
			$table->id();
			$table->string('area')->nullable();
			$table->string('branch')->nullable();
			// $table->string('so_salesperson_id')->nullable();
			// $table->string('business')->nullable();
			$table->string('mapping')->nullable();
			$table->decimal('target_sales', 15, 4)->nullable();
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
		Schema::dropIfExists('target_dsrs');
	}
}
