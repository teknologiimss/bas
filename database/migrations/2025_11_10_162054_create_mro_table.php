<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // public function up()
    // {
    //     Schema::create('mro', function (Blueprint $table) {
    //         $table->id();
    //         $table->timestamps();
    //     });
    // }

    public function up()
    {
        if (!Schema::hasTable('mro')) {
            Schema::create('mro', function (Blueprint $table) {
                $table->id();
                $table->string('po_nodin');
                $table->string('judul_pekerjaan');
                $table->string('jenis_pekerjaan');
                $table->date('tanggal_kontrak');
                $table->date('selesai_kontrak');
                $table->string('customer');
                $table->string('keterangan');
                
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
        Schema::dropIfExists('mro');
    }
}
