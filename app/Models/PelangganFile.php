<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelangganFile extends Model
{
    protected $table = 'pelanggan_files';

    protected $fillable = [
        'pelanggan_id',
        'file_path',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }
}
