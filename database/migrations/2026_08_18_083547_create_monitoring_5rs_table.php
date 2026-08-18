<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monitoring_5rs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('folder_id')->constrained('folder_monitoring_5rs')->onDelete('cascade');
            $table->text('deskripsi_pekerjaan')->nullable();
            $table->string('nomor_kontrak')->nullable();
            $table->date('tanggal_kontrak')->nullable();
            $table->date('selesai_kontrak')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitoring_5rs');
    }
};