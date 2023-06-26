<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRebateIcgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rebate_icg', function (Blueprint $table) {
            $table->id();
            $table->string('Category')->nullable();
            $table->string('SubCategory')->nullable();
            $table->string('IMCode')->nullable();
            $table->text('SKU')->nullable();
            $table->string('Lotsell')->nullable();
            $table->string('Channel')->nullable();
            $table->text('Remarks')->nullable();
            $table->text('Descr')->nullable();
            $table->text('FundName')->nullable();
            $table->string('PopCode')->nullable();
            $table->string('SID')->nullable();
            $table->string('IO')->nullable();
            $table->string('CE')->nullable();
            $table->string('Periode', 10)->nullable();
            $table->integer('Status');
            $table->float('Budget');
            $table->integer('InputBy');
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
        Schema::dropIfExists('rebate_icg');
    }
}
