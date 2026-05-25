@extends('layouts.app')

@section('page-title', 'Stok Keluar')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Data Stok Keluar</h4>
        <a href="{{ route('stock-outs.create') }}" class="btn btn-primary">+ Tambah Stok Keluar</a>
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
                        <th>Jumlah</th>
                        <th>Tgl Keluar</th>
                        <th>Alasan</th>
                        <th>Dicatat Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stockOuts as $stockOut)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            {{ $stockOut->product->nama_produk }}
                            @php $diff = now()->diffInDays($stockOut->product->tgl_kadaluarsa, false); @endphp
                            @if($diff < 0)
                                <span class="badge bg-danger">Kadaluarsa</span>
                            @elseif($diff <= 30)
                                <span class="badge bg-warning text-dark">≤ 30 Hari</span>
                            @endif
                        </td>
                        <td>{{ $stockOut->jumlah }} {{ $stockOut->product->satuan }}</td>
                        <td>{{ $stockOut->tgl_keluar->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge
                                @if($stockOut->alasan == 'distribusi') bg-success
                                @elseif($stockOut->alasan == 'rusak') bg-danger
                                @elseif($stockOut->alasan == 'kadaluarsa') bg-warning text-dark
                                @else bg-secondary
                                @endif">
                                {{ ucfirst($stockOut->alasan) }}
                            </span>
                        </td>
                        <td>{{ $stockOut->user->name }}</td>
                        <td>
                            <a href="{{ route('stock-outs.show', $stockOut) }}" class="btn btn-sm btn-info">Detail</a>
                            <form action="{{ route('stock-outs.destroy', $stockOut) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin hapus data ini? Stok produk akan dikembalikan.')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada data stok keluar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $stockOuts->links() }}
        </div>
    </div>

@endsection