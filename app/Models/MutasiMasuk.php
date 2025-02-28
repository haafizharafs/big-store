<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiMasuk extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
