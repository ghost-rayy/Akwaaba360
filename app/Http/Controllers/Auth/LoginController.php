<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        // Support email or staff_number/nss_number
        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : (is_numeric($request->login) ? 'staff_number' : 'nss_number');

        if (Auth::attempt([$loginField => $request->login, 'password' => $request->password])) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            if ($user->password_must_change) {
                return redirect()->route('password.change');
            }

            if ($user->isHrAdmin()) {
                return redirect()->intended('admin/dashboard');
            } elseif ($user->isHrStaff()) {
                return redirect()->intended('staff/dashboard');
            } else {
                return redirect()->intended('personnel/dashboard');
            }
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
