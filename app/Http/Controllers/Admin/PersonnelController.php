<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class PersonnelController extends Controller
{
    /**
     * Display a listing of all personnel and their current statuses.
     */
    public function index()
    {
        $personnel = User::where('role', 'personnel')
            ->with(['onboardingRecord', 'department'])
            ->latest()
            ->get();

        $departments = Department::all();

        return view('admin.manage-personnel', compact('personnel', 'departments'));
    }

    /**
     * Assign a personnel to a department.
     */
    public function assignDepartment(Request $request, $id)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
        ]);

        $user = User::findOrFail($id);
        $user->update(['department_id' => $request->department_id]);

        return back()->with('success', 'Personnel successfully assigned to the department.');
    }

    /**
     * Toggle the status of a personnel.
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $newStatus = ($user->status === 'active') ? 'suspended' : 'active';
        $user->update(['status' => $newStatus]);

        return back()->with('success', 'Personnel account status updated.');
    }
}
