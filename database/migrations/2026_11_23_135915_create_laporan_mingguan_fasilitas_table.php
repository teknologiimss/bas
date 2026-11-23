<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laporan_mingguan_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_mulai');  // Senin
            $table->date('tanggal_selesai');  // Jumat
            $table->string('judul')->default('REKAP MINGGUAN PEMELIHARAAN FASILITAS & JASA LAINNYA');
            $table->text('catatan_mingguan')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->unique(['tanggal_mulai', 'tanggal_selesai']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_mingguan_fasilitas');
    }
};
