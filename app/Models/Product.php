<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'kode_produk',
        'barcode',
        'nama_produk',
        'category_id',
        'location_id',
        'merek',
        'satuan',
        'jumlah_stok',
        'tgl_kadaluarsa',
        'keterangan',
    ];

    protected $casts = [
        'tgl_kadaluarsa' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function stockIns()
    {
        return $this->hasMany(StockIn::class);
    }
}