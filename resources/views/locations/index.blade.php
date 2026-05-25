@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Data Lokasi Rak Gudang</h4>
        <a href="{{ route('locations.create') }}" class="btn btn-primary">+ Tambah Lokasi</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Kode Lokasi</th>
                        <th>Nama Lokasi</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($locations as $location)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $location->kode_lokasi }}</td>
                        <td>{{ $location->nama_lokasi }}</td>
                        <td>{{ $location->deskripsi ?? '-' }}</td>
                        <td>
                            <a href="{{ route('locations.edit', $location) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('locations.destroy', $location) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin hapus lokasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada data lokasi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $locations->links() }}
        </div>
    </div>
@endsection