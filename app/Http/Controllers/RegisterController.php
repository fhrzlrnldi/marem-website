<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register', [
            'title' => 'Register'
        ]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required','max:255'],
            'email' => ['required', 'email:dns', 'unique:users'],
            'phone' => ['required'],
            'password' => ['required', 'min:5','max:255'],
            'password_confirmation' => ['required', 'same:password']
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);
        $validatedData['status_user'] = 1; // Set status_user ke 1 (pending approval)
        User::create($validatedData);

        return redirect()->route('login')->with('success', 'Registrasi Berhasil!');    
    }
}
