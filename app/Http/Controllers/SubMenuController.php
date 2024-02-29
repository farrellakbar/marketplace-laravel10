<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SubMenuController extends Controller
{
    //OPEN HALAMAN UTAMA
        public function index($param){
            $id = decrypt($param);
            $menu = Menu::findorfail($id);
            return view('pages.backend.submenus.index', compact('menu', 'param'));
        }
    //CLOSE HALAMAN UTAMA
    //OPEN PROSES GET DATATABLE
        public function datatable($param){
            $id = decrypt($param);
            $subMenus = Menu::whereNotNull('parent_menus_id')->where('parent_menus_id', $id)->orderby('ordinal_number', 'asc')->get();
            return datatables()->of($subMenus)
                            ->addColumn('id', function ($row) {
                                $id = encrypt($row->id);
                                return $id;
                            })
                            ->make();
        }
    //CLOSE PROSES GET DATATABLE
    //OPEN MODAL CREATE
        public function create($param){
            $id = decrypt($param);
            $menu = Menu::findorfail($id);

            return view('pages.backend.submenus.modals.create', compact('menu','param'));
        }
    //CLOSE MODAL CREATE
    //OPEN PROSES STORE
        public function store(Request $request, $param){
            try {
                DB::beginTransaction();
                $id = decrypt($param);
                //OPEN VALIDASI INPUTAN
                    $validate = $request->validate([
                        'name' => 'required|string',
                    ]);
                //CLOSE VALIDASI INPUTAN
                //OPEN CREATE
                    $key_name = Controller::slug($validate['name'], '_');
                    $route = Controller::slug($validate['name'], '');
                    $route = $route.'.index';
                    $url = Controller::slug($validate['name'], '-');

                    $menu = Menu::findorfail($id);

                    $subMenu = new Menu();
                    $subMenu->parent_menus_id = $menu->id;
                    $subMenu->name = $validate['name'];
                    $subMenu->key_name = $key_name;
                    $subMenu->route = $route;
                    $subMenu->url = $url;
                    $subMenu->ordinal_number = 0;
                    $subMenu->is_active = $request->is_active == 'true' ? true : false;
                    $subMenu->save();
                //CLOSE CREATE

                ActivityLogController::activtyLog($subMenu, 'created', 'The user has created sub menu');

                DB::commit();
                return response()->json([
                    'title' => 'Success!',
                    'message' => 'Sub menu added successfully.'
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
            $subMenu = Menu::findorfail($id);
            return view('pages.backend.submenus.modals.edit', compact('subMenu','param'));
        }
    //CLOSE MODAL EDIT
    //OPEN PROSES UPDATE
        public function update(Request $request, $param){
            try {
                DB::beginTransaction();
                //OPEN VALIDASI INPUTAN
                    $validate = $request->validate([
                        'name' => 'required|string',
                    ]);
                //CLOSE VALIDASI INPUTAN
                    $id = decrypt($param);
                //OPEN UPDATE
                    $subMenu = Menu::findorfail($id);
                    if($subMenu->name != $validate['name']){
                        $key_name = Controller::slug($validate['name'], '_');
                        $route = Controller::slug($validate['name'], '');
                        $route = $route.'.index';
                        $url = Controller::slug($validate['name'], '-');

                        $subMenu->parent_menus_id = $subMenu->menu->id;
                        $subMenu->name = $validate['name'];
                        $subMenu->key_name = $key_name;
                        $subMenu->route = $route;
                        $subMenu->url = $url;
                    }
                    $subMenu->is_active = $request->is_active ? true : false;
                    $subMenu->save();
                //CLOSE UPDATE

                ActivityLogController::activtyLog($subMenu, 'updated', 'The user has updated sub menu');

                DB::commit();
                return response()->json([
                    'title' => 'Success!',
                    'message' => 'Sub menu updated successfully.'
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
                $subMenu = Menu::find($id);
                $subMenuDelete = $subMenu;
                $subMenu->delete();
                ActivityLogController::activtyLog($subMenuDelete, 'deleted', 'The user has deleted sub menu');

                DB::commit();
                return response()->json([
                                            'title'=> 'Success!' ,
                                            'message' => 'Sub menu has been deleted.'
                                        ], 200);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                                            'title' => 'Failed!',
                                            'message' => 'Sub menu failed to delete.'. $e->getMessage()
                                        ], 500);
            }
        }
    //CLOSE PROSES DELETE
}
