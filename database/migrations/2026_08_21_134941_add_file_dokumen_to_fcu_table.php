<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileDokumenToFcuTable extends Migration
{
    public function up(): void
    {
        Schema::table('fcu_monitorings', function (Blueprint $table) {
            $table->string('file_dokumen')->nullable()->after('kesimpulan');
        });
    }

    public function down(): void
    {
        Schema::table('fcu_monitorings', function (Blueprint $table) {
            $table->dropColumn('file_dokumen');
        });
    }
}
