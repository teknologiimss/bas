<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas_harians', function (Blueprint $table) {

            $table->id();

            $table->string('judul');

            $table->string('lokasi')->nullable();

            $table->string('bulan');

            $table->year('tahun');

            $table->string('dibuat_oleh')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas_harians');
    }
};