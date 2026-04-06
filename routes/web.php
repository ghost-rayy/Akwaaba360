<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\OnboardController;
use App\Http\Controllers\Admin\SelectionController;
use App\Http\Controllers\Admin\LetterController;
use App\Http\Controllers\Admin\PersonnelController;
use App\Http\Controllers\Admin\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:hr_admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::get('/onboard', [OnboardController::class, 'index'])->name('admin.onboard');
        Route::post('/onboard', [OnboardController::class, 'store'])->name('admin.onboard.store');

        Route::get('/shortlist', [SelectionController::class, 'shortlistIndex'])->name('admin.shortlist');
        Route::post('/shortlist/{userId}', [SelectionController::class, 'shortlistStore'])->name('admin.shortlist.store');

        Route::get('/endorse', [SelectionController::class, 'endorseIndex'])->name('admin.endorse');
        Route::post('/endorse/{userId}', [SelectionController::class, 'endorseStore'])->name('admin.endorse.store');

        Route::get('/appointment-letter', [LetterController::class, 'index'])->name('admin.appointment');
        Route::get('/appointment-letter/{userId}/generate', [LetterController::class, 'show'])->name('admin.appointment.show');

        Route::get('/manage-personnel', [PersonnelController::class, 'index'])->name('admin.manage-personnel');
        Route::post('/manage-personnel/{userId}/assign', [PersonnelController::class, 'assignDepartment'])->name('admin.manage-personnel.assign');
        Route::post('/manage-personnel/{userId}/toggle', [PersonnelController::class, 'toggleStatus'])->name('admin.manage-personnel.toggle');

        Route::get('/manage-departments', [DepartmentController::class, 'index'])->name('admin.manage-departments');
        Route::post('/manage-departments', [DepartmentController::class, 'store'])->name('admin.departments.store');
    });

    Route::get('/password/change', function () {
        return view('auth.passwords.change');
    })->name('password.change');
});
