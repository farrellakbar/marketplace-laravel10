<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\FacadesDB;
use Illuminate\Validation\ValidationException;
use App\Rules\PasswordStrength;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
   //OPEN HALAMAN UTAMA
        public function index(){
            return view('pages.backend.users.index');
        }
    //CLOSE HALAMAN UTAMA
    //OPEN PROSES GET DATATABLE
        public function datatable(){
            $users = User::orderby('name', 'asc')->get();
            return datatables()->of($users)
                            ->addColumn('id', function ($row) {
                                $id = encrypt($row->id);
                                return $id;
                            })
                            ->make();
        }
    //CLOSE PROSES GET DATATABLE
    //OPEN MODAL CREATE
        public function create(){
            return view('pages.backend.users.modals.create');
        }
    //CLOSE MODAL CREATE
    //OPEN PROSES STORE
        public function store(Request $request){
            try {
                DB::beginTransaction();
                //OPEN VALIDASI INPUTAN
                    $validate = $request->validate([
                        'name' => 'required|string|min:3|max:100',
                        'email' => 'required|email|unique:users',
                        'password' => [
                                            'required',
                                            'string',
                                            'min:8',
                                            new PasswordStrength,
                                        ],
                    ]);
                //CLOSE VALIDASI INPUTAN
                //OPEN CREATE USER
                    $user = new User();
                    $user->name = $validate['name'];
                    $user->email = $validate['email'];
                    $user->password = bcrypt($validate['password']);
                    $user->is_active = $request->is_active ? true : false;
                    $user->save();
                //CLOSE CREATE USER

                ActivityLogController::activtyLog($user, 'created', 'The user has created new user');

                DB::commit();
                return response()->json([
                    'title' => 'Success!',
                    'message' => 'User added successfully.'
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
                    'message' => 'Data gagal proses.'. $e->getMessage()
                ], 500);
            }
        }
    //CLOSE PROSES STORE
    //OPEN MODAL EDIT
        public function edit($param){
            $id = decrypt($param);
            $user = User::findorfail($id);
            return view('pages.backend.users.modals.edit', compact('user'));
        }
    //CLOSE MODAL EDIT
    //OPEN PROSES UPDATE
        public function update(Request $request, $param){
            try {
                DB::beginTransaction();
                $id = decrypt($param);
                //OPEN VALIDASI INPUTAN
                    //VALIDASI JIKA TIDAK DENGAN GANTI PASSWORD
                    if($request->password == null){
                        $validate = $request->validate([
                            'name' => 'required|string|min:3|max:100',
                            'email' => 'required|unique:users,email,' . $id . '',
                        ]);
                    }
                    //VALIDASI JIKA DENGAN GANTI PASSWORD
                    else{
                        $validate = $request->validate([
                            'name' => 'required|string|min:3|max:100',
                            'email' => 'required|unique:users,email,' . $id . '',
                            'password' => [
                                'required',
                                'string',
                                'min:8',
                                new PasswordStrength,
                            ],
                        ]);
                    }
                //CLOSE VALIDASI INPUTAN
                    $id = decrypt($param);
                //OPEN UPDATE
                    $user = User::findOrFail($id);
                    $user->name = $validate['name'];
                    $user->email = $validate['email'];
                    if($request->password != null){
                        $user->password = bcrypt($validate['password']);
                    }
                    $user->is_active = $request->is_active ? true : false;
                    $user->save();
                //CLOSE UPDATE

                ActivityLogController::activtyLog($user, 'updated', 'The user has updated user');

                DB::commit();
                return response()->json([
                    'title' => 'Success!',
                    'message' => 'User updated successfully.'
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
                $user = User::find($id);
                $userDelete = $user;
                $user->delete();
                ActivityLogController::activtyLog($userDelete, 'deleted', 'The user has deleted user');

                DB::commit();
                return response()->json([
                                            'title'=> 'Success!' ,
                                            'message' => 'User has been deleted.'
                                        ], 200);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                                            'title' => 'Failed!',
                                            'message' => 'User failed to delete.'. $e->getMessage()
                                        ], 500);
            }
        }
    //CLOSE PROSES DELETE
}
