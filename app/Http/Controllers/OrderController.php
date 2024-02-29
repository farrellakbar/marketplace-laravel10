<?php

namespace App\Http\Controllers;

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
        return view('pages.frontend.order.checkout',compact('produks', 'order'));
    }
}
