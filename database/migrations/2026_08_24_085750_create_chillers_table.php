<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Utama Checksheet Chiller
        Schema::create('chillers', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->enum('jenis_perawatan', ['P1', 'P3', 'P6', 'P12']);
            $table->string('no_aset')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('no_chiller')->nullable();
            $table->enum('kesimpulan', ['SO', 'SO DENGAN CATATAN', 'TSO'])->nullable();
            $table->text('catatan')->nullable();
            $table->date('tanggal_pelaksanaan')->nullable();
            $table->string('durasi_pekerjaan')->nullable();
            $table->string('personil')->nullable();
            $table->timestamps();
        });

        // Tabel Detail Pekerjaan / Items
        Schema::create('chiller_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chiller_id')->constrained('chillers')->onDelete('cascade');
            $table->string('nomor')->nullable();
            $table->string('uraian_pekerjaan');
            $table->string('aktivitas_pekerjaan');
            $table->string('standar')->nullable();
            $table->enum('status', ['OK', 'NOK'])->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

        // Tabel Foto Hasil Inspeksi Mobile
        Schema::create('chiller_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chiller_item_id')->constrained('chiller_items')->onDelete('cascade');
            $table->string('foto');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chiller_photos');
        Schema::dropIfExists('chiller_items');
        Schema::dropIfExists('chillers');
    }
};