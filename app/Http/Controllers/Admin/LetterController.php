<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OnboardingRecord;
use App\Mail\AppointmentLetterMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LetterController extends Controller
{
    /**
     * Display a listing of personnel ready for appointment letters.
     */
    public function index()
    {
        // Get all personnel who have been officially endorsed
        $personnel = User::where('role', 'personnel')
            ->whereHas('onboardingRecord', function($q) {
                $q->where('status', 'endorsed');
            })
            ->with('onboardingRecord')
            ->latest()
            ->get();

        return view('admin.appointment-letter.index', compact('personnel'));
    }

    /**
     * Display the official appointment letter for a specific personnel.
     */
    public function show($userId)
    {
        $user = User::where('id', $userId)
            ->where('role', 'personnel')
            ->firstOrFail();

        // Mark as letter_generated if needed (state machine logic)
        // Here we just display it.
        
        return view('admin.appointment-letter.show', compact('user'));
    }

    /**
     * Send official appointment notification via email.
     */
    public function send($userId)
    {
        $user = User::where('id', $userId)
            ->where('role', 'personnel')
            ->firstOrFail();

        Mail::to($user->email)->send(new AppointmentLetterMail($user));

        return back()->with('success', "Specialized appointment alert has been dispatched to {$user->name}.");
    }
}
