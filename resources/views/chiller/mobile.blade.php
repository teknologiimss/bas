@extends('layouts.main')

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background: #eef4fb;
            font-family: 'Segoe UI', sans-serif;
        }

        .mobile-container {
            max-width: 720px;
            margin: auto;
            padding: 10px 10px 90px 10px;
        }

        .header-card {
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            color: white;
            border-radius: 22px;
            padding: 20px;
            margin-bottom: 18px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, .15);
        }

        .header-title {
            font-size: 18px;
            font-weight: 700;
        }

        .header-info {
            font-size: 13px;
            opacity: .95;
            margin-top: 12px;
            line-height: 1.8;
        }

        .item-card {
            background: #fff;
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 14px;
            border: 1px solid #dbeafe;
            box-shadow: 0 4px 14px rgba(0, 0, 0, .04);
        }

        .uraian-title {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            border-bottom: 2px solid #eff6ff;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }

        .detail-box {
            background: #f8fbff;
            border-radius: 12px;
            padding: 12px;
            margin-top: 10px;
            border-left: 4px solid #2563eb;
        }

        .detail-label {
            font-size: 11px;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .detail-value {
            font-size: 13px;
            color: #1e293b;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .radio-wrapper {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }

        .radio-wrapper input {
            display: none;
        }

        .btn-ok,
        .btn-nok {
            flex: 1;
            text-align: center;
            padding: 8px 10px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
            font-size: 12px;
        }

        .btn-ok {
            background: #f0fdf4;
            color: #16a34a;
            border: 1.5px solid #bbf7d0;
        }

        .btn-nok {
            background: #fef2f2;
            color: #dc2626;
            border: 1.5px solid #fecaca;
        }

        input:checked+.btn-ok {
            background: #16a34a;
            color: white;
            border-color: #16a34a;
            box-shadow: 0 3px 10px rgba(22, 163, 74, .25);
        }

        input:checked+.btn-nok {
            background: #dc2626;
            color: white;
            border-color: #dc2626;
            box-shadow: 0 3px 10px rgba(220, 38, 38, .25);
        }

        textarea.form-control {
            border-radius: 12px !important;
            resize: none;
            font-size: 13px;
            border: 1.5px solid #dbeafe;
        }

        .sticky-save {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, .95);
            backdrop-filter: blur(8px);
            padding: 12px 16px;
            box-shadow: 0 -4px 16px rgba(0, 0, 0, .08);
            z-index: 999;
        }

        .save-btn {
            height: 44px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            background: linear-gradient(135deg, #16a34a, #15803d);
            border: none;
            width: 100%;
            color: white;
        }

        .btn-back {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255, 255, 255, .2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .preview-area {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .photo-item {
            position: relative;
        }

        .photo-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }

        .btn-delete-photo {
            position: absolute;
            top: -6px;
            right: -6px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #dc2626;
            color: white;
            border: none;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <div class="mobile-container">
        {{-- HEADER CARD --}}
        <div class="header-card">
            <div class="d-flex justify-content-between align-items-start gap-2">
                <div>
                    <div class="header-title">❄️ {{ $chiller->judul }}</div>
                    <span class="badge bg-light text-dark mt-1 fw-bold">{{ $chiller->jenis_perawatan }}</span>
                </div>
                <a href="{{ route('chiller.index') }}" class="btn-back">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </div>
            <div class="header-info">
                <div>🏷️ No Chiller : <b>{{ $chiller->no_chiller ?? '-' }}</b></div>
                <div>🔢 No Aset : <b>{{ $chiller->no_aset ?? '-' }}</b></div>
                <div>📍 Lokasi : <b>{{ $chiller->lokasi ?? '-' }}</b></div>
                <div>📅 Tgl Pelaksanaan :
                    <b>{{ $chiller->tanggal_pelaksanaan ? \Carbon\Carbon::parse($chiller->tanggal_pelaksanaan)->format('d/m/Y') : '-' }}</b>
                </div>
            </div>
        </div>

        {{-- FORM UTAMA MOBILE --}}
        <form method="POST" action="{{ route('chiller.mobile.save', $chiller->id) }}" enctype="multipart/form-data">
            @csrf

            {{-- LOOP ITEM PEKERJAAN --}}
            @forelse ($chiller->items as $item)
                <div class="item-card">
                    <div class="uraian-title">
                        {{ $item->nomor ? $item->nomor . '.' : '' }} {{ $item->uraian_pekerjaan }}
                    </div>

                    <div class="detail-box">
                        @if ($item->aktivitas_pekerjaan)
                            <div class="detail-label">Aktivitas Pekerjaan</div>
                            <div class="detail-value">
                                {{ $item->aktivitas_pekerjaan }}
                            </div>
                        @endif

                        @if ($item->standar)
                            <div class="detail-label">Standar / Kondisi</div>
                            <div class="detail-value text-primary">
                                <i class="fa fa-info-circle me-1"></i>{{ $item->standar }}
                            </div>
                        @endif

                        {{-- RADIO STATUS OK / NOK --}}
                        <div class="radio-wrapper">
                            <label class="w-100">
                                <input type="radio" name="items[{{ $item->id }}][status]" value="OK"
                                    {{ $item->status == 'OK' ? 'checked' : '' }}>
                                <div class="btn-ok"><i class="fa fa-check me-1"></i> OK</div>
                            </label>
                            <label class="w-100">
                                <input type="radio" name="items[{{ $item->id }}][status]" value="NOK"
                                    {{ $item->status == 'NOK' ? 'checked' : '' }}>
                                <div class="btn-nok"><i class="fa fa-times me-1"></i> NOK</div>
                            </label>
                        </div>

                        {{-- CATATAN PER ITEM --}}
                        {{-- <textarea name="items[{{ $item->id }}][keterangan]" class="form-control mt-2" rows="2"
                            placeholder="Catatan hasil pengecekan...">{{ $item->keterangan }}</textarea> --}}

                        {{-- UPLOAD FOTO KAMERA --}}
                        <div class="mt-2">
                            <label class="fw-bold small text-muted">📷 Upload Foto</label>
                            <input type="file" class="form-control form-control-sm"
                                name="items[{{ $item->id }}][photos][]" accept="image/*" capture="environment"
                                multiple>

                            <input type="hidden" name="items[{{ $item->id }}][alamat]"
                                id="alamat-{{ $item->id }}">

                            <div class="preview-area" id="preview-{{ $item->id }}"></div>
                        </div>

                        {{-- PREVIEW FOTO EXISTING --}}
                        @if ($item->photos && $item->photos->count())
                            <div class="preview-area">
                                @foreach ($item->photos as $photo)
                                    <div class="photo-item">
                                        <img src="{{ asset('uploads/chiller/' . $photo->foto) }}">
                                        <a href="{{ route('chiller.photo.delete', $photo->id) }}" class="btn-delete-photo"
                                            onclick="return confirm('Hapus foto ini?')">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="alert alert-warning text-center">
                    Belum ada item pekerjaan yang dibuat pada checksheet ini.
                </div>
            @endforelse

            {{-- KESIMPULAN AKHIR --}}
            <div class="item-card mt-3">
                <label class="fw-bold mb-2">📌 Kesimpulan Final</label>
                <select name="kesimpulan" class="form-select mb-3" style="border-radius: 12px;">
                    <option value="">-- Pilih Status Kesimpulan --</option>
                    <option value="SO" {{ $chiller->kesimpulan == 'SO' ? 'selected' : '' }}>SO (Siap Operasi)</option>
                    <option value="SO DENGAN CATATAN" {{ $chiller->kesimpulan == 'SO DENGAN CATATAN' ? 'selected' : '' }}>
                        SO DENGAN CATATAN</option>
                    <option value="TSO" {{ $chiller->kesimpulan == 'TSO' ? 'selected' : '' }}>TSO (Tidak Siap Operasi)
                    </option>
                </select>

                <label class="fw-bold mb-2">💬 Catatan Keseluruhan</label>
                <textarea name="catatan" class="form-control" rows="3" placeholder="Masukkan catatan tambahan jika ada...">{{ $chiller->catatan }}</textarea>
            </div>

            {{-- STICKY SAVE BUTTON --}}
            <div class="sticky-save">
                <button type="submit" class="save-btn">
                    <i class="fa fa-save me-1"></i> Simpan Hasil Checksheet
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif

    <script>
        // Automatic Location GPS
        let gpsData = {
            alamat: ''
        };

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(async (pos) => {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                try {
                    const res = await fetch(
                        `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`
                    );
                    const data = await res.json();
                    gpsData.alamat = data.display_name ?? '';
                } catch (e) {}

                document.querySelectorAll('[id^=alamat-]').forEach(el => el.value = gpsData.alamat);
            }, null, {
                enableHighAccuracy: true
            });
        }

        // Preview Foto Murni tanpa Canvas / Watermark / Kotak
        document.querySelectorAll('input[type=file]').forEach(input => {
            input.addEventListener('change', function() {
                const files = [...this.files];
                const itemId = this.name.match(/\[(\d+)\]/)[1];
                const preview = document.getElementById('preview-' + itemId);
                preview.innerHTML = '';

                files.forEach(file => {
                    const imgUrl = URL.createObjectURL(file);
                    preview.innerHTML += `
                        <div class="photo-item">
                            <img src="${imgUrl}" style="width:80px;height:80px;object-fit:cover;border-radius:10px;">
                        </div>`;
                });
            });
        });
    </script>
@endsection
