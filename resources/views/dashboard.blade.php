@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                    <i class="bi bi-box-seam fs-4 text-primary"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Produk</div>
                    <div class="fs-4 fw-bold">{{ $totalProduk }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                    <i class="bi bi-shield-check fs-4 text-success"></i>
                </div>
                <div>
                    <div class="text-muted small">Produk Aman</div>
                    <div class="fs-4 fw-bold">{{ $produkAman }}</div>
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
                    <div class="fs-4 fw-bold">{{ $produkMendekati }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                    <i class="bi bi-exclamation-triangle fs-4 text-danger"></i>
                </div>
                <div>
                    <div class="text-muted small">Produk Kadaluarsa</div>
                    <div class="fs-4 fw-bold">{{ $produkKadaluarsa }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Grafik Donut -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-pie-chart"></i> Distribusi Status Produk</h6>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <canvas id="statusChart" style="max-height: 250px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Stok Masuk & Keluar Hari Ini -->
    <div class="col-md-8">
        <div class="row g-3 h-100">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-success bg-opacity-10 p-3">
                            <i class="bi bi-arrow-down-circle fs-4 text-success"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Stok Masuk Hari Ini</div>
                            <div class="fs-4 fw-bold">{{ $stokMasukHariIni }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                            <i class="bi bi-arrow-up-circle fs-4 text-warning"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Stok Keluar Hari Ini</div>
                            <div class="fs-4 fw-bold">{{ $stokKeluarHariIni }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Produk Mendekati Kadaluarsa -->
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-warning bg-opacity-10 border-0">
                        <h6 class="mb-0 fw-bold text-warning">
                            <i class="bi bi-clock-history"></i> Produk Mendekati Kadaluarsa (≤ 30 Hari)
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th>Stok</th>
                                    <th>Tgl Kadaluarsa</th>
                                    <th>Sisa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mendekatiKadaluarsa as $produk)
                                <tr>
                                    <td>{{ $produk->nama_produk }}</td>
                                    <td>{{ $produk->jumlah_stok }}</td>
                                    <td>{{ $produk->tgl_kadaluarsa->format('d/m/Y') }}</td>
                                    <td>
                                        @php $sisa = (int) now()->diffInDays($produk->tgl_kadaluarsa, false) @endphp
                                        <span class="badge bg-warning text-dark">{{ $sisa }} hari</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Tidak ada produk mendekati kadaluarsa.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Produk Sudah Kadaluarsa -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-danger bg-opacity-10 border-0">
        <h6 class="mb-0 fw-bold text-danger">
            <i class="bi bi-x-circle"></i> Produk Sudah Kadaluarsa
        </h6>
    </div>
    <div class="card-body p-0">
        <table class="table table-sm table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Produk</th>
                    <th>Stok</th>
                    <th>Tgl Kadaluarsa</th>
                    <th>Lewat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sudahKadaluarsa as $produk)
                <tr>
                    <td>{{ $produk->nama_produk }}</td>
                    <td>{{ $produk->jumlah_stok }}</td>
                    <td>{{ $produk->tgl_kadaluarsa->format('d/m/Y') }}</td>
                    <td>
                        @php $lewat = (int) now()->diffInDays($produk->tgl_kadaluarsa, false) @endphp
                        <span class="badge bg-danger">{{ abs($lewat) }} hari</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-3">Tidak ada produk kadaluarsa.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
const ctx = document.getElementById('statusChart').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Aman', 'Mendekati Kadaluarsa', 'Sudah Kadaluarsa'],
        datasets: [{
            data: [{{ $produkAman }}, {{ $produkMendekati }}, {{ $produkKadaluarsa }}],
            backgroundColor: ['#198754', '#ffc107', '#dc3545'],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: { font: { size: 12 } }
            }
        },
        cutout: '65%'
    }
});
</script>
@endpush

@endsection