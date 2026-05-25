<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class LogHelper
{
    public static function log(string $aksi, string $model, int $modelId, string $deskripsi, $dataLama = null, $dataBaru = null)
    {
        ActivityLog::create([
            'user_id'   => auth()->id(),
            'aksi'      => $aksi,
            'model'     => $model,
            'model_id'  => $modelId,
            'deskripsi' => $deskripsi,
            'data_lama' => $dataLama,
            'data_baru' => $dataBaru,
        ]);
    }
}