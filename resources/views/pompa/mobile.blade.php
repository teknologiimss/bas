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
        }

        .item-card {
            background: #fff;
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 14px;
            border: 1px solid #dbeafe;
        }

        .detail-box {
            background: #f8fbff;
            border-radius: 12px;
            padding: 12px;
            margin-top: 10px;
            border-left: 4px solid #2563eb;
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
        }

        input:checked+.btn-nok {
            background: #dc2626;
            color: white;
            border-color: #dc2626;
        }

        .sticky-save {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, .95);
            padding: 12px 16px;
            z-index: 999;
        }

        .save-btn {
            height: 44px;
            border-radius: 12px;
            font-weight: 700;
            background: linear-gradient(135deg, #16a34a, #15803d);
            border: none;
            width: 100%;
            color: white;
        }
    </style>

    <div class="mobile-container">
        <div class="header-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="fw-bold fs-5">⚙️ {{ $pompa->judul }}</div>
                    <span class="badge bg-light text-dark mt-1">{{ $pompa->jenis_perawatan }}</span>
                </div>
                <a href="{{ route('pompa.index') }}" class="btn btn-sm btn-light"><i class="fa fa-arrow-left"></i></a>
            </div>
            <div class="mt-2 small opacity-75">
                <div>🏷️ No Pompa : <b>{{ $pompa->no_pompa ?? '-' }}</b></div>
                <div>📅 Tgl Pelaksanaan :
                    <b>{{ $pompa->tanggal_pelaksanaan ? \Carbon\Carbon::parse($pompa->tanggal_pelaksanaan)->format('d/m/Y') : '-' }}</b>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('pompa.mobile.save', $pompa->id) }}" enctype="multipart/form-data">
            @csrf

            @forelse ($pompa->items as $item)
                <div class="item-card">
                    <div class="fw-bold text-dark">
                        {{ $item->nomor ? $item->nomor . '.' : '' }} {{ $item->uraian_pekerjaan }}
                    </div>

                    <div class="detail-box">
                        @if ($item->aktivitas_pekerjaan)
                            <div class="small text-muted fw-bold">Aktivitas Pekerjaan</div>
                            <div class="fw-bold text-dark mb-2">{{ $item->aktivitas_pekerjaan }}</div>
                        @endif

                        @if ($item->standar)
                            <div class="small text-muted fw-bold">Standar / Kondisi</div>
                            <div class="fw-bold text-primary mb-2"><i
                                    class="fa fa-info-circle me-1"></i>{{ $item->standar }}</div>
                        @endif

                        {{-- RADIO OK / NOK --}}
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

                        <div class="mt-2">
                            <label class="fw-bold small text-muted">📷 Upload Foto</label>
                            <input type="file" class="form-control form-control-sm"
                                name="items[{{ $item->id }}][photos][]" accept="image/*" capture="environment"
                                multiple>
                            <input type="hidden" name="items[{{ $item->id }}][alamat]"
                                id="alamat-{{ $item->id }}">
                        </div>

                        @if ($item->photos && $item->photos->count())
                            <div class="d-flex gap-2 flex-wrap mt-2">
                                @foreach ($item->photos as $photo)
                                    <div class="position-relative">
                                        <img src="{{ asset('uploads/pompa/' . $photo->foto) }}"
                                            style="width:70px;height:70px;object-fit:cover;border-radius:8px;">
                                        <a href="{{ route('pompa.photo.delete', $photo->id) }}"
                                            class="btn btn-danger btn-sm position-absolute top-0 end-0 p-0 rounded-circle"
                                            style="width:20px;height:20px;font-size:10px;"
                                            onclick="return confirm('Hapus foto?')">×</a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="alert alert-warning text-center">Belum ada item pekerjaan.</div>
            @endforelse

            {{-- KESIMPULAN AKHIR --}}
            <div class="item-card">
                <label class="fw-bold mb-2">📌 Kesimpulan Final</label>
                <select name="kesimpulan" class="form-select mb-3">
                    <option value="">-- Pilih Status Kesimpulan --</option>
                    <option value="SO" {{ $pompa->kesimpulan == 'SO' ? 'selected' : '' }}>SO (Siap Operasi)</option>
                    <option value="SO DENGAN CATATAN" {{ $pompa->kesimpulan == 'SO DENGAN CATATAN' ? 'selected' : '' }}>SO
                        DENGAN CATATAN</option>
                    <option value="TSO" {{ $pompa->kesimpulan == 'TSO' ? 'selected' : '' }}>TSO (Tidak Siap Operasi)
                    </option>
                </select>

                <label class="fw-bold mb-2">💬 Catatan Keseluruhan</label>
                <textarea name="catatan" class="form-control" rows="3" placeholder="Masukkan catatan tambahan jika ada...">{{ $pompa->catatan }}</textarea>
            </div>

            <div class="sticky-save">
                <button type="submit" class="save-btn"><i class="fa fa-save me-1"></i> Simpan Hasil Checksheet</button>
            </div>
        </form>
    </div>

    <script>
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(async (pos) => {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                try {
                    const res = await fetch(
                        `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
                    const data = await res.json();
                    document.querySelectorAll('[id^=alamat-]').forEach(el => el.value = data.display_name ??
                    '');
                } catch (e) {}
            });
        }
    </script>
@endsection
