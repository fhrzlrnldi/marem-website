<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Produk;

class AdminController extends Controller
{
    public function index()
    {
        $jumlahProdukAktif = Produk::where('status', 1)->count();
        $jumlahPenggunaAktif = User::where('status_user', 2)->count();
        $jumlahUser = User::count();
        $jumlahProduk = Produk::count();
        

        $produkTerbaru = Produk::latest()->paginate(10);

        return view('admin', compact('produkTerbaru','jumlahProdukAktif', 'jumlahPenggunaAktif', 'jumlahUser', 'jumlahProduk'));
    }
}
