<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoggersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('loggers', function (Blueprint $table) {
			$table->id();
			$table->foreignId('reference_id'); // ID yang di create/edit
			$table->string('reference_type'); // Nama table
			$table->string('action'); // action methode: Create/Edit/Delete
			$table->foreignId('executor_id')->constrained('users');
			$table->json('data');
			$table->timestamp('executed_at');
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
		Schema::dropIfExists('loggers');
	}
}
