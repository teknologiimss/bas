<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlatAngkutChecksheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alat_angkut_checksheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detail_id')->constrained('alat_angkut_details')->onDelete('cascade');
            $table->integer('bulan'); // 1 - 12
            $table->string('status')->nullable(); // OK / NOK
            $table->date('tanggal')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['detail_id', 'bulan']); // penting!
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alat_angkut_checksheets');
    }
}
