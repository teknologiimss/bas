<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanHarianFasilitasTables extends Migration
{
    public function up()
    {
        // 1. Tabel Header Laporan Harian
        Schema::create('laporan_harian_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->unique();
            $table->string('judul')->default('JOB DESK PEMELIHARAAN FASILITAS & JASA LAINNYA');
            $table->text('catatan')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        // 2. Tabel Detail Item Pekerjaan (Bagian A & Bagian B)
        Schema::create('laporan_harian_fasilitas_items', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('laporan_id')
                ->constrained('laporan_harian_fasilitas')
                ->onDelete('cascade');

            // 'A' = Pelayanan Fasilitas Angkut-Angkut, 'B' = Pekerjaan Lain
            $table->enum('kelompok', ['A', 'B']);

            // Sub-kategori: Pengecekan Harian, Preventive Maintenance P1, SPR, Cuker, Pengiriman, Rewinding Motor, Sipil, Tambahan Kegiatan
            $table->string('sub_kategori');

            // Deskripsi utama (misal: "Forklift ( D-01 ; D-02 ... )" atau "Update 5R Interior 612 TS 41 Tahap 1")
            $table->text('deskripsi');

            // Opsional: sub-item bernomor seperti list K102616, K102615, dst. (disimpan JSON)
            $table->json('sub_items')->nullable();

            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        // 3. Tabel Daftar Team yang Bertugas pada Tanggal Tersebut
        Schema::create('laporan_harian_fasilitas_teams', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('laporan_id')
                ->constrained('laporan_harian_fasilitas')
                ->onDelete('cascade');
            $table->string('nama_personil');
            $table->string('keterangan')->nullable();  // Contoh: Perbantuan Wil 1, CT, BWI
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_harian_fasilitas_teams');
        Schema::dropIfExists('laporan_harian_fasilitas_items');
        Schema::dropIfExists('laporan_harian_fasilitas');
    }
}
