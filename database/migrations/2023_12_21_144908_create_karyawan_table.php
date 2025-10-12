<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // public function up()
    // {
    //     Schema::create('karyawan', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('nip');
    //         $table->string('nama');
    //         $table->date('tanggal_masuk');
    //         $table->string('status_pegawai');
    //         $table->string('rekrutmen');
    //         $table->string('domisili');
    //         $table->string('rekening_mandiri');
    //         $table->string('rekening_bsi');
    //         $table->string('sk_pengangkatan_atau_kontrak');
    //         $table->date('tanggal_pengangkatan_atau_akhir_kontrak');
    //         $table->string('jabatan_inka');
    //         $table->string('jabatan_imss');
    //         $table->string('administrasi_atau_teknisi');
    //         $table->string('lokasi_kerja');
    //         $table->string('bagian_atau_proyek');
    //         $table->string('departemen_atau_subproyek');
    //         $table->string('divisi');
    //         $table->string('direktorat');
    //         $table->string('sertifikat');
    //         $table->string('surat_peringatan');
    //         $table->string('jenis_kelamin');
    //         $table->string('tempat_lahir');
    //         $table->date('tanggal_lahir');
    //         $table->string('nomor_ktp');
    //         $table->string('alamat');
    //         $table->string('nomor_hp');
    //         $table->string('email');
    //         $table->string('bpjs_kesehatan');
    //         $table->string('bpjs_ketenagakerjaan');
    //         $table->string('status_pernikahan');
    //         $table->string('suami_atau_istri');
    //         $table->string('anak_ke_1');
    //         $table->string('anak_ke_2');
    //         $table->string('anak_ke_3');
    //         $table->string('tambahan');
    //         $table->string('ayah_kandung');
    //         $table->string('ibu_kandung');
    //         $table->string('ayah_mertua');
    //         $table->string('ibu_mertua');
    //         $table->string('jumlah_tanggungan');
    //         $table->string('status_pajak');
    //         $table->string('npwp');
    //         $table->string('agama');
    //         $table->string('pendidikan_diakui');
    //         $table->string('jurusan');
    //         $table->string('almamater');
    //         $table->string('tahun_lulus');
    //         $table->string('pendidikan_terakhir');
    //         $table->string('jurusan_terakhir');
    //         $table->string('almamater_terakhir');
    //         $table->string('tahun_lulus_terakhir');
    //         $table->string('mpp');
    //         $table->date('pensiun');
    //         $table->string('ukuran_baju');
    //         $table->string('ukuran_celana');
    //         $table->string('ukuran_sepatu');
    //         $table->date('vaksin_1');
    //         $table->date('vaksin_2');
    //         $table->date('vaksin_3');
    //         $table->timestamps();
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  *
    //  * @return void
    //  */
    // public function down()
    // {
    //     Schema::dropIfExists('karyawan');
    // }



    public function up(): void
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            // $table->string('no')->nullable();
            $table->string('nama')->nullable();
            $table->string('nip')->nullable();
            $table->string('rekening_mandiri')->nullable();
            $table->string('rekening_bsi')->nullable();
            $table->string('rekrutmen')->nullable();
            $table->string('domisili')->nullable();
            $table->date('tanggal_masuk')->nullable();
            $table->integer('masa_kerja_tahun')->nullable();
            $table->integer('masa_kerja_bulan')->nullable();
            $table->string('status_pegawai')->nullable();
            $table->string('karyawan')->nullable();
            $table->string('sk_pengangkatan_atau_kontrak')->nullable();
            $table->date('tanggal_pengangkatan_atau_akhir_kontrak')->nullable();
            $table->string('jabatan_inka')->nullable();
            $table->string('jabatan_imss')->nullable();
            $table->string('column2')->nullable();
            $table->string('administrasi_atau_teknisi')->nullable();
            $table->string('lokasi_kerja')->nullable();
            $table->string('bagian_atau_proyek')->nullable();
            $table->string('departemen_atau_subproyek')->nullable();
            $table->string('divisi')->nullable();
            $table->string('direktorat')->nullable();
            $table->string('sertifikat')->nullable();
            $table->string('surat_peringatan')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->integer('usia')->nullable();
            $table->string('nomor_ktp')->nullable();
            $table->text('alamat')->nullable();
            $table->string('nomor_hp')->nullable();
            $table->string('nomor_whatsapp')->nullable();
            $table->string('nomor_linkaja')->nullable();
            $table->string('email')->nullable();
            $table->string('bpjs_kesehatan')->nullable();
            $table->string('bpjs_ketenagakerjaan')->nullable();
            $table->string('status_pernikahan')->nullable();
            $table->string('suami_atau_istri')->nullable();
            $table->string('anak_ke_1')->nullable();
            $table->string('anak_ke_2')->nullable();
            $table->string('anak_ke_3')->nullable();
            $table->string('tambahan')->nullable();
            $table->string('ayah_kandung')->nullable();
            $table->string('ibu_kandung')->nullable();
            $table->string('ayah_mertua')->nullable();
            $table->string('ibu_mertua')->nullable();
            $table->integer('jumlah_tanggungan')->nullable();
            $table->string('status_pajak')->nullable();
            $table->string('column1')->nullable();
            $table->string('npwp')->nullable();
            $table->string('agama')->nullable();
            $table->string('pendidikan_diakui')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('almamater')->nullable();
            $table->string('tahun_lulus')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('jurusan_terakhir')->nullable();
            $table->string('almamater_terakhir')->nullable();
            $table->string('tahun_lulus_terakhir')->nullable();
            $table->date('mpp')->nullable();
            $table->date('pensiun')->nullable();
            $table->string('ukuran_baju')->nullable();
            $table->string('ukuran_celana')->nullable();
            $table->string('ukuran_sepatu')->nullable();
            $table->date('vaksin_1')->nullable();
            $table->date('vaksin_2')->nullable();
            $table->date('vaksin_3')->nullable();
            $table->string('nomor_kontrak')->nullable();
            $table->date('awal')->nullable();
            $table->date('akhir')->nullable();
            $table->string('pb_1')->nullable();
            $table->string('nomor_kontrak2')->nullable();
            $table->date('awal2')->nullable();
            $table->date('akhir2')->nullable();
            $table->string('pb_2')->nullable();
            $table->string('nomor_kontrak3')->nullable();
            $table->date('awal3')->nullable();
            $table->date('akhir3')->nullable();
            $table->string('pb_3')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }






}
