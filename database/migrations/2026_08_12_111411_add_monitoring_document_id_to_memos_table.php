<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMonitoringDocumentIdToMemosTable extends Migration
{
    public function up(): void
    {
        Schema::table('memos', function (Blueprint $table) {
            $table
                ->foreignId('monitoring_document_id')
                ->nullable()
                ->constrained('monitoring_documents')
                ->onDelete('cascade');  // Jika dokumen dihapus, memo otomatis terhapus di database
        });
    }

    public function down(): void
    {
        Schema::table('memos', function (Blueprint $table) {
            $table->dropForeign(['monitoring_document_id']);
            $table->dropColumn('monitoring_document_id');
        });
    }
}
