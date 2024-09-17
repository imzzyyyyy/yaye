<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login'); // Render the login form view
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
    
        if (Auth::guard('web')->attempt([
            'username' => $request->username, 
            'password' => $request->password
        ])) {
            return redirect()->route('projectt.dashboard.page');
        } else {
            return back()->withErrors(['Invalid credentials'])->withInput();
        }
    }
    
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login.form'); // Redirect to login form
    }
}

