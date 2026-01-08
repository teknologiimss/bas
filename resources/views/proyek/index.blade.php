@extends('layouts.main')

@section('content')
    {{-- <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/adminlte.min.js') }}"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>

    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script> --}}


    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-success" data-toggle="modal" data-target="#modalCreate" style="margin: 10px;">
            + Buat Proyek Baru
        </button>
    </div>

    <!-- FILTER SEARCH -->
    <form method="GET" action="" class="mb-3">
        <div class="input-group" style="max-width: 300px;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama proyek..."
                value="{{ request('search') }}">
            <button class="btn btn-primary">Cari</button>
        </div>
    </form>

    <!-- LIST PROYEK -->
    <div class="card p-3">
        <h5 class="mb-3">Daftar Proyek MRO</h5>

        @foreach ($proyeks as $p)
            <div class="d-flex justify-content-between align-items-center border p-3 mb-2 rounded">
                <div>
                    <h5 class="mb-1">{{ $p->nama_proyek }}</h5>
                    {{-- <small class="text-muted">Progress belum tersedia</small> --}}
                </div>

                <div>
                    <a href="{{ route('monitoring.index', $p->id) }}" class="btn btn-light">📊
                        Monitor
                    </a>

                    <!-- Edit -->
                    <button class="btn btn-success" data-toggle="modal" data-target="#modalEdit{{ $p->id }}">✏️
                        Edit
                    </button>


                    <!-- Delete -->
                    <form action="{{ route('proyek.delete', $p->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Hapus proyek ini?')">🗑️Delete</button>
                    </form>
                </div>
            </div>

            <!-- Modal Edit -->
            <div class="modal fade" id="modalEdit{{ $p->id }}">
                <div class="modal-dialog">
                    <form class="modal-content" action="{{ route('proyek.update', $p->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5>Edit Proyek</h5>
                        </div>
                        <div class="modal-body">
                            <label>Nama Proyek *</label>
                            <input type="text" name="nama_proyek" value="{{ $p->nama_proyek }}" class="form-control"
                                required>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success">Submit</button>
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach

        {{-- <div class="mt-3">
            {{ $proyeks->links() }}
        </div> --}}
        <div class="mt-3">
            {{ $proyeks->appends(['search' => request('search')])->links() }}
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="modalCreate">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('proyek.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5>Buat Proyek Baru</h5>
                </div>
                <div class="modal-body">
                    <label>Nama Proyek *</label>
                    <input type="text" name="nama_proyek" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
