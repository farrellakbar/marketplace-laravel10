<?php

namespace App\Http\Controllers;

use App\Models\KeranjangDetail;
use App\Models\Order;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Builder\Function_;

class KeranjangController extends Controller
{
    public function index($param){
        $id = decrypt($param);
        $user = User::find($id);
        return view('pages.frontend.keranjang.index', compact('user'));
    }

    public function addToCart($param){
        try {
            DB::beginTransaction();
            $produk_id = decrypt($param);
            $user = User::find(auth()->user()->id);
            $keranjang = KeranjangDetail::where('produk_id', $produk_id)
                                        ->where('user_id', $user->id)
                                        ->wherenull('order_id')
                                        ->first();
            $produk = Produk::find($produk_id);
            if($keranjang){
                $keranjang->quantity++;
                $keranjang->sub_total = $keranjang->quantity * $produk->harga;
                $keranjang->save();
                ActivityLogController::activtyLog($keranjang, 'updated', 'The user has updated cart');
            }
            else{
                $keranjang = new KeranjangDetail();
                $keranjang->produk_id = $produk_id;
                $keranjang->user_id = $user->id;
                $keranjang->quantity = 1;
                $keranjang->sub_total = $keranjang->quantity * $produk->harga;
                $keranjang->save();
                ActivityLogController::activtyLog($keranjang, 'created', 'The user has created cart');
            }
            DB::commit();
            return response()->json([
                'title' => 'Success!',
                'message' => 'Produk added cart.'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'title' => 'Failed!',
                'message' => 'Data processing failure, '. $e->getMessage()
            ], 500);
        }
    }


    public function updateQuantityCart(Request $request, $param){
        try {
            DB::beginTransaction();
            $produk_id = ($param);
            $produk = Produk::find($produk_id);
            $user = User::find(auth()->user()->id);
            $sub_total = $request->quantity * $produk->harga;

            $user->produks()->wherePivot('order_id', null)->updateExistingPivot($produk_id, ['quantity' => $request->quantity, 'sub_total' => $sub_total]);

            DB::commit();
            return response()->json([
                'title' => 'Success!',
                'message' => 'User updated quantity product.',
                'sub_total' => $sub_total
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'title' => 'Failed!',
                'message' => 'Data processing failure, '. $e->getMessage()
            ], 500);
        }
    }

    public function removeProductCart($param){
        try {
            DB::beginTransaction();
            $user = User::find(auth()->user()->id);

            $user->produks()->wherePivot('order_id', null)->detach($param);
            DB::commit();
            return response()->json([
                'title' => 'Success!',
                'message' => 'User deleted product in the cart.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'title' => 'Failed!',
                'message' => 'Data processing failure, '. $e->getMessage()
            ], 500);
        }
    }

    public function checkout(Request $request){
        try {
            DB::beginTransaction();

            // $user = User::find(auth()->user()->id);
            // $total = $user->produks()->wherePivot('order_id', null)->sum(DB::raw('harga * quantity'));
            // $order = new Order();
            // $order->total_harga = $total;
            // $order->save();
            // $user->produks()->wherePivot('order_id', null)->updateExistingPivot($user->produks()->pluck('produk_id'), ['status' => 'checkout']);
            // $user->produks()->wherePivot('order_id', null)->updateExistingPivot($user->produks()->pluck('produk_id'), ['order_id' => $order->id]);
            /////////////////////////////////////////////////////////////////////////
            $user = User::find(auth()->user()->id);
            $total = $user->produks()->wherePivot('order_id', null)->sum(DB::raw('harga * quantity'));
            $order = new Order();
            $order->total_harga = $total;
            $order->save();
            $produkPivot = $user->produks()->wherePivot('order_id', null)->withPivot('quantity')->get();
            $user->produks()->wherePivot('order_id', null)->updateExistingPivot($user->produks()->pluck('produk_id'), ['status' => 'checkout']);
            $user->produks()->wherePivot('order_id', null)->updateExistingPivot($user->produks()->pluck('produk_id'), ['order_id' => $order->id]);
            foreach ($produkPivot as $produk) {
                if ($produk->stok >= $produk->pivot->quantity) {
                    $produk->stok -= $produk->pivot->quantity;
                    $produk->save();
                }
                else {
                    DB::rollback();
                    return response()->json([
                        'icon' => 'error',
                        'title' => 'Gagal!',
                        'message' => $produk->name.' stok yang tersedia tidak tercukupi.',
                    ], 200);
                }

            }
            DB::commit();
            return response()->json([
                'icon' => 'success',
                'title' => 'Success!',
                'message' => 'User has checkout product.',
                'id' => encrypt( $order->id),
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'icon' => 'error',
                'title' => 'Failed!',
                'message' => 'Data processing failure, '. $e->getMessage()
            ], 500);
        }    }
}
