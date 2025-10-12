<table>
    <thead>
        <tr>

            <th>Nomor</th>
            <th>Nama</th>
            <th>NIP</th>
            <th>Rekening Mandiri</th>
            <th>Rekening BSI</th>
            <th>Rekrutmen</th>
            <th>Domisili</th>
            <th>Tanggal Masuk</th>
            <th>Masa Kerja Tahun</th>
            <th>Masa Kerja Bulan</th>
            <th>Status Pegawai</th>
            <th>Karyawan</th>
            <th>SK Pengangkatan / Kontrak</th>
            <th>Tanggal Pengangkatan / Kontrak</th>
            <th>Jabatan INKA</th>
            <th>Jabatan IMSS</th>
            <th>Column2</th>
            <th>Administrasi / Teknisi</th>
            <th>Lokasi Kerja</th>
            <th>Bagian / Proyek</th>
            <th>Departemen / Subproyek</th>
            <th>Divisi</th>
            <th>Direktorat</th>
            <th>Sertifikat</th>
            <th>Surat Peringatan</th>
            <th>Jenis Kelamin</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Usia</th>
            <th>Nomor KTP</th>
            <th>Alamat</th>
            <th>Nomor HP</th>
            <th>Nomor Whatsapp</th>
            <th>Nomor Link Aja</th>
            <th>Email</th>
            <th>BPJS Kesehatan</th>
            <th>BPJS Ketenagakerjaan</th>
            <th>Status Pernikahan</th>
            <th>Suami / Istri</th>
            <th>Anak ke 1</th>
            <th>Anak ke 2</th>
            <th>Anak ke 3</th>
            <th>Tambahan</th>
            <th>Ayah Kandung</th>
            <th>Ibu Kandung</th>
            <th>Ayah Mertua</th>
            <th>Ibu Mertua</th>
            <th>Jumlah Tanggungan</th>
            <th>Status Pajak</th>
            <th>Column1</th>
            <th>NPWP</th>
            <th>Agama</th>
            <th>Pendidikan Diakui</th>
            <th>Jurusan</th>
            <th>Almamater</th>
            <th>Tahun Lulus</th>
            <th>Pendidikan Terakhir</th>
            <th>Jurusan Terakhir</th>
            <th>Almamater Terakhir</th>
            <th>Tahun Lulus Terakhir</th>
            <th>MPP</th>
            <th>Pensiun</th>
            <th>Ukuran Baju</th>
            <th>Ukuran Celana</th>
            <th>Ukuran Sepatu</th>
            <th>Vaksin ke 1</th>
            <th>Vaksin ke 2</th>
            <th>Vaksin ke 3</th>
            <th>Nomor Kontrak</th>
            <th>Awal</th>
            <th>Akhir</th>
            <th>PB 1</th>
            <th>Nomor Kontrak 2</th>
            <th>Awal 2</th>
            <th>Akhir 2</th>
            <th>PB 2</th>
            <th>Nomor Kontrak 3</th>
            <th>Awal 3</th>
            <th>Akhir 3</th>
            <th>PB 3</th>




        </tr>
    </thead>
    <tbody>
        @foreach ($items as $key => $d)
            @php
                $data = $d->toArray();
            @endphp

            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->nip }}</td>
                <td>{{ $d->rekening_mandiri }}</td>
                <td>{{ $d->rekening_bsi }}</td>
                <td>{{ $d->rekrutmen }}</td>
                <td>{{ $d->domisili }}</td>
                <td>{{ $d->tanggal_masuk }}</td>
                <td>{{ $d->masa_kerja_tahun }}</td>
                <td>{{ $d->masa_kerja_bulan }}</td>
                <td>{{ $d->status_pegawai }}</td>
                <td>{{ $d->karyawan }}</td>
                <td>{{ $d->sk_pengangkatan_atau_kontrak }}</td>
                <td>{{ $d->tanggal_pengangkatan_atau_akhir_kontrak }}</td>
                <td>{{ $d->jabatan_inka }}</td>
                <td>{{ $d->jabatan_imss }}</td>
                <td>{{ $d->column2 }}</td>
                <td>{{ $d->administrasi_atau_teknisi }}</td>
                <td>{{ $d->lokasi_kerja }}</td>
                <td>{{ $d->bagian_atau_proyek }}</td>
                <td>{{ $d->departemen_atau_subproyek }}</td>
                <td>{{ $d->divisi }}</td>
                <td>{{ $d->direktorat }}</td>
                <td>{{ $d->sertifikat }}</td>
                <td>{{ $d->surat_peringatan }}</td>
                <td>{{ $d->jenis_kelamin }}</td>
                <td>{{ $d->tempat_lahir }}</td>
                <td>{{ $d->tanggal_lahir }}</td>
                <td>{{ $d->usia }}</td>
                <td>{{ $d->nomor_ktp }}</td>
                <td>{{ $d->alamat }}</td>
                <td>{{ $d->nomor_hp }}</td>
                <td>{{ $d->nomor_whatsapp }}</td>
                <td>{{ $d->nomor_linkaja }}</td>
                <td>{{ $d->email }}</td>
                <td>{{ $d->bpjs_kesehatan }}</td>
                <td>{{ $d->bpjs_ketenagakerjaan }}</td>
                <td>{{ $d->status_pernikahan }}</td>
                <td>{{ $d->suami_atau_istri }}</td>
                <td>{{ $d->anak_ke_1 }}</td>
                <td>{{ $d->anak_ke_2 }}</td>
                <td>{{ $d->anak_ke_3 }}</td>
                <td>{{ $d->tambahan }}</td>
                <td>{{ $d->ayah_kandung }}</td>
                <td>{{ $d->ibu_kandung }}</td>
                <td>{{ $d->ayah_mertua }}</td>
                <td>{{ $d->ibu_mertua }}</td>
                <td>{{ $d->jumlah_tanggungan }}</td>
                <td>{{ $d->status_pajak }}</td>
                <td>{{ $d->column1 }}</td>
                <td>{{ $d->npwp }}</td>
                <td>{{ $d->agama }}</td>
                <td>{{ $d->pendidikan_diakui }}</td>
                <td>{{ $d->jurusan }}</td>
                <td>{{ $d->almamater }}</td>
                <td>{{ $d->tahun_lulus }}</td>
                <td>{{ $d->pendidikan_terakhir }}</td>
                <td>{{ $d->jurusan_terakhir }}</td>
                <td>{{ $d->almamater_terakhir }}</td>
                <td>{{ $d->tahun_lulus_terakhir }}</td>
                <td>{{ $d->mpp }}</td>
                <td>{{ $d->pensiun }}</td>
                <td>{{ $d->ukuran_baju }}</td>
                <td>{{ $d->ukuran_celana }}</td>
                <td>{{ $d->ukuran_sepatu }}</td>
                <td>{{ $d->vaksin_1 }}</td>
                <td>{{ $d->vaksin_2 }}</td>
                <td>{{ $d->vaksin_3 }}</td>
                <td>{{ $d->nomor_kontrak }}</td>
                <td>{{ $d->awal }}</td>
                <td>{{ $d->akhir }}</td>
                <td>{{ $d->pb_1 }}</td>
                <td>{{ $d->nomor_kontrak2 }}</td>
                <td>{{ $d->awal2 }}</td>
                <td>{{ $d->akhir2 }}</td>
                <td>{{ $d->pb_2 }}</td>
                <td>{{ $d->nomor_kontrak3 }}</td>
                <td>{{ $d->awal3 }}</td>
                <td>{{ $d->akhir3 }}</td>
                <td>{{ $d->pb_3 }}</td>







            </tr>
        @endforeach
    </tbody>
</table>
