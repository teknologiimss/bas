<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pekerjaan_mro_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pekerjaan_mro_id')->constrained('pekerjaan_mros')->onDelete('cascade');
            $table->string('item_pekerjaan');
            $table->string('satuan');
            $table->decimal('vol_rencana', 12, 2);
            $table->decimal('harga_satuan', 15, 2)->nullable();
            $table->json('progress_mingguan')->nullable();  // Menyimpan data vol_realisasi / progress per minggu
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pekerjaan_mro_items');
    }
};
