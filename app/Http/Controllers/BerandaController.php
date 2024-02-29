<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index(){
        $produks = Produk::where('is_active', true)->get();
        return view('pages.frontend.beranda', compact('produks'));
    }
}
