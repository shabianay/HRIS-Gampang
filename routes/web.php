<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\LeaveTypeController;
use App\Http\Controllers\Admin\LeaveRequestController as AdminLeaveRequestController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\SalaryComponentController;
use App\Http\Controllers\Admin\PayrollController as AdminPayrollController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Employee\LeaveRequestController as EmployeeLeaveRequestController;
use App\Http\Controllers\Employee\PayrollController as EmployeePayrollController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/employees', EmployeeController::class);

    Route::get('/leave-requests', [AdminLeaveRequestController::class, 'index'])->name('leave-requests.index');
    Route::get('/leave-requests/{leaveRequest}', [AdminLeaveRequestController::class, 'show'])->name('leave-requests.show');
    Route::patch('/leave-requests/{leaveRequest}/approve', [AdminLeaveRequestController::class, 'approve'])->name('leave-requests.approve');
    Route::patch('/leave-requests/{leaveRequest}/reject', [AdminLeaveRequestController::class, 'reject'])->name('leave-requests.reject');

    Route::resource('/leave-types', LeaveTypeController::class);

    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::get('/attendances/create', [AttendanceController::class, 'create'])->name('attendances.create');
    Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');
    Route::get('/attendances/export', [AttendanceController::class, 'export'])->name('attendances.export');

    Route::resource('/salary-components', SalaryComponentController::class);

    Route::get('/payrolls', [AdminPayrollController::class, 'index'])->name('payrolls.index');
    Route::get('/payrolls/create', [AdminPayrollController::class, 'create'])->name('payrolls.create');
    Route::post('/payrolls', [AdminPayrollController::class, 'store'])->name('payrolls.store');
    Route::get('/payrolls/{payroll}', [AdminPayrollController::class, 'show'])->name('payrolls.show');
    Route::patch('/payrolls/{payroll}/paid', [AdminPayrollController::class, 'markAsPaid'])->name('payrolls.mark-paid');
    Route::post('/payrolls/bulk-paid', [AdminPayrollController::class, 'bulkMarkAsPaid'])->name('payrolls.bulk-paid');

    Route::get('/settings/departments', [SettingController::class, 'departments'])->name('settings.departments');
    Route::post('/settings/departments', [SettingController::class, 'storeDepartment'])->name('settings.departments.store');
    Route::put('/settings/departments/{department}', [SettingController::class, 'updateDepartment'])->name('settings.departments.update');
    Route::delete('/settings/departments/{department}', [SettingController::class, 'destroyDepartment'])->name('settings.departments.destroy');

    Route::get('/settings/positions', [SettingController::class, 'positions'])->name('settings.positions');
    Route::post('/settings/positions', [SettingController::class, 'storePosition'])->name('settings.positions.store');
    Route::put('/settings/positions/{position}', [SettingController::class, 'updatePosition'])->name('settings.positions.update');
    Route::delete('/settings/positions/{position}', [SettingController::class, 'destroyPosition'])->name('settings.positions.destroy');

    // Employee (pegawai) routes
    Route::prefix('pegawai')->name('employee.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Employee\DashboardController::class, 'index'])->name('dashboard');

        Route::get('/leave-requests', [EmployeeLeaveRequestController::class, 'index'])->name('leave-requests.index');
        Route::get('/leave-requests/create', [EmployeeLeaveRequestController::class, 'create'])->name('leave-requests.create');
        Route::post('/leave-requests', [EmployeeLeaveRequestController::class, 'store'])->name('leave-requests.store');
        Route::get('/leave-requests/{leaveRequest}', [EmployeeLeaveRequestController::class, 'show'])->name('leave-requests.show');

        Route::get('/payrolls', [EmployeePayrollController::class, 'index'])->name('payrolls.index');
        Route::get('/payrolls/{payroll}', [EmployeePayrollController::class, 'show'])->name('payrolls.show');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
