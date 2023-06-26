<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterInventoriesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('master_inventories', function (Blueprint $table) {
			$table->id();
			$table->string('Area', 4);
			$table->string('ClassID', 6);
			$table->dateTime('Crtd_DateTime');
			$table->string('Crtd_Prog', 8);
			$table->string('Crtd_User', 10);
			$table->string('Descr', 60);
			$table->string('DfltPOUnit', 6);
			$table->string('DfltSite', 10);
			$table->string('DfltSOUnit', 6);
			$table->string('DfltWhseLoc', 10);
			$table->float('DirStdCost', 6);
			$table->string('InvtID', 30);
			$table->float('LastBookQty');
			$table->float('LastCost');
			$table->dateTime('LastCountDate');
			$table->string('LastSiteID', 10);
			$table->float('LastStdCost');
			$table->float('LastVarAmt');
			$table->float('LastVarPct');
			$table->float('LastVarQty');
			$table->dateTime('LUpd_DateTime', 6);
			$table->string('LUpd_Prog', 8);
			$table->string('LUpd_User', 10);
			$table->string('MaterialType', 10);
			$table->string('PerNbr', 6);
			$table->string('Size', 10);
			$table->string('Status', 1);
			$table->float('StdCost');
			$table->dateTime('StdCostDate');
			$table->float('StkBasePrc');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('master_inventories');
	}
}
