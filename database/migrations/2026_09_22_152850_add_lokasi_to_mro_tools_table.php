<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLokasiToMroToolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mro_tools', function (Blueprint $table) {
            // Menambahkan kolom lokasi setelah kolom kondisi
            $table->string('lokasi')->nullable()->after('kondisi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mro_tools', function (Blueprint $table) {
            // Menghapus kolom lokasi saat rollback
            $table->dropColumn('lokasi');
        });
    }
}