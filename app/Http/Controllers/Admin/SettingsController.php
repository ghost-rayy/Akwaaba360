<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Setting;
use App\Mail\OnboardingCredentialMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    /**
     * Display the settings page with company info and HR staff list.
     */
    public function index()
    {
        $settings = Setting::first() ?? new Setting();
        $hrStaff = User::where('role', 'hr_staff')->latest()->get();

        return view('admin.settings', compact('settings', 'hrStaff'));
    }

    /**
     * Update company details and handle file uploads.
     */
    public function updateCompany(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email|max:255',
            'company_phone' => 'required|string|max:255',
            'po_box' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stamp' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $settings = Setting::first() ?? new Setting();
        
        $data = $request->only(['company_name', 'company_email', 'company_phone', 'po_box']);

        // Handle Asset Deletion Flags
        if ($request->delete_logo == "1" && $settings->logo_path) {
            Storage::disk('public')->delete($settings->logo_path);
            $data['logo_path'] = null;
        }
        if ($request->delete_signature == "1" && $settings->signature_path) {
            Storage::disk('public')->delete($settings->signature_path);
            $data['signature_path'] = null;
        }
        if ($request->delete_stamp == "1" && $settings->stamp_path) {
            Storage::disk('public')->delete($settings->stamp_path);
            $data['stamp_path'] = null;
        }

        // Handle File Uploads
        if ($request->hasFile('logo')) {
            if ($settings->logo_path) Storage::disk('public')->delete($settings->logo_path);
            $data['logo_path'] = $request->file('logo')->store('branding', 'public');
        }

        if ($request->hasFile('signature')) {
            if ($settings->signature_path) Storage::disk('public')->delete($settings->signature_path);
            $data['signature_path'] = $request->file('signature')->store('assets', 'public');
        }

        if ($request->hasFile('stamp')) {
            if ($settings->stamp_path) Storage::disk('public')->delete($settings->stamp_path);
            $data['stamp_path'] = $request->file('stamp')->store('assets', 'public');
        }

        if ($settings->exists) {
            $settings->update($data);
        } else {
            Setting::create($data);
        }

        return back()->with('success', 'Company profile and assets updated successfully.');
    }

    /**
     * Store new HR Staff members.
     */
    public function storeStaff(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'staff_number' => 'required|unique:users,staff_number',
        ]);

        $tempPassword = 'HR-' . strtoupper(Str::random(6));

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'staff_number' => $request->staff_number,
            'password' => Hash::make($tempPassword),
            'role' => 'hr_staff',
            'status' => 'active',
            'password_must_change' => true,
        ]);

        Mail::to($user->email)->send(new OnboardingCredentialMail($user, $tempPassword));

        return back()->with('success', "HR Staff authorized successfully! Credentials have been sent to their email. Temporary Password: {$tempPassword}");
    }

    public function destroyStaff($id)
    {
        $user = User::where('id', $id)->where('role', 'hr_staff')->firstOrFail();
        $user->delete();

        return back()->with('success', 'HR Staff account has been removed.');
    }

    public function updateStaff(Request $request, $id)
    {
        $user = User::where('id', $id)->where('role', 'hr_staff')->firstOrFail();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'staff_number' => 'required|unique:users,staff_number,' . $user->id,
        ]);

        $emailChanged = $user->email !== $request->email;

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'staff_number' => $request->staff_number,
        ]);

        if ($emailChanged) {
            $tempPassword = $this->sendNewStaffCredentials($user);
            return back()->with('success', "Staff updated! Email changed, so new credentials were sent. New Temp Password: {$tempPassword}");
        }

        return back()->with('success', 'HR Staff details updated successfully.');
    }

    public function resendStaffCredentials($id)
    {
        $user = User::where('id', $id)->where('role', 'hr_staff')->firstOrFail();
        $tempPassword = $this->sendNewStaffCredentials($user);
        
        return back()->with('success', "New credentials generated and sent! New Temp Password: {$tempPassword}");
    }

    private function sendNewStaffCredentials(User $user)
    {
        $tempPassword = 'HR-' . strtoupper(Str::random(6));
        
        $user->update([
            'password' => Hash::make($tempPassword),
            'password_must_change' => true,
        ]);

        Mail::to($user->email)->send(new OnboardingCredentialMail($user, $tempPassword));

        return $tempPassword;
    }
}
