<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLampiranToAlatAngkutChecksheetsTable extends Migration
{
    public function up()
    {
        Schema::table('alat_angkut_checksheets', function (Blueprint $table) {
            $table->string('lampiran')->nullable()->after('keterangan');
        });
    }

    public function down()
    {
        Schema::table('alat_angkut_checksheets', function (Blueprint $table) {
            $table->dropColumn('lampiran');
        });
    }
}