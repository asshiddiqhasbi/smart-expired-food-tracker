@extends('layouts.app')

@section('page-title', 'Notifikasi')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Notifikasi Kadaluarsa</h4>
        <form action="{{ route('notifications.read-all') }}" method="POST">
            @csrf
            @method('PATCH')
            <button class="btn btn-secondary">Tandai Semua Dibaca</button>
        </form>
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
                        <th>Produk</th>
                        <th>Status</th>
                        <th>Sisa Hari</th>
                        <th>Tgl Kadaluarsa</th>
                        <th>Dibaca</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $notification)
                    <tr class="{{ $notification->is_read ? 'table-secondary' : '' }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $notification->product->nama_produk }}</td>
                        <td>
                            @if($notification->tipe == 'kadaluarsa')
                                <span class="badge bg-danger">Sudah Kadaluarsa</span>
                            @else
                                <span class="badge bg-warning text-dark">Mendekati Kadaluarsa</span>
                            @endif
                        </td>
                        <td>
                            @if($notification->sisa_hari < 0)
                                <span class="text-danger fw-bold">{{ abs($notification->sisa_hari) }} hari yang lalu</span>
                            @else
                                <span class="text-warning fw-bold">{{ $notification->sisa_hari }} hari lagi</span>
                            @endif
                        </td>
                        <td>{{ $notification->product->tgl_kadaluarsa->format('d/m/Y') }}</td>
                        <td>
                            @if($notification->is_read)
                                <span class="badge bg-success">Sudah</span>
                            @else
                                <span class="badge bg-danger">Belum</span>
                            @endif
                        </td>
                        <td>
                            @if(!$notification->is_read)
                                <form action="{{ route('notifications.read', $notification) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-success">Tandai Dibaca</button>
                                </form>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Tidak ada notifikasi saat ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $notifications->links() }}
        </div>
    </div>

@endsection