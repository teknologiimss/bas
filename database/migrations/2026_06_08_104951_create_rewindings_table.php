<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewindingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewindings', function (Blueprint $table) {
            $table->id();

            $table->string('no_sjn');

            $table->date('tanggal_sjn_keluar');

            $table
                ->string('lampiran_sjn_keluar')
                ->nullable();

            $table
                ->string('nama_lampiran_keluar')
                ->nullable();

            $table
                ->date('tanggal_sjn_masuk')
                ->nullable();

            $table
                ->string('lampiran_sjn_masuk')
                ->nullable();

            $table
                ->string('nama_lampiran_masuk')
                ->nullable();

            $table
                ->text('deskripsi')
                ->nullable();

            $table->enum('status', [
                'Open',
                'Closed'
            ])->default('Open');

            $table
                ->text('keterangan')
                ->nullable();

            $table
                ->string('no_sppjp')
                ->nullable();

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
        Schema::dropIfExists('rewindings');
    }
}
