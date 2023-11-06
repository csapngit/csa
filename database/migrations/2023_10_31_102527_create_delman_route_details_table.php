<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelmanRouteDetailsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('delman_route_details', function (Blueprint $table) {
			$table->id();
			$table->float('nomor_do')->nullable();
			$table->string('item_code')->nullable();
			$table->string('item_desc')->nullable();
			$table->float('qty')->nullable();
			$table->float('price')->nullable();
			$table->float('total')->nullable();
			$table->integer('status')->nullable();
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
		Schema::dropIfExists('delman_route_details');
	}
}
