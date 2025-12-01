<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailMroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('detail_mro')) {
            Schema::create('detail_mro', function (Blueprint $table) {
                $table->id();
                $table->integer('mro_id');
                $table->integer('nomor_dokumen');
                $table->date('tanggal_dokumen');
                $table->integer('perihal');
                $table->integer('keterangan');
                $table->integer('lampiran');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_mro');
    }
}
