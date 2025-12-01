<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('monitorings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proyek_id');
            $table->string('po_nota_dinas');
            $table->string('nama_pekerjaan');
            $table->string('jenis_pekerjaan');
            $table->date('tanggal_kontrak');
            $table->date('tanggal_selesai_kontrak');
            $table->enum('status', ['Open', 'Closed', 'On Hold'])->default('Open');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('proyek_id')->references('id')->on('proyeks')->onDelete('cascade');
        });

        Schema::create('monitoring_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('monitoring_id');
            $table->string('nama_dokumen');
            $table->string('file_path');
            $table->timestamps();

            $table->foreign('monitoring_id')->references('id')->on('monitorings')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitoring_documents');
        Schema::dropIfExists('monitorings');
    }
};