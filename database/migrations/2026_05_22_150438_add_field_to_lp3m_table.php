<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lp3m', function (Blueprint $table) {

            $table->text('deskripsi')->nullable();

            $table->enum('status', ['OPEN', 'CLOSED'])
                ->default('OPEN');

            $table->text('keterangan')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('lp3m', function (Blueprint $table) {

            $table->dropColumn([
                'deskripsi',
                'status',
                'keterangan'
            ]);

        });
    }
};