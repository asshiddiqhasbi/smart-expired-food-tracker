<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $dari  = $request->dari ?? now()->startOfMonth()->format('Y-m-d');
        $sampai = $request->sampai ?? now()->format('Y-m-d');

        $stokMasuk = StockIn::with('product', 'user')
                            ->whereDate('tgl_masuk', '>=', $dari)
                            ->whereDate('tgl_masuk', '<=', $sampai)
                            ->latest()
                            ->get();

        $stokKeluar = StockOut::with('product', 'user')
                              ->whereDate('tgl_keluar', '>=', $dari)
                              ->whereDate('tgl_keluar', '<=', $sampai)
                              ->latest()
                              ->get();

        $produkKadaluarsa = Product::whereDate('tgl_kadaluarsa', '<', today())
                                   ->orderBy('tgl_kadaluarsa')
                                   ->get();

        $mendekatiKadaluarsa = Product::whereDate('tgl_kadaluarsa', '>=', today())
                                      ->whereDate('tgl_kadaluarsa', '<=', today()->addDays(30))
                                      ->orderBy('tgl_kadaluarsa')
                                      ->get();

        $totalMasuk  = $stokMasuk->sum('jumlah');
        $totalKeluar = $stokKeluar->sum('jumlah');

        return view('laporan.index', compact(
            'stokMasuk', 'stokKeluar',
            'produkKadaluarsa', 'mendekatiKadaluarsa',
            'totalMasuk', 'totalKeluar',
            'dari', 'sampai'
        ));
    }
}