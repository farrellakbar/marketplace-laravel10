<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PermissionController extends Controller
{
    //OPEN HALAMAN UTAMA
        public function index(){
            $roles = Role::get_dataIsActive(true);
            return view('pages.backend.permissions.index',compact('roles'));
        }
    //CLOSE HALAMAN UTAMA
    //OPEN EDIT
        public function edit($param){
            $id = decrypt($param);
            $role = Role::findorfail($id);
            $menus = Menu::get_allMenuPermissionDataIsActive();
            $columnPermissions = Schema::getColumnListing('permissions');

            return view('pages.backend.permissions.edit', compact('role', 'menus','columnPermissions'));
        }
    //CLOSE EDIT
    //OPEN UPDATE
        public function update(Request $request, $param){
            try {
                DB::beginTransaction();
                $id = decrypt($param);
                $role = Role::findorfail($id);
                $check = 0;
                $menuIdPermissions = [];

                //assign role permissions
                if($request->permissions){
                    foreach ($request->permissions as $permission){
                        $explode = explode('///', $permission);
                        $menuId = $explode[0];
                        $permissionType = $explode[1];
                        $menuIdPermissions[$menuId][$permissionType] = true;
                    }
                    $oldMenuPermissions = $role->menus->pluck('id')->toArray();
                    $newMenuPermissions = array_keys($menuIdPermissions);
                    $result=array_diff($oldMenuPermissions,$newMenuPermissions);
                    //because there are no permissions
                    if($result){
                        if($role->name = 'superadmin'){
                            $menus = Menu::join('menus as sm', 'menus.id','=','sm.parent_menus_id')
                                            ->where('menus.key_name', 'management' )
                                            ->pluck('sm.id')->toArray();
                            $result=array_diff($menus,$role->menus()->pluck('id')->toArray());
                            if($result){
                                $role->menus()->detach($result);
                            }
                        }
                        else{
                            $role->menus()->detach($result);
                        }
                    }

                    // Check if the menu is already attached to the role
                    foreach ($menuIdPermissions as $menuId => $value){
                        if (!$role->menus()->where('menus_id', $menuId)->exists()) {
                            // If not, attach it with the provided type
                            $role->menus()->attach($menuId, $value);
                        } else {
                            // If already attached, you may choose to handle it in a different way
                            // For example, you might want to update the type or ignore it
                            // Here, I'm updating the type for demonstration purposes
                            $role->menus()->detach($menuId);
                            $value = $value ? $role->menus()->attach($menuId, $value) : '';
                        }
                    }
                }
                else{
                    if($role->name = 'superadmin'){
                        $menus = Menu::join('menus as sm', 'menus.id','=','sm.parent_menus_id')
                                        ->where('menus.key_name', 'management' )
                                        ->pluck('sm.id')->toArray();
                        $result=array_diff($role->menus()->pluck('id')->toArray(), $menus);
                        if($result){
                            $role->menus()->detach($result);
                        }
                    }
                    else{
                        $role->menus()->detach();
                    }
                }
                ActivityLogController::activtyLog($role, 'updated', 'The user has updated role permissions');
                DB::commit();
                return response()->json([
                    'title' => 'Success!',
                    'message' => 'Role Permission updated successfully.'
                ], 200);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'title' => 'Failed!',
                    'message' => 'Data processing failure, '. $e->getMessage()
                ], 500);
            }
        }
    //CLOSE UPDATE
}
