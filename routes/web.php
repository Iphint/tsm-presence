<?php

use App\Http\Controllers\DahsboardMasterController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardMagangController;
use App\Http\Controllers\DashboardPegawaiController;
use App\Http\Controllers\GajiAdminController;
use App\Http\Controllers\GajiMasterController;
use App\Http\Controllers\GajiPegawaiController;
use App\Http\Controllers\JabatanMasterController;
use App\Http\Controllers\LemburanAdminController;
use App\Http\Controllers\LemburanPegawaiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OutletMasterController;
use App\Http\Controllers\PengajuanPegawaiController;
use App\Http\Controllers\PresenceAdminController;
use App\Http\Controllers\PresenceMasterController;
use App\Http\Controllers\PresencePegawaiController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\UserMasterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// Authentication Routes
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::resource('register', RegisterController::class)->only(['index', 'store']);
Route::post('/logout', function () {
    Auth::logout();
    return view('auth.login');
})->name('logout');

Route::get('/unauthorized', function () {
    return response()->view('errors.unauthorized', [], 403);
})->name('unauthorized');

// Master Admin Routes (Only for Master role)
Route::middleware(['auth', 'role:master_admin'])->group(function () {
    Route::resource('dashboard', DahsboardMasterController::class);
    Route::resource('user', UserMasterController::class);
    Route::resource('outlet', OutletMasterController::class);
    Route::resource('jabatan', JabatanMasterController::class);
    Route::resource('presence', PresenceMasterController::class);
    Route::resource('salary', GajiMasterController::class);
    Route::post('/presence/verify', [PresenceMasterController::class, 'verifyPresence'])->name('presence.verify');
});

// Magang Routes (Only for Magang role)
Route::middleware(['auth', 'role:magang'])->group(function () {
    Route::resource('dashboard-magang', DashboardMagangController::class);
});

// Admin Routes (Only for Admin role)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('dashboard-admin', DashboardAdminController::class);
    Route::resource('user-admin', UserAdminController::class);
    Route::resource('presence-admin', PresenceAdminController::class);
    Route::resource('gaji-admin', GajiAdminController::class);
    Route::resource('lembur-admin', LemburanAdminController::class);
});

// Pegawai Routes (Only for Pegawai role)
Route::middleware(['auth', 'role:pegawai'])->group(function () {
    Route::resource('dashboard-pegawai', DashboardPegawaiController::class);
    Route::resource('presence-pegawai', PresencePegawaiController::class);
    Route::resource('gaji-pegawai', GajiPegawaiController::class);
    Route::resource('lembur-pegawai', LemburanPegawaiController::class);
    Route::resource('pengajuan-pegawai', PengajuanPegawaiController::class);
});

Route::middleware(['auth'])->group(function () {
    // Arrival specific routes
    Route::get('/presence-pegawai/create', [PresencePegawaiController::class, 'create'])->name('presence.create');
    Route::post('/presence-pegawai/mark-arrival', [PresencePegawaiController::class, 'markArrival'])->name('presence.mark-arrival');
    Route::post('/presence-pegawai/mark-departure', [PresencePegawaiController::class, 'markDeparture'])->name('presence.mark-departure');    
});
Route::get('gaji/print', [GajiPegawaiController::class, 'print'])->name('gaji.print');