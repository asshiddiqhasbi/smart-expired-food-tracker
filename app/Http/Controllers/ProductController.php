<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Helpers\LogHelper;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'location');

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_produk', 'like', '%' . $request->search . '%')
                ->orWhere('kode_produk', 'like', '%' . $request->search . '%')
                ->orWhere('merek', 'like', '%' . $request->search . '%');
            });
        }

        // Filter kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter status kadaluarsa
        if ($request->filled('status')) {
            if ($request->status == 'kadaluarsa') {
                $query->whereDate('tgl_kadaluarsa', '<', today());
            } elseif ($request->status == 'mendekati') {
                $query->whereDate('tgl_kadaluarsa', '>=', today())
                    ->whereDate('tgl_kadaluarsa', '<=', today()->addDays(30));
            } elseif ($request->status == 'aman') {
                $query->whereDate('tgl_kadaluarsa', '>', today()->addDays(30));
            }
        }

        $products   = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $locations  = Location::all();
        return view('products.create', compact('categories', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_produk'    => 'required|unique:products',
            'nama_produk'    => 'required',
            'category_id'    => 'nullable|exists:categories,id',
            'location_id'    => 'nullable|exists:locations,id',
            'merek'          => 'required',
            'satuan'         => 'required',
            'jumlah_stok'    => 'required|integer|min:0',
            'tgl_kadaluarsa' => 'required|date',
            'keterangan'     => 'nullable',
        ]);

        $product = Product::create($request->all());

        LogHelper::log('created', 'Product', $product->id,
            'Produk baru ditambahkan: ' . $product->nama_produk,
            null, $product->toArray()
        );

        return redirect()->route('products.index')
                        ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $locations  = Location::all();
        return view('products.edit', compact('product', 'categories', 'locations'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'kode_produk'    => 'required|unique:products,kode_produk,' . $product->id,
            'nama_produk'    => 'required',
            'category_id'    => 'nullable|exists:categories,id',
            'location_id'    => 'nullable|exists:locations,id',
            'merek'          => 'required',
            'satuan'         => 'required',
            'jumlah_stok'    => 'required|integer|min:0',
            'tgl_kadaluarsa' => 'required|date',
            'keterangan'     => 'nullable',
        ]);

        $dataLama = $product->toArray();
        $product->update($request->all());

        LogHelper::log('updated', 'Product', $product->id,
            'Produk diperbarui: ' . $product->nama_produk,
            $dataLama, $product->toArray()
        );

        return redirect()->route('products.index')
                        ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        LogHelper::log('deleted', 'Product', $product->id,
            'Produk dihapus: ' . $product->nama_produk,
            $product->toArray(), null
        );

        $product->delete();

        return redirect()->route('products.index')
                        ->with('success', 'Produk berhasil dihapus.');
    }
}