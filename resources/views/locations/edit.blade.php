@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Edit Lokasi</h4>
        <a href="{{ route('locations.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('locations.update', $location) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Kode Lokasi</label>
                    <input type="text" name="kode_lokasi" class="form-control @error('kode_lokasi') is-invalid @enderror"
                           value="{{ old('kode_lokasi', $location->kode_lokasi) }}">
                    @error('kode_lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Lokasi</label>
                    <input type="text" name="nama_lokasi" class="form-control @error('nama_lokasi') is-invalid @enderror"
                           value="{{ old('nama_lokasi', $location->nama_lokasi) }}">
                    @error('nama_lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $location->deskripsi) }}</textarea>
                </div>

                <button type="submit" class="btn btn-warning">Update Lokasi</button>
            </form>
        </div>
    </div>

@push('scripts')
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    let valid = true;

    // Validasi 1: Kode Lokasi tidak boleh kosong
    const kodeLokasi = document.querySelector('input[name="kode_lokasi"]');
    if (kodeLokasi.value.trim() === '') {
        kodeLokasi.classList.add('is-invalid');
        valid = false;
    } else {
        kodeLokasi.classList.remove('is-invalid');
    }

    // Validasi 2: Nama Lokasi tidak boleh kosong
    const namaLokasi = document.querySelector('input[name="nama_lokasi"]');
    if (namaLokasi.value.trim() === '') {
        namaLokasi.classList.add('is-invalid');
        valid = false;
    } else {
        namaLokasi.classList.remove('is-invalid');
    }

    if (!valid) {
        e.preventDefault();
        alert('Harap lengkapi semua field yang wajib diisi!');
    }
});
</script>
@endpush

@endsection