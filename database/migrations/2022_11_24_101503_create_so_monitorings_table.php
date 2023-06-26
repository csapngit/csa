<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoMonitoringsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('so_monitorings', function (Blueprint $table) {
			$table->id();
			$table->string('area')->nullable();
			$table->string('type')->nullable();
			$table->string('branch')->nullable();
			$table->string('sales_per_id')->nullable();
			$table->timestamp('order_date')->nullable();
			$table->string('order_number')->nullable();
			$table->string('shipper_id')->nullable();
			$table->string('customer_id')->nullable();
			$table->string('customer_name')->nullable();
			$table->float('qty_order')->nullable();
			// $table->float('total_order')->nullable();
			$table->decimal('total_order', 15)->nullable();
			$table->float('qty_shipper')->nullable();
			$table->float('totmerch')->nullable();
			$table->string('brand')->nullable();
			$table->string('inventory_id')->nullable();
			$table->string('description')->nullable();
			$table->string('SoSt')->nullable();
			$table->string('SoCan')->nullable();
			$table->string('ShSt')->nullable();
			$table->string('ShCan')->nullable();
			$table->string('CreditHold')->nullable();
			$table->string('entry_po')->nullable();
			$table->string('LineRef')->nullable();
			$table->string('OrdLineRef')->nullable();
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
		Schema::dropIfExists('so_monitorings');
	}
}
