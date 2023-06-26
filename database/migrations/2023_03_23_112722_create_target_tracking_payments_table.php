<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetTrackingPaymentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('target_tracking_payments', function (Blueprint $table) {
			$table->id();
			$table->string('area')->nullable();
			$table->string('branch')->nullable();
			$table->string('segment')->nullable();
			$table->decimal('target', 15, 4)->default(0);
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
		Schema::dropIfExists('target_tracking_payments');
	}
}
