<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('master_personils', function (Blueprint $table) {

            $table->string('jabatan')->nullable()->after('penempatan');

            $table->text('jobdesk')->nullable()->after('jabatan');

            $table->string('spesialisasi')->nullable()->after('jobdesk');

            $table->text('catatan')->nullable()->after('spesialisasi');

        });
    }

    public function down()
    {
        Schema::table('master_personils', function (Blueprint $table) {

            $table->dropColumn([
                'jabatan',
                'jobdesk',
                'spesialisasi',
                'catatan'
            ]);

        });
    }
};