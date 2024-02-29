<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    use HasFactory;
    public static function get_dataIsActive($param = null){
        $data =  Self::query()->where('is_active',$param)->get();

        return $data;
    }
}
