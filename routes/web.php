<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\OnboardController;
use App\Http\Controllers\Admin\SelectionController;
use App\Http\Controllers\Admin\LetterController;
use App\Http\Controllers\Admin\PersonnelController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/admin/personnel/{profile}/stream-document', [SelectionController::class, 'streamDocument'])->name('admin.personnel.stream-document');

// Shared Routes: HR Admin and HR Staff
Route::middleware(['auth', 'role:hr_admin,hr_staff', 'password_must_change'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/onboard', [OnboardController::class, 'index'])->name('admin.onboard');
    Route::post('/onboard', [OnboardController::class, 'store'])->name('admin.onboard.store');
    Route::put('/onboard/{user}', [OnboardController::class, 'update'])->name('admin.onboard.update');
    Route::delete('/onboard/{user}', [OnboardController::class, 'destroy'])->name('admin.onboard.destroy');
    Route::post('/onboard/{user}/resend', [OnboardController::class, 'resendCredentials'])->name('admin.onboard.resend');

    Route::get('/shortlist', [SelectionController::class, 'shortlistIndex'])->name('admin.shortlist');
    Route::post('/shortlist/{userId}', [SelectionController::class, 'shortlistStore'])->name('admin.shortlist.store');

    Route::get('/endorse', [SelectionController::class, 'endorseIndex'])->name('admin.endorse');
    Route::post('/endorse/{userId}', [SelectionController::class, 'endorseStore'])->name('admin.endorse.store');

    Route::get('/manage-personnel', [PersonnelController::class, 'index'])->name('admin.manage-personnel');
    Route::post('/manage-personnel/{userId}/assign', [PersonnelController::class, 'assignDepartment'])->name('admin.manage-personnel.assign');
    Route::post('/manage-personnel/{userId}/toggle', [PersonnelController::class, 'toggleStatus'])->name('admin.manage-personnel.toggle');

    Route::get('/manage-departments', [DepartmentController::class, 'index'])->name('admin.manage-departments');
    Route::post('/manage-departments', [DepartmentController::class, 'store'])->name('admin.departments.store');
});

// Shared Password Reset (No role restriction)
Route::middleware(['auth', 'password_must_change'])->group(function () {
    Route::get('/password/change', [App\Http\Controllers\Auth\PasswordController::class, 'showChangeForm'])->name('password.change');
    Route::post('/password/change', [App\Http\Controllers\Auth\PasswordController::class, 'update'])->name('password.change.post');
});

// Admin Exclusive Routes: HR Admin only
Route::middleware(['auth', 'role:hr_admin', 'password_must_change'])->prefix('admin')->group(function () {
    Route::get('/appointment-letter', [LetterController::class, 'index'])->name('admin.appointment');
    Route::get('/appointment-letter/{userId}', [LetterController::class, 'show'])->name('admin.appointment.show');
    Route::post('/appointment-letter/{userId}/send', [LetterController::class, 'send'])->name('admin.appointment.send');

    Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings');
    Route::post('/settings/update', [SettingsController::class, 'updateCompany'])->name('admin.settings.update');
    Route::post('/settings/staff', [SettingsController::class, 'storeStaff'])->name('admin.staff.store');
    Route::put('/settings/staff/{id}', [SettingsController::class, 'updateStaff'])->name('admin.staff.update');
    Route::delete('/settings/staff/{id}', [SettingsController::class, 'destroyStaff'])->name('admin.staff.destroy');
    Route::post('/settings/staff/{id}/resend', [SettingsController::class, 'resendStaffCredentials'])->name('admin.staff.resend');
});

// Personnel Specific Routes (Self-Service)
Route::middleware(['auth', 'role:personnel', 'password_must_change'])->group(function () {
    // 1. Profile Completion (Must be accessible even if profile is incomplete)
    Route::get('/profile/complete', [App\Http\Controllers\Personnel\ProfileController::class, 'showWizard'])->name('profile.complete');
    Route::post('/profile/complete', [App\Http\Controllers\Personnel\ProfileController::class, 'store'])->name('profile.store');

    // 2. Personnel Dashboard (Single Page - Locked by profile_must_be_complete)
    Route::middleware(['profile_must_be_complete'])->group(function () {
        Route::get('/personnel/dashboard', [App\Http\Controllers\Personnel\DashboardController::class, 'index'])->name('personnel.dashboard');
    });
});
