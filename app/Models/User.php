<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function roles($isActiveCondition = null)
    {
        $query = $this->belongsToMany(Role::class, 'job_historys', 'users_id', 'roles_id')
                        ->withPivot('opds_id', 'valid_from', 'valid_to', 'is_active')
                        ->withTimestamps();

        if ($isActiveCondition) {
            $query->where($isActiveCondition);
        }

        return $query;
    }
    public function produks()
    {
        return $this->belongsToMany(Produk::class, 'keranjang_details','user_id','produk_id')
                    ->withPivot('quantity', 'sub_total', 'order_id', 'status')
                    ->withTimestamps();
    }
    public static function get_dataIsActive($param = null){
        $data =  Self::query()->where('is_active',$param)->get();

        return $data;
    }
}
