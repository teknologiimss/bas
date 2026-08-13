<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memos', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel monitoring (atau PO)
            $table->foreignId('monitoring_id')->constrained('monitorings')->onDelete('cascade');
            
            // Header Memo
            $table->string('nomor_memo');
            $table->date('tanggal');
            $table->string('hal');
            $table->string('dari');
            $table->string('kepada');
            
            // Isi Memo
            $table->text('pembuka')->nullable(); // cth: Berdasarkan...
            $table->text('isi_utama')->nullable(); // cth: Sehubungan dengan...
            
            // Opsi Tabel
            $table->boolean('has_table')->default(false);
            
            // Penutup & TTD
            $table->text('catatan_note')->nullable(); // Note / Catatan Tambahan
            $table->text('penutup')->nullable(); // Demikian memo ini...
            $table->string('jabatan_penandatangan')->default('Kepala Divisi Wilayah II');
            $table->string('nama_penandatangan')->nullable();
            
            // File PDF tersimpan
            $table->string('pdf_path')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memos');
    }
};