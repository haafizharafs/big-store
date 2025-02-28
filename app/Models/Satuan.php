<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function barang()
    {
        return $this->belongsToMany(Barang::Class);
    }
}
