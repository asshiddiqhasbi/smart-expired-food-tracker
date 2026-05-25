@extends('layouts.app')

@section('page-title', 'Tambah Stok Keluar')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Tambah Stok Keluar</h4>
        <a href="{{ route('stock-outs.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('stock-outs.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Produk</label>
                    <select name="product_id" class="form-select @error('product_id') is-invalid @enderror">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->kode_produk }} — {{ $product->nama_produk }} (Stok: {{ $product->jumlah_stok }} {{ $product->satuan }})
                            </option>
                        @endforeach
                    </select>
                    @error('product_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Jumlah</label>
                        <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
                               value="{{ old('jumlah') }}" min="1">
                        @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tanggal Keluar</label>
                        <input type="date" name="tgl_keluar" class="form-control @error('tgl_keluar') is-invalid @enderror"
                               value="{{ old('tgl_keluar', date('Y-m-d')) }}">
                        @error('tgl_keluar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Alasan Keluar</label>
                    <select name="alasan" class="form-select @error('alasan') is-invalid @enderror">
                        <option value="">-- Pilih Alasan --</option>
                        <option value="distribusi" {{ old('alasan') == 'distribusi' ? 'selected' : '' }}>Distribusi</option>
                        <option value="rusak" {{ old('alasan') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="kadaluarsa" {{ old('alasan') == 'kadaluarsa' ? 'selected' : '' }}>Kadaluarsa</option>
                        <option value="lainnya" {{ old('alasan') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('alasan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Stok Keluar</button>
            </form>
        </div>
    </div>

@push('scripts')
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    let valid = true;

    // Validasi 1: Produk harus dipilih
    const productId = document.querySelector('select[name="product_id"]');
    if (productId.value === '') {
        productId.classList.add('is-invalid');
        valid = false;
    } else {
        productId.classList.remove('is-invalid');
    }

    // Validasi 2: Jumlah minimal 1
    const jumlah = document.querySelector('input[name="jumlah"]');
    if (jumlah.value === '' || jumlah.value < 1) {
        jumlah.classList.add('is-invalid');
        valid = false;
    } else {
        jumlah.classList.remove('is-invalid');
    }

    // Validasi 3: Tanggal Keluar tidak boleh kosong
    const tglKeluar = document.querySelector('input[name="tgl_keluar"]');
    if (tglKeluar.value === '') {
        tglKeluar.classList.add('is-invalid');
        valid = false;
    } else {
        tglKeluar.classList.remove('is-invalid');
    }

    // Validasi 4: Alasan harus dipilih
    const alasan = document.querySelector('select[name="alasan"]');
    if (alasan.value === '') {
        alasan.classList.add('is-invalid');
        valid = false;
    } else {
        alasan.classList.remove('is-invalid');
    }

    if (!valid) {
        e.preventDefault();
        alert('Harap lengkapi semua field yang wajib diisi!');
    }
});
</script>
@endpush

@endsection