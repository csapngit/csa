<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelmanVisit extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('delman_visit', function (Blueprint $table) {
			$table->id();
			$table->string('delman_id', 10);
			$table->date('tanggal');
			$table->dateTime('time_in');
			$table->dateTime('time_out')->nullable();
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
		Schema::dropIfExists('delman_visit');
	}
}
