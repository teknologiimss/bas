<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas_harian_results', function (Blueprint $table) {

            $table->id();

            $table->foreignId('item_id')
                ->constrained('fasilitas_harian_items')
                ->cascadeOnDelete();

            $table->date('tanggal');

            $table->enum('status', [
                'V',
                'X',
                'O'
            ]);

            $table->text('keterangan')->nullable();

            $table->string('nomor_spr')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas_harian_results');
    }
};