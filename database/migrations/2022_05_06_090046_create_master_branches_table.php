<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_branches', function (Blueprint $table) {
          $table->id();
          $table->string('Area', 4);
          $table->string('Branch');
          $table->string('BranchName');
          $table->text('BranchAddress')->nullable();
          $table->string('Latitude')->nullable();
          $table->string('Longitude')->nullable();
          $table->integer('CreatedBy');
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
        Schema::dropIfExists('master_branches');
    }
}
