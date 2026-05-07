<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecksheetSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checksheet_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checksheet_id')->constrained()->cascadeOnDelete();
            $table->string('nama_section');  // contoh: Sistem Mesin
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
        Schema::dropIfExists('checksheet_sections');
    }
}
