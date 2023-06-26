<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('approves', function (Blueprint $table) {
      $table->id();
      $table->foreignId('key_id')->nullable()->constrained();
      $table->string('attachment_um')->nullable();
      $table->string('attachment_rm')->nullable();
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
    Schema::dropIfExists('approves');
  }
}
