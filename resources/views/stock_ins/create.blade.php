@extends('layouts.app')

@section('page-title', 'Tambah Stok Masuk')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Tambah Stok Masuk</h4>
        <a href="{{ route('stock-ins.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('stock-ins.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Scan Barcode <small class="text-muted">(opsional)</small></label>
                    <div class="input-group">
                        <input type="text" id="barcode_input" class="form-control"
                            placeholder="Scan atau ketik barcode, lalu Enter">
                        <button type="button" class="btn btn-outline-secondary" onclick="lookupBarcode()">
                            <i class="bi bi-upc-scan"></i> Cari
                        </button>
                        <button type="button" class="btn btn-outline-primary" onclick="toggleCamera()">
                            <i class="bi bi-camera"></i> Kamera
                        </button>
                    </div>
                    <small id="barcode_msg" class="text-muted"></small>

                    <!-- Area kamera -->
                    <div id="camera_area" class="mt-2" style="display:none;">
                        <div id="qr-reader" style="width:100%; max-width:400px; border-radius:8px; overflow:hidden;"></div>
                        <button type="button" class="btn btn-sm btn-danger mt-2" onclick="stopCamera()">
                            <i class="bi bi-x-circle"></i> Tutup Kamera
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Produk</label>
                    <select name="product_id" class="form-select @error('product_id') is-invalid @enderror">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->kode_produk }} — {{ $product->nama_produk }}
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
                        <label class="form-label fw-semibold">No Batch</label>
                        <input type="text" name="no_batch" class="form-control"
                               value="{{ old('no_batch') }}" placeholder="opsional">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tanggal Masuk</label>
                        <input type="date" name="tgl_masuk" class="form-control @error('tgl_masuk') is-invalid @enderror"
                               value="{{ old('tgl_masuk', date('Y-m-d')) }}">
                        @error('tgl_masuk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tanggal Kadaluarsa</label>
                        <input type="date" name="tgl_kadaluarsa" class="form-control @error('tgl_kadaluarsa') is-invalid @enderror"
                               value="{{ old('tgl_kadaluarsa') }}">
                        @error('tgl_kadaluarsa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Stok Masuk</button>
            </form>
        </div>
    </div>

<script>
let html5QrCode = null;

function lookupBarcode(barcode = null) {
    const code = barcode || document.getElementById('barcode_input').value;
    if (!code) return;

    fetch(`/barcode/lookup?barcode=${code}`)
        .then(res => res.json())
        .then(data => {
            const msg = document.getElementById('barcode_msg');
            if (data.found) {
                const select = document.querySelector('select[name="product_id"]');
                select.value = data.id;
                msg.className = 'text-success small';
                msg.textContent = `✓ Produk ditemukan: ${data.nama} (${data.merek}) — Stok: ${data.stok} ${data.satuan}`;
                stopCamera();
            } else {
                msg.className = 'text-danger small';
                msg.textContent = '✗ Produk tidak ditemukan. Pastikan barcode sudah terdaftar di data produk.';
            }
        })
        .catch(() => {
            document.getElementById('barcode_msg').textContent = 'Terjadi kesalahan.';
        });
}

function toggleCamera() {
    const area = document.getElementById('camera_area');
    if (area.style.display === 'none') {
        area.style.display = 'block';
        startCamera();
    } else {
        stopCamera();
    }
}

function startCamera() {
    html5QrCode = new Html5Qrcode("qr-reader");
    html5QrCode.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: { width: 250, height: 150 } },
        (decodedText) => {
            document.getElementById('barcode_input').value = decodedText;
            lookupBarcode(decodedText);
        },
        (error) => {}
    ).catch(err => {
        document.getElementById('barcode_msg').className = 'text-danger small';
        document.getElementById('barcode_msg').textContent = 'Gagal akses kamera: ' + err;
    });
}

function stopCamera() {
    if (html5QrCode) {
        html5QrCode.stop().then(() => {
            html5QrCode = null;
            document.getElementById('camera_area').style.display = 'none';
        }).catch(() => {});
    }
}

document.getElementById('barcode_input').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        lookupBarcode();
    }
});
</script>

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

    // Validasi 3: Tanggal Masuk tidak boleh kosong
    const tglMasuk = document.querySelector('input[name="tgl_masuk"]');
    if (tglMasuk.value === '') {
        tglMasuk.classList.add('is-invalid');
        valid = false;
    } else {
        tglMasuk.classList.remove('is-invalid');
    }

    // Validasi 4: Tanggal Kadaluarsa harus setelah hari ini
    const tglKadaluarsa = document.querySelector('input[name="tgl_kadaluarsa"]');
    const today = new Date().toISOString().split('T')[0];
    if (tglKadaluarsa.value === '' || tglKadaluarsa.value <= today) {
        tglKadaluarsa.classList.add('is-invalid');
        valid = false;
    } else {
        tglKadaluarsa.classList.remove('is-invalid');
    }

    if (!valid) {
        e.preventDefault();
        alert('Harap lengkapi semua field yang wajib diisi dengan benar!');
    }
});
</script>
@endpush

@endsection