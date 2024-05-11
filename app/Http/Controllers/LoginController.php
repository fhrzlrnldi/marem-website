<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('login', [
            'title' => 'Login'
        ]);
    }

    // public function auth(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     if(Auth::attempt($credentials)){
    //         $request->session()->regenerate();

    //         if(auth()->user()->role_id == 2){
                
    //             return redirect()->route('admin');
    //         }else{
    //             return redirect('/index');
    //         }
            
    //     } else {
    //         return back()->with('loginError', 'Email atau Password anda salah!');
    //     }
    // }
    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->status_user == 2) {
                // Status approved, lanjutkan dengan logika login yang ada
                $request->session()->regenerate();
                
                if ($user->role_id == 2) {
                    return redirect()->route('admin');
                } else {
                    return redirect('/index');
                }
            } else {
                // Status belum diapprove, logout dan tampilkan pesan
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->with('loginError', 'Akun Anda belum diapprove oleh admin.');
            }
        } else {
            return back()->with('loginError', 'Email atau Password Anda salah!');
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/index');
    }
}
