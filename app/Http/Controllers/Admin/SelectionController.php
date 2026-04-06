<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OnboardingRecord;
use Illuminate\Http\Request;

class SelectionController extends Controller
{
    /**
     * Display a listing of personnel available to be shortlisted.
     */
    public function shortlistIndex()
    {
        // Get all personnel who haven't been endorsed yet
        $personnel = User::where('role', 'personnel')
            ->whereDoesntHave('onboardingRecord', function($q) {
                $q->where('status', 'endorsed');
            })
            ->with('onboardingRecord')
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
            ->whereHas('onboardingRecord', function($q) {
                $q->where('status', 'shortlisted');
            })
            ->with('onboardingRecord')
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
