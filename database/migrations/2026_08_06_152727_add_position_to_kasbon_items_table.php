<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kasbon_items', function (Blueprint $table) {
            // Tambahkan kolom position ber-tipe integer untuk menyimpan urutan
            $table->integer('position')->default(0)->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('kasbon_items', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
};