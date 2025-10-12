<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoiluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loiluar', function (Blueprint $table) {
            $table->id();
            $table->string('id_pr');
            $table->string('nomor_pr');
            $table->string('nomor_loiluar');
            $table->string('nomor_po');
            $table->string('lampiran');
            $table->string('vendor_id');
            $table->date('tanggal_loiluar');
            $table->date('tanggal_po');
            $table->string('batas_loiluar');
            $table->string('perihal');
            $table->string('keterangan_loiluar')->nullable();
            $table->string('penerima');
            $table->string('alamat');
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
        Schema::dropIfExists('loiluar');
    }
}
