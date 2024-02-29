<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class, 'dokumen_id','id');
    }
}
