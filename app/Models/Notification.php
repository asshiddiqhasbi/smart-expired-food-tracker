<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'product_id',
        'tipe',
        'sisa_hari',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}