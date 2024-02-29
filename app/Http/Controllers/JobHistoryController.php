<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\Role;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobHistoryController extends Controller
{
     //OPEN HALAMAN UTAMA
        public function index(){
            return view('pages.backend.jobs.index');
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
                            ->addColumn('role_id', function ($row) {
                                if(isset($row->roles[0])){
                                    $id = encrypt( $row->roles(['job_historys.is_active' => true])->first()->id);
                                }
                                else{
                                    $id = null;
                                }
                                return $id;
                            })
                            ->addColumn('role_name', function ($row) {
                                if(isset($row->roles[0])){
                                    $name =  $row->roles(['job_historys.is_active' => true])->first()->name;
                                }
                                else{
                                    $name = '-';
                                }
                                return $name;
                            })
                            ->addColumn('job_history_is_active', function ($row) {
                                if(isset($row->roles[0])){
                                    $name =  $row->roles(['job_historys.is_active' => true])->first()->pivot->is_active;
                                }
                                else{
                                    $name = '-';
                                }
                                return $name;
                            })
                            ->make();
        }
    //CLOSE PROSES GET DATATABLE
    //OPEN MODAL SHOW
        public function show($param){
            $id = decrypt($param);
            $jobHistorys = DB::table('users')
                            ->select('roles.name as role_name', 'job_historys.*')
                            ->join('job_historys', 'job_historys.users_id', '=', 'users.id')
                            ->join('roles', 'roles.id', '=', 'job_historys.roles_id')
                            ->where('users.id', $id)
                            ->orderBy('job_historys.is_active', 'desc')
                            ->get();
            return view('pages.backend.jobs.modals.show', compact('jobHistorys'));
        }
    //CLOSE MODAL SHOW
    //OPEN MODAL EDIT
        public function edit($param){
            $id = decrypt($param);
            $user = User::findorfail($id);
            $roles = Role::get_dataIsActive(true);
            return view('pages.backend.jobs.modals.edit', compact('user', 'roles'));
        }
    //CLOSE MODAL EDIT
    //OPEN PROSES UPDATE
        public function update(Request $request, $param){
            try {
                DB::beginTransaction();
                //OPEN VALIDASI INPUTAN
                    $validate = $request->validate([
                        'role_id' => 'required|integer',
                    ]);
                //CLOSE VALIDASI INPUTAN
                    $id = decrypt($param);
                //OPEN UPDATE
                    $user = User::findOrFail($id);
                    $role = Role::find($request->role_id);
                    //Check if user have a job assigned
                    $cekJobHistory = $user->roles(['job_historys.is_active' => true])->first();
                    //If user have
                    if($cekJobHistory){
                        //user change job
                        //user get job history active
                        $jobHistory = $user->roles(['job_historys.is_active' => true])->first()->pivot;
                        //if user change data job
                        if($jobHistory->roles_id != $request->role_id){
                            $jobHistory->is_active = false;
                            $jobHistory->valid_to = now();
                            $jobHistory->save();
                            //assign job history
                            $user->roles()->attach($role, ['valid_from' => now(), 'is_active' => true]);
                        }
                    }
                    //if the user doesn't have one yet
                    else{
                        //assign job history
                        $user->roles()->attach($role, ['valid_from' => now(), 'is_active' => true]);
                    }
                //CLOSE UPDATE

                ActivityLogController::activtyLog($user, 'updated', 'The user has updated job');

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
}
