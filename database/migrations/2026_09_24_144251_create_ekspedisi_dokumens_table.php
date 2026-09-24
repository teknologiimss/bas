<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ekspedisi_dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  // Nama Pengirim (otomatis dari user login)
            $table->text('deskripsi');
            $table->string('diterima_oleh');
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->string('file_dokumen')->nullable();  // Menyimpan path upload dokumen
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ekspedisi_dokumens');
    }
};
