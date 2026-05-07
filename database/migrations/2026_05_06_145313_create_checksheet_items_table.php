<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecksheetItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checksheet_items', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('section_id')->constrained()->cascadeOnDelete();
            $table->foreignId('section_id')
      ->references('id')
      ->on('checksheet_sections')
      ->cascadeOnDelete();
            $table->string('uraian');  // contoh: Cek oli mesin
            $table->string('aktivitas')->nullable();
            $table->string('standar')->nullable();
            $table->integer('urutan')->default(0);
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
        Schema::dropIfExists('checksheet_items');
    }
}
