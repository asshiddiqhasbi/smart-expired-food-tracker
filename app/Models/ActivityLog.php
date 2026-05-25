<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'aksi',
        'model',
        'model_id',
        'deskripsi',
        'data_lama',
        'data_baru',
    ];

    protected $casts = [
        'data_lama' => 'array',
        'data_baru' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}