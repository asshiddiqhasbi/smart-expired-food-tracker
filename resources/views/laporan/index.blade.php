@extends('layouts.app')

@section('page-title', 'Laporan & Rekap Stok')

@section('content')

    <!-- Filter -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Dari Tanggal</label>
                    <input type="date" name="dari" class="form-control" value="{{ $dari }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Sampai Tanggal</label>
                    <input type="date" name="sampai" class="form-control" value="{{ $sampai }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3">
                        <i class="bi bi-arrow-down-circle fs-4 text-success"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Masuk</div>
                        <div class="fs-4 fw-bold">{{ $totalMasuk }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                        <i class="bi bi-arrow-up-circle fs-4 text-warning"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Keluar</div>
                        <div class="fs-4 fw-bold">{{ $totalKeluar }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                        <i class="bi bi-x-circle fs-4 text-danger"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Produk Kadaluarsa</div>
                        <div class="fs-4 fw-bold">{{ $produkKadaluarsa->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                        <i class="bi bi-clock-history fs-4 text-warning"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Mendekati Kadaluarsa</div>
                        <div class="fs-4 fw-bold">{{ $mendekatiKadaluarsa->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stok Masuk -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-success bg-opacity-10 border-0">
            <h6 class="mb-0 fw-bold text-success">
                <i class="bi bi-arrow-down-circle"></i> Rekap Stok Masuk
                <small class="text-muted fw-normal">({{ $dari }} s/d {{ $sampai }})</small>
            </h6>
        </div>
        <div class="card-body p-0">
            <table class="table table-sm table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Tgl Masuk</th>
                        <th>Tgl Kadaluarsa</th>
                        <th>No Batch</th>
                        <th>Dicatat Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stokMasuk as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->product->nama_produk }}</td>
                        <td>{{ $item->jumlah }} {{ $item->product->satuan }}</td>
                        <td>{{ $item->tgl_masuk->format('d/m/Y') }}</td>
                        <td>{{ $item->tgl_kadaluarsa->format('d/m/Y') }}</td>
                        <td>{{ $item->no_batch ?? '-' }}</td>
                        <td>{{ $item->user->name }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-3">Tidak ada data stok masuk pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Stok Keluar -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-warning bg-opacity-10 border-0">
            <h6 class="mb-0 fw-bold text-warning">
                <i class="bi bi-arrow-up-circle"></i> Rekap Stok Keluar
                <small class="text-muted fw-normal">({{ $dari }} s/d {{ $sampai }})</small>
            </h6>
        </div>
        <div class="card-body p-0">
            <table class="table table-sm table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Tgl Keluar</th>
                        <th>Alasan</th>
                        <th>Dicatat Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stokKeluar as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->product->nama_produk }}</td>
                        <td>{{ $item->jumlah }} {{ $item->product->satuan }}</td>
                        <td>{{ $item->tgl_keluar->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge
                                @if($item->alasan == 'distribusi') bg-success
                                @elseif($item->alasan == 'rusak') bg-danger
                                @elseif($item->alasan == 'kadaluarsa') bg-warning text-dark
                                @else bg-secondary
                                @endif">
                                {{ ucfirst($item->alasan) }}
                            </span>
                        </td>
                        <td>{{ $item->user->name }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">Tidak ada data stok keluar pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Produk Kadaluarsa -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-danger bg-opacity-10 border-0">
            <h6 class="mb-0 fw-bold text-danger">
                <i class="bi bi-x-circle"></i> Produk Sudah Kadaluarsa
            </h6>
        </div>
        <div class="card-body p-0">
            <table class="table table-sm table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Produk</th>
                        <th>Stok</th>
                        <th>Tgl Kadaluarsa</th>
                        <th>Lewat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produkKadaluarsa as $produk)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $produk->nama_produk }}</td>
                        <td>{{ $produk->jumlah_stok }} {{ $produk->satuan }}</td>
                        <td>{{ $produk->tgl_kadaluarsa->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge bg-danger">
                                {{ abs(now()->diffInDays($produk->tgl_kadaluarsa, false)) }} hari
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Tidak ada produk kadaluarsa.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection