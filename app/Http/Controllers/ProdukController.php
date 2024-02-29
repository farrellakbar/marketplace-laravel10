<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


class ProdukController extends Controller
{
    public function index(){
        return view('pages.backend.produks.index');
    }
    //OPEN PROSES GET DATATABLE
        public function datatable(){
            $produks = Produk::with('dokumen')->orderby('name', 'asc')->get();
            return datatables()->of($produks)
                            ->addColumn('id', function ($row) {
                                $id = encrypt($row->id);
                                return $id;
                            })
                            ->make();
        }
    //CLOSE PROSES GET DATATABLE
    //OPEN MODAL CREATE
        public function create(){
            return view('pages.backend.produks.modals.create');
        }
    //CLOSE MODAL CREATE
    //OPEN PROSES STORE
        public function store(Request $request){
            try {
                DB::beginTransaction();
                //OPEN VALIDASI INPUTAN
                    $validate = $request->validate([
                        'name' => 'required|string',
                        'stok' => 'required|integer',
                        'harga' => 'required|numeric',
                        'dokumen' => 'required|mimes:jpeg,png,jpg|max:5000',
                    ]);
                //CLOSE VALIDASI INPUTAN
                //OPEN CREATE
                    $file = $request->file('dokumen');
                    $ori_filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $name = strtolower(str_replace(' ', '_', $request->name));
                    $nama_file = $name . '_' . date('d-m-y') . '.' . $extension;

                    $dokumen = new Dokumen();
                    $dokumen->filename = $nama_file;
                    $dokumen->ori_filename = $ori_filename;
                    $dokumen->ekstensi = $extension;
                    $dokumen->type = 'foto';
                    $dokumen->jenis = 'upload';
                    $dokumen->keterangan = null;
                    $dokumen->file_path = 'produk/' .$nama_file;
                    $dokumen->save();

                    $produk = new Produk();
                    $produk->name = $validate['name'];
                    $produk->stok = $validate['stok'];
                    $produk->harga = $validate['harga'];
                    $produk->name = $validate['name'];
                    $produk->dokumen_id = $dokumen->id;
                    $produk->is_active = $request->is_active ? true : false;
                    $produk->save();
                //CLOSE CREATE
                ActivityLogController::activtyLog($produk, 'created', 'The user has created produk');
                $file->storeAs('produk', $nama_file, 'public');

                DB::commit();
                return response()->json([
                    'title' => 'Success!',
                    'message' => 'Produk added successfully.'
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
            $produk = Produk::findorfail($id);
            return view('pages.backend.produks.modals.edit', compact('produk','param'));
        }
    //CLOSE MODAL EDIT
    //OPEN PROSES UPDATE
        public function update(Request $request, $param){
            try {
                DB::beginTransaction();
                //OPEN VALIDASI INPUTAN
                    $validate = $request->validate([
                        'name' => 'required|string',
                        'stok' => 'required|integer',
                        'harga' => 'required|numeric',
                        'dokumen' => 'nullable|mimes:jpeg,png,jpg|max:5000',
                    ]);
                //CLOSE VALIDASI INPUTAN
                    $id = decrypt($param);

                //OPEN UPDATE
                    $produk = Produk::findOrFail($id);
                    $produk->name = $validate['name'];
                    $produk->stok = $validate['stok'];
                    $produk->harga = $validate['harga'];
                    $produk->name = $validate['name'];
                    $produk->is_active = $request->is_active ? true : false;
                    $produk->save();
                    $file = $request->file('dokumen');
                    if($file){
                        $ori_filename = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $name = strtolower(str_replace(' ', '_', $request->name));
                        $nama_file = $name . '_' . date('d-m-y') . '.' . $extension;
                        // dd($nama_file, $extension);
                        if (Storage::disk('public')->exists(($produk->dokumen->file_path)))
                        {
                            Storage::disk('public')->delete(($produk->dokumen->file_path));
                        }
                        $dokumen = Dokumen::findOrFail($produk->dokumen_id);
                        $dokumen->filename = $nama_file;
                        $dokumen->ori_filename = $ori_filename;
                        $dokumen->ekstensi = $extension;
                        $dokumen->type = 'foto';
                        $dokumen->jenis = 'upload';
                        $dokumen->keterangan = null;
                        $dokumen->file_path = 'produk/' .$nama_file;
                        $dokumen->save();

                        $produk->dokumen_id = $dokumen->id;
                        $produk->save();
                        $file->storeAs('produk', $nama_file, 'public');
                    }
                //CLOSE UPDATE

                ActivityLogController::activtyLog($produk, 'updated', 'The user has updated produk');

                DB::commit();
                return response()->json([
                    'title' => 'Success!',
                    'message' => 'Produk updated successfully.',
                    'dokumen' => $param
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
                $produk = Produk::find($id);
                $produkDelete = $produk;
                $produk->delete();
                $dokumen = Dokumen::find($produkDelete->dokumen_id);
                if (Storage::disk('public')->exists(($produkDelete->dokumen->file_path)))
                {
                    Storage::disk('public')->delete(($produkDelete->dokumen->file_path));
                }
                $dokumen->delete();
                ActivityLogController::activtyLog($produkDelete, 'deleted', 'The user has deleted produk');

                DB::commit();
                return response()->json([
                                            'title'=> 'Success!' ,
                                            'message' => 'Produk has been deleted.'
                                        ], 200);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                                            'title' => 'Failed!',
                                            'message' => 'Produk failed to delete.'. $e->getMessage()
                                        ], 500);
            }
        }
    //CLOSE PROSES DELETE
}
