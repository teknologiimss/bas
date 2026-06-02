<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lp3m', function (Blueprint $table) {
            $table->id();

            $table->string('spr_no')->nullable();

            $table->text('hasil_pengukuran')->nullable();
            $table->text('penyebab_kerusakan')->nullable();

            // penyebab kerusakan
            $table->boolean('aus')->default(false);
            $table->boolean('retak')->default(false);
            $table->boolean('komponen_tak_berfungsi')->default(false);
            $table->boolean('kelebihan_beban')->default(false);
            $table->boolean('salah_operasi')->default(false);
            $table->boolean('kelainan')->default(false);
            $table->boolean('kecelakaan')->default(false);
            $table->boolean('lain_lain_kerusakan')->default(false);

            // pekerjaan
            $table->text('nama')->nullable();
            $table->date('tanggal')->nullable();
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->text('pekerjaan')->nullable();

            // tindakan
            $table->boolean('komponen_diganti')->default(false);
            $table->boolean('diperiksa_disetel')->default(false);
            $table->boolean('diperbaiki_dibuat')->default(false);
            $table->boolean('dimodifikasi')->default(false);
            $table->boolean('dipindah_pasang_baru')->default(false);
            $table->boolean('diperlukan_evaluasi')->default(false);
            $table->boolean('lain_lain_tindakan')->default(false);

            // sparepart
            $table->string('nama_barang')->nullable();
            $table->string('kode_barang')->nullable();
            $table->integer('jumlah')->default(0);

            $table->date('tanggal_selesai')->nullable();
            $table->time('jam_selesai_detail')->nullable();

            $table->text('detail_penyelesaian')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lp3m');
    }
};