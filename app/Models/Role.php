<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Role extends Model
{
    use HasFactory;
    public function users($isActiveCondition = null)
    {
        $query = $this->belongsToMany(User::class, 'job_historys', 'roles_id', 'users_id')
                                    ->withPivot('opds_id', 'valid_from', 'valid_to', 'is_active')
                                    ->withTimestamps();

        if ($isActiveCondition) {
            $query->where($isActiveCondition);
        }

        return $query;
    }
    public function menus($isActiveCondition = null)
    {
        $columns = Schema::getColumnListing('permissions');
        $filteredColumns = array_filter($columns, function($column) {
            return preg_match('/^can_/', $column);
        });
        $query = $this->belongsToMany(Menu::class, 'permissions', 'roles_id', 'menus_id')
                                    ->withPivot($filteredColumns)
                                    ->withTimestamps()
                                    ->orderBy('menus.ordinal_number', 'asc');
        if ($isActiveCondition) {
            $query->where($isActiveCondition);
        }
        return $query;
    }
    public static function get_dataIsActive($param = null){
        $data =  Self::query()->where('is_active',$param)->get();

        return $data;
    }
}
