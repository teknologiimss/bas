<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {

            $table->dropForeign(['proyek_id']);

            $table->foreign('proyek_id')
                ->references('id')
                ->on('perencanaan_proyeks')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {

            $table->dropForeign(['proyek_id']);

            $table->foreign('proyek_id')
                ->references('id')
                ->on('proyeks');
        });
    }
};