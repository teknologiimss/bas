<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailSppdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_sppd', function (Blueprint $table) {
            $table->id();
            $table->integer('id_sppd');
            $table->string('nama')->nullable();
            $table->string('nip')->nullable();
            $table->string('golongan')->nullable();
            $table->string('unit_kerja')->nullable();
            $table->string('hari')->nullable();
            $table->string('tarif')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('jenis_kendaraan')->nullable();
            $table->date('tanggal');
            $table->string('lampiran')->nullable();
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
        Schema::dropIfExists('detail_sppd');
    }
}
