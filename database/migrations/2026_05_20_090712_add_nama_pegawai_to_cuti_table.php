<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNamaPegawaiToCutiTable extends Migration
{
    public function up()
    {
        Schema::table('cuti', function (Blueprint $table) {

            $table->string('nama_pegawai')
                ->nullable()
                ->after('user_id');

        });
    }

    public function down()
    {
        Schema::table('cuti', function (Blueprint $table) {

            $table->dropColumn('nama_pegawai');

        });
    }
}