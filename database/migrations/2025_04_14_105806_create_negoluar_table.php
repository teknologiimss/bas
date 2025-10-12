<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNegoluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('negoluar', function (Blueprint $table) {
            $table->id();
            $table->string('id_pr');
            $table->string('nomor_pr');
            $table->integer('vendor_id');
            $table->string('nomor_negoluar');
            $table->date('tanggal_negoluar');
            $table->string('batas_negoluar');
            $table->string('perihal');
            $table->string('penerima');
            $table->string('alamat');
            $table->integer('lampiran');
            $table->string('no_jawaban_vendor');
            $table->string('franco');
            $table->string('keterangan_negoluar');
            
            
            
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
        Schema::dropIfExists('negoluar');
    }
}
