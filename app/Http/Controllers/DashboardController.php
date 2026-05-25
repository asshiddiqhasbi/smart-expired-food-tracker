<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk         = Product::count();
        $stokMasukHariIni    = StockIn::whereDate('tgl_masuk', today())->sum('jumlah');
        $stokKeluarHariIni   = StockOut::whereDate('tgl_keluar', today())->sum('jumlah');
        $produkKadaluarsa    = Product::whereDate('tgl_kadaluarsa', '<', today())->count();
        $produkAman          = Product::whereDate('tgl_kadaluarsa', '>', today()->addDays(30))->count();
        $produkMendekati     = Product::whereDate('tgl_kadaluarsa', '>=', today())
                                      ->whereDate('tgl_kadaluarsa', '<=', today()->addDays(30))
                                      ->count();
        $mendekatiKadaluarsa = Product::whereDate('tgl_kadaluarsa', '>=', today())
                                      ->whereDate('tgl_kadaluarsa', '<=', today()->addDays(30))
                                      ->orderBy('tgl_kadaluarsa')
                                      ->get();
        $sudahKadaluarsa     = Product::whereDate('tgl_kadaluarsa', '<', today())
                                      ->orderBy('tgl_kadaluarsa')
                                      ->get();

        return view('dashboard', compact(
            'totalProduk',
            'stokMasukHariIni',
            'stokKeluarHariIni',
            'produkKadaluarsa',
            'produkAman',
            'produkMendekati',
            'mendekatiKadaluarsa',
            'sudahKadaluarsa'
        ));
    }
}