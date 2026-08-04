@extends('layouts.main')

@section('content')
    <style>
        /* Modern Navy Palette Variables */
        :root {
            --navy-dark: #0a192f;
            --navy-main: #0f172a;
            --navy-card: #1e293b;
            --accent-blue: #38bdf8;
            --accent-glow: rgba(56, 189, 248, 0.25);
        }

        /* Container & Header Setup */
        .content-header {
            padding: 20px 0;
        }

        /* Custom Modern Card Design */
        .custom-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }

        .navy-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #ffffff;
            padding: 18px 24px;
        }

        /* Interactive Animated Project Card Item */
        .project-card-item {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-left: 6px solid #0284c7 !important;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .project-card-item:hover {
            transform: translateY(-3px) scale(1.005);
            box-shadow: 0 12px 25px -5px rgba(15, 23, 42, 0.12);
            border-left-color: #38bdf8 !important;
        }

        .project-card-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(56, 189, 248, 0.08), transparent);
            transition: left 0.7s ease;
        }

        .project-card-item:hover::before {
            left: 100%;
        }

        /* Navy Action Buttons with Pulse & Hover Dynamics */
        .btn-navy-primary {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-navy-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(29, 78, 216, 0.35);
        }

        .btn-pulse {
            animation: pulse-glow 2.5s infinite;
        }

        @keyframes pulse-glow {
            0% {
                box-shadow: 0 0 0 0 rgba(29, 78, 216, 0.4);
            }

            70% {
                box-shadow: 0 0 0 12px rgba(29, 78, 216, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(29, 78, 216, 0);
            }
        }

        /* Search Input Grouping */
        .search-group .form-control {
            border-radius: 8px 0 0 8px;
            border: 1px solid #cbd5e1;
            padding-left: 14px;
        }

        .search-group .btn {
            border-radius: 0 8px 8px 0;
        }

        /* Page Entrance Animation */
        .fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive HP Adjustments */
        @media (max-width: 767.98px) {
            .project-card-item {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 14px;
                padding: 16px;
            }

            .project-action-btns {
                width: 100%;
                display: flex;
                justify-content: space-between;
                gap: 6px;
            }

            .project-action-btns .btn,
            .project-action-btns form {
                flex: 1;
            }

            .project-action-btns form .btn {
                width: 100%;
            }

            .header-stack-mobile {
                flex-direction: column;
                align-items: stretch !important;
                gap: 12px;
            }

            .header-stack-mobile .btn {
                width: 100%;
            }
        }
    </style>

    <div class="content-header fade-in-up">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center header-stack-mobile">
                <div class="col-md-6 col-12">
                    <button type="button" class="btn btn-navy-primary btn-pulse px-3 py-2 shadow-sm" data-toggle="modal"
                        data-target="#modalTambahFolder">
                        <i class="fas fa-plus mr-1"></i> Tambah Perencanaan Kasbon
                    </button>
                </div>
                <div class="col-md-6 col-12 mt-2 mt-md-0">
                    <form action="{{ route('kasbon.index') }}" method="GET" class="float-md-right w-100"
                        style="max-width: 360px;">
                        <div class="input-group search-group shadow-sm">
                            <input type="text" name="search" autocomplete="off" class="form-control" placeholder="Cari nama proyek..."
                                value="{{ $search }}">
                            <div class="input-group-append">
                                <button class="btn btn-navy-primary px-3" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <section class="content fade-in-up">
        <div class="container-fluid">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert"
                    style="border-left: 5px solid #10b981 !important;">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card custom-card">
                <div class="card-header navy-header d-flex align-items-center justify-content-between">
                    <h4 class="font-weight-bold m-0 h5 text-white">
                        <i class="fas fa-folder-open mr-2 text-info"></i>Daftar Kasbon Proyek MRO
                    </h4>
                </div>
                <div class="card-body p-3 p-md-4">
                    @forelse($folders as $folder)
                        <div class="project-card-item d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="mb-1 font-weight-bold text-dark h6">{{ $folder->judul }}</h5>
                                <div class="text-muted small">
                                    <i class="fas fa-file-alt mr-1 text-primary"></i> PO / Nota Dinas:
                                    <span class="badge bg-light text-dark border ml-1">{{ $folder->po_nota_dinas }}</span>
                                </div>
                            </div>
                            <div class="project-action-btns">
                                <a href="{{ route('kasbon.show', $folder->id) }}"
                                    class="btn btn-primary btn-sm px-3 shadow-sm" style="border-radius: 6px;">
                                    <i class="fas fa-folder-open mr-1"></i> Open
                                </a>
                                <!-- Tombol Edit dengan atribut data-id, data-judul, data-po -->
                                <button type="button"
                                    class="btn btn-warning text-dark btn-sm px-3 shadow-sm font-weight-bold btn-edit-folder"
                                    data-id="{{ $folder->id }}" data-judul="{{ $folder->judul }}"
                                    data-po="{{ $folder->po_nota_dinas }}" style="border-radius: 6px;">
                                    <i class="fas fa-pencil-alt mr-1"></i> Edit
                                </button>
                                <form action="{{ route('kasbon.folder.destroy', $folder->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus folder proyek ini beserta semua isinya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm px-3 shadow-sm"
                                        style="border-radius: 6px;">
                                        <i class="fas fa-trash mr-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-folder-open fa-3x text-secondary mb-3 d-block opacity-50"></i>
                            <p class="text-muted mb-0">Belum ada perencanaan kasbon proyek.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </section>

    <!-- Modal Edit Single (Diletakkan di luar loop) -->
    <div class="modal fade" id="modalEditFolder" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header navy-header">
                    <h5 class="modal-title font-weight-bold text-white">
                        <i class="fas fa-edit mr-2 text-warning"></i>Edit Kasbon
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <!-- Action form diisi secara otomatis via JS -->
                <form id="formEditFolder" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4 text-left">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-dark">Judul Kasbon Proyek</label>
                            <input type="text" autocomplete="off" name="judul" id="edit_judul" class="form-control"
                                style="border-radius: 8px;" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">PO / Nota Dinas</label>
                            <input type="text" autocomplete="off" name="po_nota_dinas" id="edit_po_nota_dinas" class="form-control"
                                style="border-radius: 8px;" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            style="border-radius: 6px;">Batal</button>
                        <button type="submit" class="btn btn-warning font-weight-bold text-dark"
                            style="border-radius: 6px;">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Folder -->
    <div class="modal fade" id="modalTambahFolder" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header navy-header">
                    <h5 class="modal-title font-weight-bold text-white">
                        <i class="fas fa-plus-circle mr-2 text-info"></i>Tambah Perencanaan Kasbon Proyek
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('kasbon.folder.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4 text-left">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-dark">Judul Kasbon Proyek & PPK <span
                                    class="text-danger">*</span></label>
                            <input type="text" autocomplete="off" name="judul" class="form-control" style="border-radius: 8px;"
                                placeholder="Contoh: Pengiriman WAGON UGL 340 - PPK No.123" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">PO / Nota Dinas <span
                                    class="text-danger">*</span></label>
                            <input type="text" autocomplete="off" name="po_nota_dinas" class="form-control" style="border-radius: 8px;"
                                placeholder="Contoh: PO 40000099" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            style="border-radius: 6px;">Batal</button>
                        <button type="submit" class="btn btn-navy-primary px-4">Simpan Proyek</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Handler untuk Modal Edit -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Jalankan saat tombol edit diklik
            $('.btn-edit-folder').on('click', function() {
                var id = $(this).data('id');
                var judul = $(this).data('judul');
                var po = $(this).data('po');

                // Generate URL route update Laravel
                var updateRoute = "{{ route('kasbon.folder.update', ':id') }}".replace(':id', id);

                // Set nilai field input modal
                $('#formEditFolder').attr('action', updateRoute);
                $('#edit_judul').val(judul);
                $('#edit_po_nota_dinas').val(po);

                // Tampilkan modal
                $('#modalEditFolder').modal('show');
            });
        });
    </script>
@endsection
