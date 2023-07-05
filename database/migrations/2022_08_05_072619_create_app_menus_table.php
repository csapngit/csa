<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppMenusTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('app_menus', function (Blueprint $table) {
			$table->id();
			$table->string('title');
			$table->string('page')->nullable();
			$table->integer('icon')->nullable();
			$table->boolean('bullet');
			$table->boolean('root');
			$table->boolean('newtab');
			$table->integer('header')->nullable();
			$table->integer('order');
			$table->string('group_code')->nullable(); //Newly added
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
		Schema::dropIfExists('app_menus');
	}
}
