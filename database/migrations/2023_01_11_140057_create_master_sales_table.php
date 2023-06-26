<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterSalesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('master_sales', function (Blueprint $table) {
			$table->id();
			$table->string('sales_code')->nullable();
			$table->string('sr_code')->nullable();
			$table->string('name')->nullable();
			$table->string('type')->nullable();
			$table->string('regional')->nullable();
			$table->string('branch_code')->nullable();
			$table->string('branch_name')->nullable();
			$table->string('gender')->nullable();
			$table->string('identity_card')->nullable();
			$table->string('npwp')->nullable();
			$table->string('npwp_address')->nullable();
			$table->string('handphone')->nullable();
			$table->string('sfa_login')->nullable();
			$table->string('sfa_password')->nullable();
			$table->string('spv_code')->nullable();
			$table->string('spv_name')->nullable();
			$table->string('spv_address')->nullable();
			$table->string('spv_handphone')->nullable();
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
		Schema::dropIfExists('master_sales');
	}
}
