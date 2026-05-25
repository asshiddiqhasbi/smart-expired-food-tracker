<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\LogHelper;

class StockInController extends Controller
{
    public function index()
    {
        $stockIns = StockIn::with('product', 'user')->latest()->paginate(10);
        return view('stock_ins.index', compact('stockIns'));
    }

    public function create()
    {
        $products = Product::all();
        return view('stock_ins.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id'     => 'required|exists:products,id',
            'jumlah'         => 'required|integer|min:1',
            'tgl_masuk'      => 'required|date',
            'tgl_kadaluarsa' => 'required|date|after:today',
            'no_batch'       => 'nullable',
            'keterangan'     => 'nullable',
        ]);

        $product = Product::findOrFail($request->product_id);

        $stockIn = StockIn::create([
            'product_id'     => $request->product_id,
            'user_id'        => auth()->id(),
            'jumlah'         => $request->jumlah,
            'tgl_masuk'      => $request->tgl_masuk,
            'tgl_kadaluarsa' => $request->tgl_kadaluarsa,
            'no_batch'       => $request->no_batch,
            'keterangan'     => $request->keterangan,
        ]);

        $product->increment('jumlah_stok', $request->jumlah);

        $earliestExpiry = $product->stockIns()->min('tgl_kadaluarsa');
        $product->update(['tgl_kadaluarsa' => $earliestExpiry]);

        LogHelper::log('created', 'StockIn', $stockIn->id,
            'Stok masuk dicatat: ' . $product->nama_produk . ' sejumlah ' . $request->jumlah,
            null, $stockIn->toArray()
        );

        return redirect()->route('stock-ins.index')
                        ->with('success', 'Stok masuk berhasil dicatat.');
    }

    public function show(StockIn $stockIn)
    {
        return view('stock_ins.show', compact('stockIn'));
    }

    public function destroy(StockIn $stockIn)
    {
        LogHelper::log('deleted', 'StockIn', $stockIn->id,
            'Data stok masuk dihapus: ' . $stockIn->product->nama_produk . ' sejumlah ' . $stockIn->jumlah,
            $stockIn->toArray(), null
        );

        $stockIn->product->decrement('jumlah_stok', $stockIn->jumlah);
        $stockIn->delete();

        return redirect()->route('stock-ins.index')
                        ->with('success', 'Data stok masuk berhasil dihapus.');
    }

    public function byProduct(Product $product)
    {
        $stockIns = StockIn::with('user')
                        ->where('product_id', $product->id)
                        ->latest()
                        ->paginate(10);
        return view('stock_ins.by_product', compact('stockIns', 'product'));
    }
}