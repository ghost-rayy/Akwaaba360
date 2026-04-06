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

        $tempPassword = 'NSS-' . strtoupper(Str::random(6));

        $user = User::create([
            'name' => $request->nss_number,
            'email' => $request->email,
            'password' => Hash::make($tempPassword),
            'nss_number' => $request->nss_number,
            'phone_number' => $request->phone_number,
            'role' => 'personnel',
            'status' => 'active',
            'password_must_change' => true,
        ]);

        Mail::to($user->email)->send(new OnboardingCredentialMail($user, $tempPassword));

        return back()->with('success', 'Personnel onboarded successfully! Temporary Password: ' . $tempPassword);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'required',
        ]);

        $emailChanged = $user->email !== $request->email;

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);

        if ($emailChanged) {
            $tempPassword = $this->sendNewCredentials($user);
            return back()->with('success', 'Personnel updated! Email changed, so new credentials were sent. New Temp Password: ' . $tempPassword);
        }

        return back()->with('success', 'Personnel details updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'Personnel record has been completely removed from the system.');
    }

    public function resendCredentials(User $user)
    {
        $tempPassword = $this->sendNewCredentials($user);
        return back()->with('success', 'New credentials generated and sent! New Temp Password: ' . $tempPassword);
    }

    private function sendNewCredentials(User $user)
    {
        $tempPassword = 'NSS-' . strtoupper(Str::random(6));
        
        $user->update([
            'password' => Hash::make($tempPassword),
            'password_must_change' => true,
        ]);

        Mail::to($user->email)->send(new OnboardingCredentialMail($user, $tempPassword));

        return $tempPassword;
    }
}
