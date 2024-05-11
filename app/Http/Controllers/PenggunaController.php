<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = User::all();
        return view('approve.pengguna', compact('pengguna'));
    }

    public function edit($id)
    {
        $pengguna = User::where('id',$id)->first();
        return view('approve.editpengguna', compact('pengguna')); 
    }

    public function update(Request $request)
    {
        $pengguna = User::where('id',$request->id)->first();
        // Validasi input
        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email:dns', 'unique:users,email,' . $request->id],
            'phone' => ['required'],
            'status' => 'required', // Sesuaikan dengan tipe data kolom status_user
        ]);

        // $pengguna->update($validatedData);
        $pengguna->status_user = $request->status;
        $pengguna->save();
        // dd($pengguna);
        return redirect()->route('pengguna')->with('success', 'Produk berhasil diperbarui!');
    }

    public function approve(Request $request, $id)
    {
        // dd($id);
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Setujui user dengan mengubah statusnya menjadi 'aktif' (sesuai dengan definisi Anda)
        $user->status_user = 2; // Sesuaikan dengan definisi status yang digunakan
        $user->save();

        return redirect('pengguna')->with('message', 'User approved successfully');
    }
    // public function approve(Request $request, $id)
    // {
    //     try {
    //         $affectedRows = User::where('id', $id)
    //             ->update(['status_user' => 1]); // Sesuaikan dengan definisi status yang digunakan

    //         if ($affectedRows === 0) {
    //             return response()->json(['message' => 'User not found'], 404);
    //         }

    //         return back()->with('message', 'User approved successfully');
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

}
