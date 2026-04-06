<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_personnel' => User::where('role', 'personnel')->count(),
            'pending_endorsement' => \App\Models\OnboardingRecord::where('status', 'shortlisted')->count(),
            'total_departments' => Department::count(),
        ];

        $recentOnboarding = User::where('role', 'personnel')
            ->with(['personnelProfile', 'onboardingRecord'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOnboarding'));
    }
}
