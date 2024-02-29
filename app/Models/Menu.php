<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Menu extends Model
{
    use HasFactory;
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'parent_menus_id','id');
    }

    public function subMenus()
    {
        return $this->hasMany(Menu::class, 'parent_menus_id', 'id')->orderBy('ordinal_number');
    }

    public function roles($isActiveCondition = null)
    {
        $columns = Schema::getColumnListing('permissions');
        $filteredColumns = array_filter($columns, function($column) {
            return preg_match('/^can_/', $column);
        });
        $query = $this->belongsToMany(Role::class, 'permissions', 'menus_id', 'roles_id')
                                    ->withPivot($filteredColumns)
                                    ->withTimestamps();

        if ($isActiveCondition) {
            $query->where($isActiveCondition);
        }
        return $query;
    }

    public static function get_subMenuDataIsActive($param = null){
        $data =  Self::query()->where('is_active',$param)->wherenotnull('parent_menus_id')->get();

        return $data;
    }
    public static function get_allMenuPermissionDataIsActive($param = null){
        $data =   Self::query()->select('menus.*')
                                ->leftJoin('menus as sm', 'menus.id', '=', 'sm.parent_menus_id')
                                ->whereNull('menus.parent_menus_id')
                                ->whereNull('sm.id')
                                ->where('menus.is_active', true)
                                ->union(
                                    Menu::select('sm.*')
                                        ->join('menus as sm', 'menus.id', '=', 'sm.parent_menus_id')
                                        ->where('sm.is_active', true)
                                )
                                ->get();

        return $data;
    }
    public static function get_menuPermissionDataIsActive($condition = null){
        $menus = Menu::select('m.*')
                ->from('menus as m')
                ->joinSub(function ($query) use ($condition){
                    $query->select('m.parent_menus_id as menus_id')
                        ->from('permissions as p')
                        ->join('menus as m', 'p.menus_id', '=', 'm.id')
                        ->where('p.roles_id', $condition)
                        ->whereNotNull('m.parent_menus_id')
                        ->groupBy('m.parent_menus_id');
                }, 'x', 'm.id', '=', 'x.menus_id');

        $menus->unionALL(Menu::select('menus.*')
                ->from('menus')
                ->join('permissions as p', 'menus.id', '=', 'p.menus_id')
                ->where('p.roles_id', $condition)
                ->whereNull('menus.parent_menus_id'))->orderby('ordinal_number')->with('subMenus');

        return $menus->get();
    }
}
