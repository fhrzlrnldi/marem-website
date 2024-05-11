<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Produk;

class UserController extends Controller
{
    public function indexuser()
    {
        $produkpengguna = Produk::where('status', 1)->get();
        return view('index', compact('produkpengguna'));
    }
}
