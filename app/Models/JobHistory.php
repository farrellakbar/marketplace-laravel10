<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobHistory extends Model
{
    use HasFactory;
    Protected $table = 'job_historys';
    public $incrementing = false;
    protected $primaryKey = ['roles_id', 'users_id'];
    protected $fillable = [
        'roles_id', 'users_id','opds_id', 'is_active', 'valid_from', 'valid_to','created_at', 'updated_at'
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class, 'opds_id','id');
    }

}
