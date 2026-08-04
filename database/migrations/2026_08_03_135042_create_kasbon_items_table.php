<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kasbon_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kasbon_folder_id')->constrained('kasbon_folders')->onDelete('cascade');
            $table->string('deskripsi');
            $table->date('tanggal');
            $table->decimal('uang_masuk', 15, 2)->default(0);
            $table->decimal('uang_keluar', 15, 2)->default(0);
            $table->string('dokumen')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kasbon_items');
    }
};