<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArdaysTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ardays', function (Blueprint $table) {
			$table->id();
			$table->string('area')->nullable();
			$table->string('branch')->nullable();
			$table->string('segment')->nullable();
			$table->string('jenis')->nullable();
			$table->decimal('amount', 15, 4)->nullable();
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
		Schema::dropIfExists('ardays');
	}
}
