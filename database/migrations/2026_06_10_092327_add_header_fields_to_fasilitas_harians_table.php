<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHeaderFieldsToFasilitasHariansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fasilitas_harians', function ($table) {
            $table->string('nomor_dokumen')->nullable()->after('judul');

            $table->string('nomor_fasilitas')->nullable()->after('nomor_dokumen');

            $table->string('nomor_sertifikasi')->nullable()->after('nomor_fasilitas');

            $table->string('nama_alat')->nullable()->after('nomor_sertifikasi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fasilitas_harians', function ($table) {
            $table->dropColumn([
                'nomor_dokumen',
                'nomor_fasilitas',
                'nomor_sertifikasi',
                'nama_alat'
            ]);
        });
    }
}
