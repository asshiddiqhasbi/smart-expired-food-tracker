<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    public function lookup(Request $request)
    {
        $product = Product::where('barcode', $request->barcode)->first();

        if (!$product) {
            return response()->json([
                'found'    => false,
                'message'  => 'Produk tidak ditemukan.'
            ]);
        }

        return response()->json([
            'found'      => true,
            'id'         => $product->id,
            'kode'       => $product->kode_produk,
            'nama'       => $product->nama_produk,
            'merek'      => $product->merek,
            'satuan'     => $product->satuan,
            'stok'       => $product->jumlah_stok,
        ]);
    }
}