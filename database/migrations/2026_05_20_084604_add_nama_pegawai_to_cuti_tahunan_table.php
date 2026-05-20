<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNamaPegawaiToCutiTahunanTable extends Migration
{
    public function up()
    {
        Schema::table('cuti_tahunans', function (Blueprint $table) {

            $table->string('nama_pegawai')->after('id');

        });
    }

    public function down()
    {
        Schema::table('cuti_tahunans', function (Blueprint $table) {

            $table->dropColumn('nama_pegawai');

        });
    }
}