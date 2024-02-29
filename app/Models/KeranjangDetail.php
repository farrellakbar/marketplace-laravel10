<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeranjangDetail extends Model
{
    use HasFactory;
    Protected $table = 'keranjang_details';
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
