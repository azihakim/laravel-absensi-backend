<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceSessionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\QrAbsenController;

Route::get('/', function () {
    return view('pages.auth.auth-login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('home', function () {
        // total user
        $total_user = \App\Models\User::count();
        $total_dosen = \App\Models\User::where('role', 'dosen')->count();
        $total_mahasiswa = \App\Models\User::where('role', 'mahasiswa')->count();
        $total_admin = \App\Models\User::where('role', 'admin')->count();
        return view('pages.dashboard', ['type_menu' => 'home'], compact('total_user', 'total_dosen', 'total_mahasiswa', 'total_admin'));
    })->name('home');

    Route::resource('users', UserController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::resource('session', App\Http\Controllers\AttendanceSessionController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('qr_absens', QrAbsenController::class);

    Route::get('/attendance/recap', [AttendanceController::class, 'recapForm'])->name('attendance.recap.form');
    Route::post('/attendance/recap', [AttendanceController::class, 'recap'])->name('attendance.recap');

    Route::get('/qr-absens/{id}/download', [QrAbsenController::class, 'downloadPDF'])->name('qr_absens.download');
});
