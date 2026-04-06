<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    /**
     * Show the password change form.
     */
    public function showChangeForm()
    {
        return view('auth.passwords.change');
    }

    /**
     * Update the user's password.
     */
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',      // At least one uppercase
                'regex:/[0-9]/',      // At least one number
                'regex:/[@$!%*#?&]/', // At least one special character
            ],
        ], [
            'new_password.regex' => 'The password must contain at least one uppercase letter, one number, and one special character (@$!%*#?&).',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided current password does not match our records.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
            'password_must_change' => false,
        ]);

        if ($user->isPersonnel()) {
            return redirect()->route('personnel.dashboard')->with('success', 'Your account has been successfully secured. Welcome to Akwaaba360.');
        }

        return redirect()->route('admin.dashboard')->with('success', 'Your account has been successfully secured and your administrative dashboard is now fully unlocked.');
    }
}
