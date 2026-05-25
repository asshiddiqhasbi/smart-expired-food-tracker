@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Edit Produk</h4>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('products.update', $product) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Kode Produk</label>
                    <input type="text" name="kode_produk" class="form-control @error('kode_produk') is-invalid @enderror"
                           value="{{ old('kode_produk', $product->kode_produk) }}">
                    @error('kode_produk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Barcode <small class="text-muted">(opsional)</small></label>
                    <input type="text" name="barcode" class="form-control @error('barcode') is-invalid @enderror"
                        value="{{ old('barcode', $product->barcode) }}" placeholder="Scan atau ketik barcode produk">
                    @error('barcode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror"
                           value="{{ old('nama_produk', $product->nama_produk) }}">
                    @error('nama_produk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Kategori</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Lokasi Rak</label>
                        <select name="location_id" class="form-select @error('location_id') is-invalid @enderror">
                            <option value="">-- Pilih Lokasi --</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                    {{ $location->kode_lokasi }} — {{ $location->nama_lokasi }}{{ $location->deskripsi ? ' (' . $location->deskripsi . ')' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('location_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Merek</label>
                        <input type="text" name="merek" class="form-control @error('merek') is-invalid @enderror"
                               value="{{ old('merek', $product->merek) }}">
                        @error('merek') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Satuan</label>
                        <select name="satuan" class="form-select @error('satuan') is-invalid @enderror">
                            <option value="">-- Pilih Satuan --</option>
                            <option value="pcs" {{ old('satuan', $product->satuan) == 'pcs' ? 'selected' : '' }}>Pcs</option>
                            <option value="karton" {{ old('satuan', $product->satuan) == 'karton' ? 'selected' : '' }}>Karton</option>
                            <option value="lusin" {{ old('satuan', $product->satuan) == 'lusin' ? 'selected' : '' }}>Lusin</option>
                            <option value="kg" {{ old('satuan', $product->satuan) == 'kg' ? 'selected' : '' }}>Kg</option>
                        </select>
                        @error('satuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Jumlah Stok</label>
                        <input type="number" name="jumlah_stok" class="form-control @error('jumlah_stok') is-invalid @enderror"
                               value="{{ old('jumlah_stok', $product->jumlah_stok) }}" min="0">
                        @error('jumlah_stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tanggal Kadaluarsa</label>
                        <input type="date" name="tgl_kadaluarsa" class="form-control @error('tgl_kadaluarsa') is-invalid @enderror"
                               value="{{ old('tgl_kadaluarsa', $product->tgl_kadaluarsa->format('Y-m-d')) }}">
                        @error('tgl_kadaluarsa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $product->keterangan) }}</textarea>
                </div>

                <button type="submit" class="btn btn-warning">Update Produk</button>
            </form>
        </div>
    </div>

@push('scripts')
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    let valid = true;

    // Validasi 1: Kode Produk tidak boleh kosong
    const kodeProduk = document.querySelector('input[name="kode_produk"]');
    if (kodeProduk.value.trim() === '') {
        kodeProduk.classList.add('is-invalid');
        valid = false;
    } else {
        kodeProduk.classList.remove('is-invalid');
    }

    // Validasi 2: Nama Produk tidak boleh kosong
    const namaProduk = document.querySelector('input[name="nama_produk"]');
    if (namaProduk.value.trim() === '') {
        namaProduk.classList.add('is-invalid');
        valid = false;
    } else {
        namaProduk.classList.remove('is-invalid');
    }

    // Validasi 3: Merek tidak boleh kosong
    const merek = document.querySelector('input[name="merek"]');
    if (merek.value.trim() === '') {
        merek.classList.add('is-invalid');
        valid = false;
    } else {
        merek.classList.remove('is-invalid');
    }

    // Validasi 4: Satuan harus dipilih
    const satuan = document.querySelector('select[name="satuan"]');
    if (satuan.value === '') {
        satuan.classList.add('is-invalid');
        valid = false;
    } else {
        satuan.classList.remove('is-invalid');
    }

    // Validasi 5: Jumlah Stok tidak boleh negatif
    const jumlahStok = document.querySelector('input[name="jumlah_stok"]');
    if (jumlahStok.value < 0 || jumlahStok.value === '') {
        jumlahStok.classList.add('is-invalid');
        valid = false;
    } else {
        jumlahStok.classList.remove('is-invalid');
    }

    // Validasi 6: Tanggal Kadaluarsa tidak boleh kosong
    const tglKadaluarsa = document.querySelector('input[name="tgl_kadaluarsa"]');
    if (tglKadaluarsa.value === '') {
        tglKadaluarsa.classList.add('is-invalid');
        valid = false;
    } else {
        tglKadaluarsa.classList.remove('is-invalid');
    }

    if (!valid) {
        e.preventDefault();
        alert('Harap lengkapi semua field yang wajib diisi!');
    }
});
</script>
@endpush

@endsection