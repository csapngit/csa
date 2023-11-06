<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelmanRoutesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('delman_routes', function (Blueprint $table) {
			$table->id();
			$table->string('delman_id', 10);
			$table->string('site_id', 10);
			$table->string('nomor_do');
			$table->date('order_date');
			$table->string('card_code');
			$table->string('card_name')->nullable();
			$table->text('address')->nullable();
			$table->text('latitude')->nullable();
			$table->text('longitude')->nullable();
			$table->string('segment')->nullable();
			$table->string('sales_code')->nullable();
			$table->text('store_picture')->nullable();
			$table->text('invoice_picture')->nullable();
			$table->text('note')->nullable();
			$table->string('actual_latitude')->nullable();
			$table->string('actual_longitude')->nullable();
			$table->float('distance')->nullable();
			$table->integer('status_routing')->nullable();
			$table->integer('status_delivery')->nullable();
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
		Schema::dropIfExists('delman_routes');
	}
}
