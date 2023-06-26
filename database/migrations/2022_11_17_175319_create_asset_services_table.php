<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetServicesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('asset_services', function (Blueprint $table) {
			$table->id();
			$table->foreignId('asset_id')->nullable()->constrained();
			$table->timestamp('service_date')->nullable();
			$table->string('description')->nullable();
			$table->timestamp('return_date')->nullable();
			$table->timestamps();
			$table->timestamp('deleted_at')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('asset_services');
	}
}
