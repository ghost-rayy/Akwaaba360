<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PersonnelProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function showWizard()
    {
        // If profile already exists, redirect to dashboard
        if (Auth::user()->personnelProfile) {
            return redirect()->route('personnel.dashboard');
        }

        return view('personnel.profile.complete');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            // Step 1
            'first_name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'residence' => 'required|string|max:1000',
            
            // Step 2
            'university' => 'required|string|max:255',
            'program' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
            
            // Step 3
            'nss_posting_letter' => 'required|file|mimes:pdf|max:5120',
            'confirmation' => 'accepted',
        ]);

        // Handle File Upload
        $path = $request->file('nss_posting_letter')->store('personnel/docs', 'public');

        PersonnelProfile::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'surname' => $request->surname,
            'gender' => $request->gender,
            'residence' => $request->residence,
            'university' => $request->university,
            'program' => $request->program,
            'region' => $request->region,
            'academic_year' => $request->academic_year,
            'posting_letter_path' => $path,
            'confirmed_at' => now(),
        ]);

        return redirect()->route('personnel.dashboard')->with('success', 'Onboarding completed! Welcome to Akwaaba360.');
    }
}
