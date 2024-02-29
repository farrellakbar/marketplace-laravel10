<?php

namespace App\Http\Controllers;

use App\Models\CobaMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CobaMenuController extends Controller
{
    public function index(){
        return view('pages.backend.cobamenu.index');
    }
    public function datatable(){
        $cobaMenus = CobaMenu::orderby('name', 'asc')->get();
        return datatables()->of($cobaMenus)
                        ->addColumn('id', function ($row) {
                            $id = encrypt($row->id);
                            return $id;
                        })
                        ->make();
    }
    public function create(){
        return view('pages.backend.cobamenu.modal.create');
    }
    public function store(Request $request){
        try {
            DB::beginTransaction();
            //OPEN VALIDASI INPUTAN
                $validate = $request->validate([
                    'name' => 'required|string',
                ]);
            //CLOSE VALIDASI INPUTAN
            //OPEN CREATE
                $cobaMenu = new CobaMenu();
                $cobaMenu->name = $validate['name'];
                $cobaMenu->is_active = $request->is_active == 'true' ? true : false;
                $cobaMenu->save();
            //CLOSE CREATE

            ActivityLogController::activtyLog($cobaMenu, 'created', 'The user has created coba menu');

            DB::commit();
            return response()->json([
                'title' => 'Success!',
                'message' => 'Coba Menu added successfully.'
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
    public function edit($param){
        $id = decrypt($param);
        $cobaMenu = CobaMenu::findorfail($id);
        return view('pages.backend.cobamenu.modal.edit', compact('cobaMenu'));
    }
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
                $cobaMenu = CobaMenu::findOrFail($id);
                $cobaMenu->name = $validate['name'];
                $cobaMenu->is_active = $request->is_active == 'true' ? true : false;
                $cobaMenu->save();
            //CLOSE UPDATE

            ActivityLogController::activtyLog($cobaMenu, 'updated', 'The user has updated coba menu');

            DB::commit();
            return response()->json([
                'title' => 'Success!',
                'message' => 'Coba menu updated successfully.'
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
    public function delete($param)
    {
        try {
            DB::beginTransaction();
            $id = decrypt($param);
            $cobaMenu = CobaMenu::find($id);
            $cobaMenuDelete = $cobaMenu;
            $cobaMenu->delete();
            ActivityLogController::activtyLog($cobaMenuDelete, 'deleted', 'The user has deleted coba menu');

            DB::commit();
            return response()->json([
                                        'title'=> 'Success!' ,
                                        'message' => 'Coba Menu has been deleted.'
                                    ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                                        'title' => 'Failed!',
                                        'message' => 'Coba Menu failed to delete.'. $e->getMessage()
                                    ], 500);
        }
    }
}
