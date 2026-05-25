@extends('layouts.app')

@section('page-title', 'Stok Masuk')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Data Stok Masuk</h4>
        <a href="{{ route('stock-ins.create') }}" class="btn btn-primary">+ Tambah Stok Masuk</a>
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
                        <th>Tgl Masuk</th>
                        <th>Tgl Kadaluarsa</th>
                        <th>No Batch</th>
                        <th>Dicatat Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stockIns as $stockIn)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $stockIn->product->nama_produk }}</td>
                        <td>{{ $stockIn->jumlah }}</td>
                        <td>{{ $stockIn->tgl_masuk->format('d/m/Y') }}</td>
                        <td>{{ $stockIn->tgl_kadaluarsa->format('d/m/Y') }}</td>
                        <td>{{ $stockIn->no_batch ?? '-' }}</td>
                        <td>{{ $stockIn->user->name }}</td>
                        <td>
                            <a href="{{ route('stock-ins.show', $stockIn) }}" class="btn btn-sm btn-info">Detail</a>
                            <form action="{{ route('stock-ins.destroy', $stockIn) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin hapus data ini? Stok produk akan berkurang.')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Belum ada data stok masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $stockIns->links() }}
        </div>
    </div>

@endsection