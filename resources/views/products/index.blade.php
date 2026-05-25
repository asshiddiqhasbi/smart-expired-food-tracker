@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Data Produk Makanan Kemasan</h4>
        <a href="{{ route('products.create') }}" class="btn btn-primary">+ Tambah Produk</a>
    </div>

    <!-- Filter & Search -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('products.index') }}" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold small">Cari Produk</label>
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Nama, kode, atau merek..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Kategori</label>
                    <select name="category_id" class="form-select form-select-sm">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Status Kadaluarsa</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">-- Semua Status --</option>
                        <option value="aman" {{ request('status') == 'aman' ? 'selected' : '' }}>Aman</option>
                        <option value="mendekati" {{ request('status') == 'mendekati' ? 'selected' : '' }}>Mendekati Kadaluarsa</option>
                        <option value="kadaluarsa" {{ request('status') == 'kadaluarsa' ? 'selected' : '' }}>Sudah Kadaluarsa</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100">Filter</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm w-100 mt-1">Reset</a>
                </div>
            </form>
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
                        <th>Kode</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Merek</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th>Tgl Kadaluarsa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $product->kode_produk }}</td>
                        <td>{{ $product->nama_produk }}</td>
                        <td>{{ $product->category->nama_kategori ?? '-' }}</td>
                        <td>{{ $product->location->nama_lokasi ?? '-' }}</td>
                        <td>{{ $product->merek }}</td>
                        <td>{{ $product->satuan }}</td>
                        <td>{{ $product->jumlah_stok }}</td>
                        <td>
                            @php
                                $today = now();
                                $diff  = $today->diffInDays($product->tgl_kadaluarsa, false);
                            @endphp
                            {{ $product->tgl_kadaluarsa->format('d/m/Y') }}
                            @if($diff < 0)
                                <span class="badge bg-danger">Kadaluarsa</span>
                            @elseif($diff <= 30)
                                <span class="badge bg-warning text-dark">≤ 30 Hari</span>
                            @elseif($diff <= 60)
                                <span class="badge bg-info text-dark">≤ 60 Hari</span>
                            @else
                                <span class="badge bg-success">Aman</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('products.stock-ins', $product) }}" class="btn btn-sm btn-info">Lihat Batch</a>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted">Belum ada data produk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $products->links() }}
        </div>
    </div>
@endsection