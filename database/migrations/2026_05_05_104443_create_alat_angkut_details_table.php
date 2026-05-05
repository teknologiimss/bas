<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlatAngkutDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alat_angkut_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alat_id')->constrained('alat_angkuts')->onDelete('cascade');

            $table->string('unit')->nullable();
            $table->string('no_lambung')->nullable();
            $table->string('kapasitas')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('no_kontrak')->nullable();
            $table->string('aset')->nullable();
            $table->string('model_sn')->nullable();
            $table->date('tgl_kontrak')->nullable();
            $table->date('tgl_habis')->nullable();
            $table->string('kontrak_dgn')->nullable();
            $table->string('thn_kedatangan')->nullable();

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
        Schema::dropIfExists('alat_angkut_details');
    }
}
