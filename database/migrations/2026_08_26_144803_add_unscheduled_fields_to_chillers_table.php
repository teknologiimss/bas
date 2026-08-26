<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah 'chilliers' menjadi 'chillers'
        Schema::table('chillers', function (Blueprint $table) {
            $table->string('no_form_unscheduled')->nullable()->after('jenis_perawatan');
            $table->string('status_kondisi')->nullable()->comment('OK / NOK')->after('personil');
            $table->text('jenis_kerusakan')->nullable()->after('status_kondisi');
            $table->text('tindak_lanjut')->nullable()->after('jenis_kerusakan');
        });
    }

    public function down(): void
    {
        // Ubah 'chilliers' menjadi 'chillers'
        Schema::table('chillers', function (Blueprint $table) {
            $table->dropColumn([
                'no_form_unscheduled',
                'status_kondisi',
                'jenis_kerusakan',
                'tindak_lanjut'
            ]);
        });
    }
};