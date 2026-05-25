@extends('layouts.app')

@section('page-title', 'Detail Stok Keluar')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Detail Stok Keluar</h4>
        <a href="{{ route('stock-outs.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th class="bg-light" width="30%">Produk</th>
                    <td>{{ $stockOut->product->nama_produk }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Kode Produk</th>
                    <td>{{ $stockOut->product->kode_produk }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Jumlah</th>
                    <td>{{ $stockOut->jumlah }} {{ $stockOut->product->satuan }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Tanggal Keluar</th>
                    <td>{{ $stockOut->tgl_keluar->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Alasan</th>
                    <td>{{ ucfirst($stockOut->alasan) }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Keterangan</th>
                    <td>{{ $stockOut->keterangan ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Dicatat Oleh</th>
                    <td>{{ $stockOut->user->name }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Waktu Pencatatan</th>
                    <td>{{ $stockOut->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>

@endsection