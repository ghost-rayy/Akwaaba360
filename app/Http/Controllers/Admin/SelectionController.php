<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OnboardingRecord;
use App\Models\PersonnelProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SelectionController extends Controller
{
    /** 
     * Stream a document as a binary blob for the in-system viewer.
     */
    public function streamDocument(PersonnelProfile $profile)
    {
        if (!Storage::disk('public')->exists($profile->posting_letter_path)) {
            abort(404, 'Document not found.');
        }

        $fullPath = storage_path('app/public/' . $profile->posting_letter_path);
        
        return response()->file($fullPath, [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="document.bin"',
            'X-Frame-Options' => 'SAMEORIGIN'
        ]);
    }

    /**
     * Display a listing of personnel available to be shortlisted.
     */
    public function shortlistIndex()
    {
        // Get all personnel who have completed their onboarding profile but haven't been endorsed yet
        $personnel = User::where('role', 'personnel')
            ->whereHas('personnelProfile') // Only those who completed the wizard
            ->whereDoesntHave('onboardingRecord', function($q) {
                $q->where('status', 'endorsed');
            })
            ->with(['onboardingRecord', 'personnelProfile'])
            ->latest()
            ->get();

        return view('admin.shortlist', compact('personnel'));
    }

    /**
     * Mark a personnel as shortlisted.
     */
    public function shortlistStore($userId)
    {
        $user = User::findOrFail($userId);
        
        OnboardingRecord::updateOrCreate(
            ['user_id' => $user->id],
            [
                'status' => 'shortlisted',
                'shortlisted_at' => now(),
            ]
        );

        return back()->with('success', 'Personnel successfully shortlisted for endorsement.');
    }

    /**
     * Display a listing of shortlisted personnel waiting for endorsement.
     */
    public function endorseIndex()
    {
        $personnel = User::where('role', 'personnel')
            ->whereHas('personnelProfile') // Extra safety check
            ->whereHas('onboardingRecord', function($q) {
                $q->where('status', 'shortlisted');
            })
            ->with(['onboardingRecord', 'personnelProfile'])
            ->latest()
            ->get();

        return view('admin.endorse', compact('personnel'));
    }

    /**
     * Finalize the endorsement of a personnel.
     */
    public function endorseStore($userId)
    {
        $user = User::findOrFail($userId);
        
        $record = $user->onboardingRecord;
        if ($record) {
            $record->update([
                'status' => 'endorsed',
                'endorsed_at' => now(),
            ]);
        }

        return back()->with('success', 'Personnel has been officially endorsed for placement.');
    }
}
