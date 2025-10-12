<?php

namespace App\Imports;

use App\Models\Karyawan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class KaryawanImport implements ToCollection
{
    /**
     * @param Collection $collection
     */

    function classifyEmployee($code)
    {
        if (substr($code, 0, 2) === "99") {
            return "Organik INKA";
        } elseif (substr($code, 0, 2) === "97") {
            return "Organik IMSS";
        } elseif (substr($code, 0, 2) === "75") {
            return "Capeg";
        } elseif (substr($code, 0, 2) === "64") {
            return "PKWT";
        } else {
            return "Resign";
        }
    }

    public function collection(Collection $rows)
    {
        unset($rows[0]); // hapus header

        foreach ($rows as $row) {
            if ($row[1] != null) {
                // --- Konversi tanggal ---
                $tanggal_masuk = is_numeric($row[7]) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[7])->format('Y-m-d') : null;
                $tanggal_pengangkatan_atau_akhir_kontrak = is_numeric($row[13]) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[13])->format('Y-m-d') : null;
                $tanggal_lahir = is_numeric($row[27]) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[27])->format('Y-m-d') : null;
                $mpp = is_numeric($row[60]) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[60])->format('Y-m-d') : null;
                $pensiun = is_numeric($row[61]) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[61])->format('Y-m-d') : null;
                $vaksin_1 = is_numeric($row[65]) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[65])->format('Y-m-d') : null;
                $vaksin_2 = is_numeric($row[66]) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[66])->format('Y-m-d') : null;
                $vaksin_3 = is_numeric($row[67]) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[67])->format('Y-m-d') : null;

                $jumlahTanggungan = is_numeric($row[47]) ? $row[47] : $this->getCalculatedValue($row[47]);
                $statusPajak = is_numeric($row[48]) ? $row[48] : $this->getCalculatedValue($row[48]);

                // Cek apakah nip sudah ada
                $karyawan = Karyawan::where('nip', $row[2])->count();

                $data = [
                    'nama' => $row[1],
                    'nip' => $row[2],
                    'rekening_mandiri' => $row[3] ?? '',
                    'rekening_bsi' => $row[4] ?? '',
                    'rekrutmen' => $row[5] ?? '',
                    'domisili' => $row[6] ?? '',
                    'tanggal_masuk' => $tanggal_masuk,
                    'masa_kerja_tahun' => $row[8] ?? null,
                    'masa_kerja_bulan' => $row[9] ?? null,
                    'status_pegawai' => $this->classifyEmployee($row[2]),
                    'karyawan' => $row[11] ?? null,
                    'sk_pengangkatan_atau_kontrak' => $row[12] ?? '',
                    'tanggal_pengangkatan_atau_akhir_kontrak' => $tanggal_pengangkatan_atau_akhir_kontrak,
                    'jabatan_inka' => $row[14] ?? '',
                    'jabatan_imss' => $row[15] ?? '',
                    'column2' => $row[16] ?? null,
                    'administrasi_atau_teknisi' => $row[17] ?? '',
                    'lokasi_kerja' => $row[18] ?? '',
                    'bagian_atau_proyek' => $row[19] ?? '',
                    'departemen_atau_subproyek' => $row[20] ?? '',
                    'divisi' => $row[21] ?? '',
                    'direktorat' => $row[22] ?? '',
                    'sertifikat' => $row[23] ?? '',
                    'surat_peringatan' => $row[24] ?? '',
                    'jenis_kelamin' => $row[25] ?? '',
                    'tempat_lahir' => $row[26] ?? '',
                    'tanggal_lahir' => $tanggal_lahir,
                    'usia' => $row[28] ?? null,
                    'nomor_ktp' => $row[29] ?? '',
                    'alamat' => $row[30] ?? '',
                    'nomor_hp' => $row[31] ?? '',
                    'nomor_whatsapp' => $row[32] ?? null,
                    'nomor_linkaja' => $row[33] ?? null,
                    'email' => $row[34] ?? '',
                    'bpjs_kesehatan' => $row[35] ?? '',
                    'bpjs_ketenagakerjaan' => $row[36] ?? '',
                    'status_pernikahan' => $row[37] ?? '',
                    'suami_atau_istri' => $row[38] ?? '',
                    'anak_ke_1' => $row[39] ?? '',
                    'anak_ke_2' => $row[40] ?? '',
                    'anak_ke_3' => $row[41] ?? '',
                    'tambahan' => $row[42] ?? '',
                    'ayah_kandung' => $row[43] ?? '',
                    'ibu_kandung' => $row[44] ?? '',
                    'ayah_mertua' => $row[45] ?? '',
                    'ibu_mertua' => $row[46] ?? '',
                    'jumlah_tanggungan' => $jumlahTanggungan,
                    'status_pajak' => $statusPajak,
                    'column1' => $row[49] ?? null,
                    'npwp' => $row[50] ?? '',
                    'agama' => $row[51] ?? '',
                    'pendidikan_diakui' => $row[52] ?? '',
                    'jurusan' => $row[53] ?? '',
                    'almamater' => $row[54] ?? '',
                    'tahun_lulus' => $row[55] ?? '',
                    'pendidikan_terakhir' => $row[56] ?? '',
                    'jurusan_terakhir' => $row[57] ?? '',
                    'almamater_terakhir' => $row[58] ?? '',
                    'tahun_lulus_terakhir' => $row[59] ?? '',
                    'mpp' => $mpp,
                    'pensiun' => $pensiun,
                    'ukuran_baju' => $row[62] ?? '',
                    'ukuran_celana' => $row[63] ?? '',
                    'ukuran_sepatu' => $row[64] ?? '',
                    'vaksin_1' => $vaksin_1,
                    'vaksin_2' => $vaksin_2,
                    'vaksin_3' => $vaksin_3,
                    'nomor_kontrak' => $row[68] ?? null,
                    'awal' => $row[69] ?? null,
                    'akhir' => $row[70] ?? null,
                    'pb_1' => $row[71] ?? null,
                    'nomor_kontrak2' => $row[72] ?? null,
                    'awal2' => $row[73] ?? null,
                    'akhir2' => $row[74] ?? null,
                    'pb_2' => $row[75] ?? null,
                    'nomor_kontrak3' => $row[76] ?? null,
                    'awal3' => $row[77] ?? null,
                    'akhir3' => $row[78] ?? null,
                    'pb_3' => $row[79] ?? null,
                ];

                if ($karyawan == 0) {
                    Karyawan::create($data);
                } else {
                    Karyawan::where('nip', $row[2])->update($data);
                }
            }
        }
    }

    private function getCalculatedValue($cellValue)
    {
        return (is_numeric($cellValue)) ? $cellValue : (float) filter_var($cellValue, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
}
