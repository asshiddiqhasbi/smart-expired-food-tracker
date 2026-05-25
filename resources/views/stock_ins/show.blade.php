@extends('layouts.app')

@section('page-title', 'Detail Stok Masuk')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Detail Stok Masuk</h4>
        <a href="{{ route('stock-ins.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th class="bg-light" width="30%">Produk</th>
                    <td>{{ $stockIn->product->nama_produk }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Kode Produk</th>
                    <td>{{ $stockIn->product->kode_produk }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Jumlah</th>
                    <td>{{ $stockIn->jumlah }} {{ $stockIn->product->satuan }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Tanggal Masuk</th>
                    <td>{{ $stockIn->tgl_masuk->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Tanggal Kadaluarsa</th>
                    <td>{{ $stockIn->tgl_kadaluarsa->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th class="bg-light">No Batch</th>
                    <td>{{ $stockIn->no_batch ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Keterangan</th>
                    <td>{{ $stockIn->keterangan ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Dicatat Oleh</th>
                    <td>{{ $stockIn->user->name }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Waktu Pencatatan</th>
                    <td>{{ $stockIn->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>

@endsection