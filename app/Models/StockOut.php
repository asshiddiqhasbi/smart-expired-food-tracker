<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    protected $table = 'stock_outs';

    protected $fillable = [
        'product_id',
        'user_id',
        'jumlah',
        'tgl_keluar',
        'alasan',
        'keterangan',
    ];

    protected $casts = [
        'tgl_keluar' => 'date',
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