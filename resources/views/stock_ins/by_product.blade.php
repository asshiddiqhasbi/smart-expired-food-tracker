@extends('layouts.app')

@section('page-title', 'Detail Batch Stok')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-0">Detail Batch Stok</h4>
            <small class="text-muted">{{ $product->kode_produk }} — {{ $product->nama_produk }}</small>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body">
                    <div class="small">Total Stok</div>
                    <div class="fs-4 fw-bold">{{ $product->jumlah_stok }} {{ $product->satuan }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white shadow-sm">
                <div class="card-body">
                    <div class="small">Kadaluarsa Terdekat</div>
                    <div class="fs-4 fw-bold">{{ $product->tgl_kadaluarsa->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body">
                    <div class="small">Total Batch</div>
                    <div class="fs-4 fw-bold">{{ $stockIns->total() }} batch</div>
                </div>
            </div>
        </div>
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
                        <th>No Batch</th>
                        <th>Jumlah</th>
                        <th>Tgl Masuk</th>
                        <th>Tgl Kadaluarsa</th>
                        <th>Status</th>
                        <th>Dicatat Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stockIns as $stockIn)
                    @php
                        $today = now();
                        $diff  = $today->diffInDays($stockIn->tgl_kadaluarsa, false);
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $stockIn->no_batch ?? '-' }}</td>
                        <td>{{ $stockIn->jumlah }} {{ $product->satuan }}</td>
                        <td>{{ $stockIn->tgl_masuk->format('d/m/Y') }}</td>
                        <td>{{ $stockIn->tgl_kadaluarsa->format('d/m/Y') }}</td>
                        <td>
                            @if($diff < 0)
                                <span class="badge bg-danger">Kadaluarsa</span>
                            @elseif($diff <= 30)
                                <span class="badge bg-warning text-dark">Segera Kadaluarsa</span>
                            @else
                                <span class="badge bg-success">Aman</span>
                            @endif
                        </td>
                        <td>{{ $stockIn->user->name }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada data batch untuk produk ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $stockIns->links() }}
        </div>
    </div>

@endsection