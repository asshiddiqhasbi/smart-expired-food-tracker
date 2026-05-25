<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';

    protected $fillable = [
        'kode_lokasi',
        'nama_lokasi',
        'deskripsi',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}