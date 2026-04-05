<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\OnboardingCredentialMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OnboardController extends Controller
{
    public function index()
    {
        $personnel = User::where('role', 'personnel')->latest()->get();
        return view('admin.onboard', compact('personnel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nss_number' => 'required|unique:users,nss_number',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required',
        ]);

        // Generate temporary password
        $tempPassword = 'NSS-' . strtoupper(Str::random(6));

        $user = User::create([
            'name' => 'Personnel ' . $request->nss_number, // Default name till they update profile
            'email' => $request->email,
            'password' => Hash::make($tempPassword),
            'nss_number' => $request->nss_number,
            'phone_number' => $request->phone_number,
            'role' => 'personnel',
            'status' => 'active',
            'password_must_change' => true,
        ]);

        Mail::to($user->email)->send(new OnboardingCredentialMail($user, $tempPassword));

        // For now, we'll store the temp password in the session for testing
        return back()->with('success', 'Personnel onboarded successfully! Credentials have been sent to their email. Temporary Password: ' . $tempPassword);
    }
}
