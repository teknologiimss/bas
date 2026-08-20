<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fcu_results', function (Blueprint $table) {
            // Menambahkan kolom unit setelah fcu_detail_id (boleh null/default 'fcu1')
            $table->string('unit')->default('fcu1')->after('fcu_detail_id');
        });
    }

    public function down(): void
    {
        Schema::table('fcu_results', function (Blueprint $table) {
            $table->dropColumn('unit');
        });
    }
};