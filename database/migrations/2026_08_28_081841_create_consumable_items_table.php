<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('consumable_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consumable_folder_id')->constrained('consumable_folders')->onDelete('cascade');
            $table->string('sub_header');  // Misal: POMPA DISTRIBUSI, FCU (Fan Coil Unit)
            $table->string('komponen');
            $table->text('spesifikasi')->nullable();

            // Kolom Jumlah per Bulan
            $table->integer('jan')->default(0);
            $table->integer('feb')->default(0);
            $table->integer('mar')->default(0);
            $table->integer('apr')->default(0);
            $table->integer('mei')->default(0);
            $table->integer('juni')->default(0);
            $table->integer('juli')->default(0);
            $table->integer('agus')->default(0);
            $table->integer('sept')->default(0);
            $table->integer('okt')->default(0);
            $table->integer('nov')->default(0);
            $table->integer('des')->default(0);

            $table->string('satuan');  // pcs, pack, set, dll.
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consumable_items');
    }
};
