<?php

namespace App\Http\Controllers;

use App\Models\KeranjangDetail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(){
        $user = auth()->user();
        $orders = Order::select('orders.*')
                        ->join('keranjang_details', 'orders.id', '=', 'keranjang_details.order_id')
                        ->join('produks', 'keranjang_details.produk_id', '=', 'produks.id')
                        ->where('keranjang_details.status', '!=', 'Keranjang')
                        ->groupBy('orders.id')
                        ->get();
        return view('pages.frontend.order.index',compact('orders'));
    }

    public function detailCheckout($param){
        $id = decrypt($param);
        $user = auth()->user();
        $order = Order::find($id);
        $produks = $user->produks()->wherePivot('order_id', $id)->get();
        $snapToken = null;
        if ( $produks[0]->pivot->status === 'checkout') {
            //API PAYMENT GATEWAY
            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = false;
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;

            $params = array(
                'transaction_details' => array(
                    'order_id' => $order->id,
                    'gross_amount' => $order->total_harga,
                ),
                'customer_details' => array(
                    'first_name' => $user->name,
                    'last_name' => '',
                    'email' => $user->email,
                ),
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);
        }
        return view('pages.frontend.order.checkout',compact('produks', 'order','snapToken'));
    }
    public function callback(Request $request){
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);

        if($hashed == $request->signature_key){
            if($request->transaction_status == "capture" or $request->transaction_status == "settlement"){
                KeranjangDetail::where('order_id', $request->order_id)->update(['status' => 'lunas']);
            }
        }
    }
    public function coba(){
        KeranjangDetail::where('order_id', 17)->update(['status' => 'lunas']);

        // $user->produks()->wherePivot('order_id', 4)->updateExistingPivot($produks->pluck('id'), ['status' => 'lunas']);
        dd( 'aa' );
    }
}
