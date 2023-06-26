<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingPaymentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tracking_payments', function (Blueprint $table) {
			$table->id();
			$table->string('area')->nullable();
			$table->string('branch')->nullable();
			$table->string('ket')->nullable();
			$table->string('classid')->nullable();
			$table->string('segment')->nullable();
			$table->string('doc_type')->nullable();
			$table->decimal('amount', 15, 4)->nullable();
			$table->string('doc_date')->nullable();
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
		Schema::dropIfExists('tracking_payments');
	}
}
