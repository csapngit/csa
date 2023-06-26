<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailySalesReportsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('daily_sales_reports', function (Blueprint $table) {
			$table->id();
			$table->string('branch')->nullable();
			$table->string('so_salesperson_id')->nullable();
			$table->string('business')->nullable(); // Reguler|RSU|CNR Project
			$table->string('mapping')->nullable(); // Motoris|Presell pareto|Presell reguler|SUBD
			$table->string('status_poc')->nullable();
			$table->string('status_oc')->nullable();
			$table->decimal('sales_order', 15, 4)->nullable();
			$table->decimal('delivery_order', 15, 4)->nullable();
			$table->decimal('ar_invoice', 15, 4)->nullable();
			$table->decimal('target_sales', 15, 4)->nullable();
			$table->decimal('balance', 15, 4)->nullable();
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
		Schema::dropIfExists('daily_sales_reports');
	}
}
