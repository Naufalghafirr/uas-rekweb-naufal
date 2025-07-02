<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $validatedData['email'])->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Email tidak ditemukan!');
        }

        if (Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
            return redirect()->route('products.index');
        } else {
            return redirect()->route('login')->with('error', 'Password tidak sesuai!');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
