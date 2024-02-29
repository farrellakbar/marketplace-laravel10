<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    //OPEN HALAMAN UTAMA
        public function index(){
            return view('pages.backend.roles.index');
        }
    //CLOSE HALAMAN UTAMA
    //OPEN PROSES GET DATATABLE
        public function datatable(){
            $roles = Role::orderby('name', 'asc')->get();
            return datatables()->of($roles)
                            ->addColumn('id', function ($row) {
                                $id = encrypt($row->id);
                                return $id;
                            })
                            ->make();
        }
    //CLOSE PROSES GET DATATABLE
    //OPEN MODAL CREATE
        public function create(){
            return view('pages.backend.roles.modals.create');
        }
    //CLOSE MODAL CREATE
    //OPEN PROSES STORE
        public function store(Request $request){
            try {
                DB::beginTransaction();
                //OPEN VALIDASI INPUTAN
                    $validate = $request->validate([
                        'name' => 'required|string',
                    ]);
                //CLOSE VALIDASI INPUTAN
                //OPEN CREATE
                    $role = new Role();
                    $role->name = $validate['name'];
                    $role->is_active = $request->is_active == 'true' ? true : false;
                    $role->save();
                //CLOSE CREATE

                ActivityLogController::activtyLog($role, 'created', 'The user has created role');

                DB::commit();
                return response()->json([
                    'title' => 'Success!',
                    'message' => 'Role added successfully.'
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
            $role = Role::findorfail($id);
            return view('pages.backend.roles.modals.edit', compact('role'));
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
                    $role = Role::findOrFail($id);
                    $role->name = $validate['name'];
                    $role->is_active = $request->is_active == 'true' ? true : false;
                    $role->save();
                //CLOSE UPDATE

                ActivityLogController::activtyLog($role, 'updated', 'The user has updated role');

                DB::commit();
                return response()->json([
                    'title' => 'Success!',
                    'message' => 'Role updated successfully.'
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
                $role = Role::find($id);
                $opdDelete = $role;
                $role->delete();
                ActivityLogController::activtyLog($role, 'deleted', 'The user has deleted role');

                DB::commit();
                return response()->json([
                                            'title'=> 'Success!' ,
                                            'message' => 'Role has been deleted.'
                                        ], 200);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                                            'title' => 'Failed!',
                                            'message' => 'Role failed to delete.'. $e->getMessage()
                                        ], 500);
            }
        }
    //CLOSE PROSES
}
