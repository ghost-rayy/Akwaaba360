<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of departments.
     */
    public function index()
    {
        $departments = Department::with('supervisor')
            ->withCount('personnel')
            ->latest()
            ->get();

        // Get all HR Staff to populate the supervisor selection dropdown
        $supervisors = User::where('role', 'hr_staff')->get();

        return view('admin.manage-departments', compact('departments', 'supervisors'));
    }

    /**
     * Store a newly created department.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:departments,name',
            'supervisor_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string|max:255',
        ]);

        Department::create($request->all());

        return back()->with('success', 'New department established successfully.');
    }

    /**
     * Update the supervisor for an existing department.
     */
    public function updateSupervisor(Request $request, $id)
    {
        $request->validate([
            'supervisor_id' => 'required|exists:users,id',
        ]);

        $dept = Department::findOrFail($id);
        $dept->update(['supervisor_id' => $request->supervisor_id]);

        return back()->with('success', 'Department supervisor reassigned successfully.');
    }
}
