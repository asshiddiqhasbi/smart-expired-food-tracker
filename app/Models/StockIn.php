<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $table = 'stock_ins';

    protected $fillable = [
        'product_id',
        'user_id',
        'jumlah',
        'tgl_masuk',
        'tgl_kadaluarsa',
        'no_batch',
        'keterangan',
    ];

    protected $casts = [
        'tgl_masuk'      => 'date',
        'tgl_kadaluarsa' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}