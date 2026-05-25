@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Tambah Kategori Baru</h4>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror"
                           value="{{ old('nama_kategori') }}">
                    @error('nama_kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Kategori</button>
            </form>
        </div>
    </div>

@push('scripts')
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    let valid = true;

    // Validasi 1: Nama Kategori tidak boleh kosong
    const namaKategori = document.querySelector('input[name="nama_kategori"]');
    if (namaKategori.value.trim() === '') {
        namaKategori.classList.add('is-invalid');
        valid = false;
    } else {
        namaKategori.classList.remove('is-invalid');
    }

    if (!valid) {
        e.preventDefault();
        alert('Nama Kategori tidak boleh kosong!');
    }
});
</script>
@endpush

@endsection