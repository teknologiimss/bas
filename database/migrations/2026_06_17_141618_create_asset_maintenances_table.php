<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_maintenances', function (Blueprint $table) {

            $table->id();

            $table->foreignId('asset_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->year('tahun');

            $table->tinyInteger('bulan');

            $table->tinyInteger('minggu');

            $table->boolean('planning')
                ->default(false);

            $table->boolean('realisasi')
                ->default(false);

            $table->date('tanggal_realisasi')
                ->nullable();

            $table->timestamps();

            $table->unique([
                'asset_id',
                'tahun',
                'bulan',
                'minggu'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'asset_maintenances'
        );
    }
};