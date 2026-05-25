<?php

namespace App\Http\Controllers;

use App\Models\StockOut;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\LogHelper;

class StockOutController extends Controller
{
    public function index()
    {
        $stockOuts = StockOut::with('product', 'user')->latest()->paginate(10);
        return view('stock_outs.index', compact('stockOuts'));
    }

    public function create()
    {
        $products = Product::where('jumlah_stok', '>', 0)->get();
        return view('stock_outs.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id'  => 'required|exists:products,id',
            'jumlah'      => 'required|integer|min:1',
            'tgl_keluar'  => 'required|date',
            'alasan'      => 'required|in:distribusi,rusak,kadaluarsa,lainnya',
            'keterangan'  => 'nullable',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->jumlah > $product->jumlah_stok) {
            return back()->withErrors([
                'jumlah' => 'Jumlah keluar melebihi stok yang tersedia (' . $product->jumlah_stok . ' ' . $product->satuan . ').'
            ])->withInput();
        }

        $stockOut = StockOut::create([
            'product_id'  => $request->product_id,
            'user_id'     => auth()->id(),
            'jumlah'      => $request->jumlah,
            'tgl_keluar'  => $request->tgl_keluar,
            'alasan'      => $request->alasan,
            'keterangan'  => $request->keterangan,
        ]);

        $product->decrement('jumlah_stok', $request->jumlah);

        $earliestExpiry = $product->stockIns()->min('tgl_kadaluarsa');
        if ($earliestExpiry) {
            $product->update(['tgl_kadaluarsa' => $earliestExpiry]);
        }

        LogHelper::log('created', 'StockOut', $stockOut->id,
            'Stok keluar dicatat: ' . $product->nama_produk . ' sejumlah ' . $request->jumlah . ' alasan: ' . $request->alasan,
            null, $stockOut->toArray()
        );

        return redirect()->route('stock-outs.index')
                        ->with('success', 'Stok keluar berhasil dicatat.');
    }

    public function show(StockOut $stockOut)
    {
        return view('stock_outs.show', compact('stockOut'));
    }

    public function destroy(StockOut $stockOut)
    {
        LogHelper::log('deleted', 'StockOut', $stockOut->id,
            'Data stok keluar dihapus: ' . $stockOut->product->nama_produk . ' sejumlah ' . $stockOut->jumlah,
            $stockOut->toArray(), null
        );

        $stockOut->product->increment('jumlah_stok', $stockOut->jumlah);
        $stockOut->delete();

        return redirect()->route('stock-outs.index')
                        ->with('success', 'Data stok keluar berhasil dihapus.');
    }
}