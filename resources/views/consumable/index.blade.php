@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Perencanaan Consumable</h3>
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddFolder">
                <i class="fas fa-folder-plus"></i> Buat Folder Baru
            </button>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Judul Perencanaan</th>
                            <th width="15%">Tahun</th>
                            <th width="25%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($folders as $index => $folder)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $folder->title }}</td>
                                <td>{{ $folder->year }}</td>
                                <td>
                                    <a href="{{ route('consumable.monitor', $folder->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-desktop"></i> Monitor
                                    </a>
                                    <button class="btn btn-sm btn-warning" data-toggle="modal"
                                        data-target="#modalEditFolder{{ $folder->id }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('consumable.folder.destroy', $folder->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin hapus folder ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Edit Folder -->
                            <div class="modal fade" id="modalEditFolder{{ $folder->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="{{ route('consumable.folder.update', $folder->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Folder</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Judul Perencanaan</label>
                                                    <input type="text" name="title" class="form-control"
                                                        value="{{ $folder->title }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Tahun</label>
                                                    <input type="number" name="year" class="form-control"
                                                        value="{{ $folder->year }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada folder perencanaan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Folder -->
    <div class="modal fade" id="modalAddFolder" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('consumable.folder.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Folder Perencanaan Baru</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Judul Perencanaan</label>
                            <input type="text" name="title" class="form-control"
                                placeholder="Contoh: Perencanaan Consumable Gedung A" required>
                        </div>
                        <div class="form-group">
                            <label>Tahun</label>
                            <input type="number" name="year" class="form-control" value="{{ date('Y') }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Buat Folder</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
