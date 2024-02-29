<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MenuController extends Controller
{
    //OPEN HALAMAN UTAMA
        public function index(){
            return view('pages.backend.menus.index');
        }
    //CLOSE HALAMAN UTAMA
    //OPEN PROSES GET DATATABLE
        public function datatable(){
            $menus = Menu::whereNull('parent_menus_id')->orderby('ordinal_number', 'asc')->get();
            return datatables()->of($menus)
                            ->addColumn('id', function ($row) {
                                $id = encrypt($row->id);
                                return $id;
                            })
                            ->make();
        }
    //CLOSE PROSES GET DATATABLE
    //OPEN MODAL CREATE
        public function create(){
            return view('pages.backend.menus.modals.create');
        }
    //CLOSE MODAL CREATE
    //OPEN PROSES STORE
        public function store(Request $request){
            try {
                DB::beginTransaction();
                //OPEN VALIDASI INPUTAN
                    $validate = $request->validate([
                        'name' => 'required|string',
                        'icon' => 'required|string',
                    ]);
                //CLOSE VALIDASI INPUTAN
                //OPEN CREATE
                    $key_name = Controller::slug($validate['name'], '_');
                    $route = Controller::slug($validate['name'], '');
                    $route = $route.'.index';
                    $url = Controller::slug($validate['name'], '-');

                    $menu = new Menu();
                    $menu->name = $validate['name'];
                    $menu->key_name = $key_name;
                    $menu->route = $route;
                    $menu->url = '/'. $url;
                    $menu->icon = $validate['icon'];
                    $menu->ordinal_number = 0;
                    $menu->is_active = $request->is_active == 'true' ? true : false;
                    $menu->save();
                //CLOSE CREATE

                ActivityLogController::activtyLog($menu, 'created', 'The user has created menu');

                DB::commit();
                return response()->json([
                    'title' => 'Success!',
                    'message' => 'Menu added successfully.'
                ], 200);
            } catch (ValidationException $e) {
                DB::rollback();
                return response()->json([
                    'title' => 'Failed!',
                    'message' => 'Check the data that has been entered again.',
                    'messageValidate' => $e->validator->getMessageBag()
                ], 422);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'title' => 'Failed!',
                    'message' => 'Data processing failure, '. $e->getMessage()
                ], 500);
            }
        }
    //CLOSE PROSES STORE
    //OPEN MODAL EDIT
        public function edit($param){
            $id = decrypt($param);
            $menu = Menu::findorfail($id);
            return view('pages.backend.menus.modals.edit', compact('menu'));
        }
    //CLOSE MODAL EDIT
    //OPEN PROSES UPDATE
        public function update(Request $request, $param){
            try {
                DB::beginTransaction();
                //OPEN VALIDASI INPUTAN
                    $validate = $request->validate([
                        'name' => 'required|string',
                        'icon' => 'required|string',
                    ]);
                //CLOSE VALIDASI INPUTAN
                    $id = decrypt($param);
                //OPEN UPDATE
                    $menu = Menu::findorfail($id);
                    if($menu->name != $validate['name']){
                        $key_name = Controller::slug($validate['name'], '_');
                        $route = Controller::slug($validate['name'], '');
                        $route = $route.'.index';
                        $url = Controller::slug($validate['name'], '-');

                        $menu->name = $validate['name'];
                        $menu->key_name = $key_name;
                        $menu->route = $route;
                        $menu->url = '/'. $url;
                    }
                    $menu->icon = $validate['icon'];
                    $menu->is_active = $request->is_active ? true : false;
                    $menu->save();
                //CLOSE UPDATE

                ActivityLogController::activtyLog($menu, 'updated', 'The user has updated menu');

                DB::commit();
                return response()->json([
                    'title' => 'Success!',
                    'message' => 'Menu updated successfully.'
                ], 200);
            } catch (ValidationException $e) {
                DB::rollback();
                return response()->json([
                    'title' => 'Failed!',
                    'message' => 'Check the data that has been entered again.',
                    'messageValidate' => $e->validator->getMessageBag()
                ], 422);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'title' => 'Failed!',
                    'message' => 'Data processing failure, '. $e->getMessage()
                ], 500);
            }
        }
    //CLOSE PROSES UPDATE
    //OPEN PROSES DELETE
        public function delete($param)
        {
            try {
                DB::beginTransaction();
                $id = decrypt($param);
                $menu = Menu::find($id);
                // Check if the menu has children (submenus)
                if ($menu->subMenus->isNotEmpty()) {
                    return response()->json([
                        'title' => 'Failed!',
                        'message' => 'Menu has submenus. Please delete the submenus first.'
                    ], 422);
                }
                $menuDelete = $menu;
                $menu->delete();

                ActivityLogController::activtyLog($menuDelete, 'deleted', 'The user has deleted menu');

                DB::commit();
                return response()->json([
                                            'title'=> 'Success!' ,
                                            'message' => 'Menu has been deleted.'
                                        ], 200);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                                            'title' => 'Failed!',
                                            'message' => 'Menu failed to delete.'. $e->getMessage()
                                        ], 500);
            }
        }
    //CLOSE PROSES DELETE
}
