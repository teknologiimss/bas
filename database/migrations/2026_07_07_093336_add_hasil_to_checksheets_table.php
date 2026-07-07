<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHasilToChecksheetsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('checksheets', function (Blueprint $table) {

            $table->enum('hasil', [
                'SO',
                'SO DENGAN CATATAN',
                'TSO'
            ])->nullable()->after('tanggal');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('checksheets', function (Blueprint $table) {

            $table->dropColumn('hasil');

        });
    }
}