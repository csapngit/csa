<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('programs', function (Blueprint $table) {
      $table->id();
      $table->string('area')->nullable();
      $table->string('name')->nullable();
      $table->foreignId('program_type_id')->nullable()->constrained();
      $table->tinyInteger('is_active')->default(1)->nullable();
      $table->timestamp('valid_from')->nullable();
      $table->timestamp('valid_until')->nullable();
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
    Schema::dropIfExists('programs');
  }
}
