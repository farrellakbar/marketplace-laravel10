<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OpdController extends Controller
{
    //OPEN HALAMAN UTAMA
        public function index(){
            return view('pages.backend.opds.index');
        }
    //CLOSE HALAMAN UTAMA
    //OPEN PROSES GET DATATABLE
        public function datatable(){
            $opds = Opd::orderby('name', 'asc')->get();
            return datatables()->of($opds)
                            ->addColumn('id', function ($row) {
                                $id = encrypt($row->id);
                                return $id;
                            })
                            ->make();
        }
    //CLOSE PROSES GET DATATABLE
    //OPEN MODAL CREATE
        public function create(){
            return view('pages.backend.opds.modals.create');
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
                    $opd = new Opd();
                    $opd->name = $validate['name'];
                    $opd->is_active = $request->is_active == 'true' ? true : false;
                    $opd->save();
                //CLOSE CREATE

                ActivityLogController::activtyLog($opd, 'created', 'The user has created opd');

                DB::commit();
                return response()->json([
                    'title' => 'Success!',
                    'message' => 'Opd added successfully.'
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
            $opd = Opd::findorfail($id);
            return view('pages.backend.opds.modals.edit', compact('opd'));
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
                    $opd = Opd::findOrFail($id);
                    $opd->name = $validate['name'];
                    $opd->is_active = $request->is_active == 'true' ? true : false;
                    $opd->save();
                //CLOSE UPDATE

                ActivityLogController::activtyLog($opd, 'updated', 'The user has updated opd');

                DB::commit();
                return response()->json([
                    'title' => 'Success!',
                    'message' => 'Opd updated successfully.'
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
                $opd = Opd::find($id);
                $opdDelete = $opd;
                $opd->delete();
                ActivityLogController::activtyLog($opdDelete, 'deleted', 'The user has deleted opd');

                DB::commit();
                return response()->json([
                                            'title'=> 'Success!' ,
                                            'message' => 'Opd has been deleted.'
                                        ], 200);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                                            'title' => 'Failed!',
                                            'message' => 'Opd failed to delete.'. $e->getMessage()
                                        ], 500);
            }
        }
    //CLOSE PROSES DELETE
}
