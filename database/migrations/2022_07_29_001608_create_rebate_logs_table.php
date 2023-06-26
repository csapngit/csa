<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRebateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rebate_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('rebate');
            $table->string('nopengajuan');
            $table->integer('event');
            $table->datetime('eventdate');
            $table->integer('userid');
            $table->string('reff', 50)->nullable();
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
        Schema::dropIfExists('rebate_logs');
    }
}
