<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function create()
    {
        return view(
            'Login'
        );
    }

    public function store(Request $request)
    {
        $result = Auth::attempt($request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]), true);


        if ($result) {
            $request->session()->regenerate();

            return redirect()->intended('/admin/vacancy')->with('success', 'Admin Login successful!');
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
