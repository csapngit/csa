<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRebateHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rebate_headers', function (Blueprint $table) {
            $table->id();
            $table->string('nomor', 25);
            $table->string('nomorkwitansi', 20)->nullable();
            $table->string('custid', 20);
            $table->string('name', 200)->nullable();
            $table->integer('company')->nullable();
            $table->integer('pkp')->nullable();
            $table->string('jenispotongan');
            $table->float('total');
            $table->text('catatan')->nullable();
            $table->integer('userid');
            $table->integer('status');
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
        Schema::dropIfExists('rebate_headers');
    }
}
