@extends('layouts.app')

@section('page-title', 'Audit Trail')

@section('content')

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-3">
            <h6 class="fw-bold mb-0"><i class="bi bi-clock-history"></i> Riwayat Perubahan Data</h6>
        </div>
        <div class="card-body p-0">
            <table class="table table-sm table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Aksi</th>
                        <th>Model</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $log->user->name }}</td>
                        <td>
                            @if($log->aksi == 'created')
                                <span class="badge bg-success">Tambah</span>
                            @elseif($log->aksi == 'updated')
                                <span class="badge bg-warning text-dark">Ubah</span>
                            @elseif($log->aksi == 'deleted')
                                <span class="badge bg-danger">Hapus</span>
                            @endif
                        </td>
                        <td><span class="badge bg-secondary">{{ $log->model }}</span></td>
                        <td>{{ $log->deskripsi }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">Belum ada riwayat perubahan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">
            {{ $logs->links() }}
        </div>
    </div>

@endsection