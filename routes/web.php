<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\PersonelController;
use App\Http\Controllers\Admin\ClientController;
use App\Models\Attendance;
use App\Models\Personel;
use App\Models\Broadcast;
use Carbon\Carbon;

// ==========================================
// RUTE UTAMA (ROOT REDIRECT)
// ==========================================
Route::get('/', function () {
    return redirect()->route('login');
});

// ==========================================
// RUTE AUTENTIKASI
// ==========================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// RUTE ADMIN
// ==========================================
// Jika nanti butuh proteksi, disarankan dibungkus Route::middleware(['auth', 'role:admin'])->group(function () { ... });
Route::get('/admin/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
Route::post('/admin/broadcast', [\App\Http\Controllers\Admin\DashboardController::class, 'storeBroadcast'])->name('admin.broadcast.store');
Route::get('/admin/export-excel', [\App\Http\Controllers\Admin\DashboardController::class, 'exportExcel'])->name('admin.dashboard.excel');
Route::get('/admin/cetak-pdf', [\App\Http\Controllers\Admin\DashboardController::class, 'exportPdf'])->name('admin.dashboard.pdf');

// Manajemen Personel
Route::get('/admin/personel', [PersonelController::class, 'index'])->name('admin.personel.index');
Route::get('/admin/personel/tambah', [PersonelController::class, 'create'])->name('admin.personel.create');
Route::post('/admin/personel', [PersonelController::class, 'store'])->name('admin.personel.store');
Route::get('/admin/personel/{id}/edit', [PersonelController::class, 'edit'])->name('admin.personel.edit');
Route::put('/admin/personel/{id}', [PersonelController::class, 'update'])->name('admin.personel.update');
Route::delete('/admin/personel/{id}', [PersonelController::class, 'destroy'])->name('admin.personel.destroy');

// Manajemen Klien & Lokasi Penjagaan
Route::get('/admin/client', [ClientController::class, 'index'])->name('admin.client.index');
Route::get('/admin/client/tambah', [ClientController::class, 'create'])->name('admin.client.create');
Route::post('/admin/client', [ClientController::class, 'store'])->name('admin.client.store');
Route::get('/admin/client/{id}', [ClientController::class, 'show'])->name('admin.client.show');
Route::post('/admin/client/{id}/assign', [ClientController::class, 'assignPersonel'])->name('admin.client.assign');
Route::post('/admin/client/{id}/remove/{personel_id}', [ClientController::class, 'removePersonel'])->name('admin.client.remove_personel');

// Manajemen Laporan Lapangan & Absensi
Route::get('/admin/laporan', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.report.index');
Route::get('/admin/absensi', [\App\Http\Controllers\Admin\AttendanceController::class, 'index'])->name('admin.attendance.index');

// ==========================================
// RUTE SUPERVISOR (PEMANTAUAN)
// ==========================================
Route::middleware(['auth', 'role:supervisor'])->group(function () {
    
    // Dashboard Komando
    Route::get('/supervisor/dashboard', [\App\Http\Controllers\Supervisor\DashboardController::class, 'index'])->name('supervisor.dashboard');
    
    // Manajemen Laporan & Tindak Lanjut
    Route::get('/supervisor/laporan', [\App\Http\Controllers\Supervisor\DashboardController::class, 'reports'])->name('supervisor.report.index');
    Route::post('/supervisor/laporan/{id}/respond', [\App\Http\Controllers\Supervisor\DashboardController::class, 'respondReport'])->name('supervisor.report.respond');
    
    // Validasi Kehadiran
    Route::get('/supervisor/absensi', [\App\Http\Controllers\Supervisor\DashboardController::class, 'attendance'])->name('supervisor.attendance.index');

});

// ==========================================
// RUTE PERSONEL (SECURITY)
// ==========================================
Route::middleware(['auth', 'role:personel'])->group(function () {
    
    // Dashboard Personel
    Route::get('/personel/dashboard', function () {
        $personel = Personel::with('client')->where('user_id', Auth::id())->first();
        $absensi = null;
        
        if ($personel) {
            $absensi = Attendance::where('personel_id', $personel->id)
                                 ->where('tanggal', Carbon::today()->toDateString())
                                 ->first();
        }
        
        $activeBroadcast = Broadcast::where('status', 'aktif')->latest()->first();
        
        return view('personel.dashboard', compact('absensi', 'personel', 'activeBroadcast')); 
    })->name('personel.dashboard');
    
    // Fitur Absensi
    Route::post('/personel/absen', [\App\Http\Controllers\Personel\AttendanceController::class, 'store'])->name('personel.absen');
    
    // ---> RUTE BARU: Riwayat Aktivitas (Kehadiran & Laporan) <---
    Route::get('/personel/riwayat', [\App\Http\Controllers\Personel\ReportController::class, 'history'])->name('personel.history');
    Route::get('/personel/profil', [\App\Http\Controllers\Personel\ReportController::class, 'profile'])->name('personel.profile');
    
    // Manajemen Laporan Patroli
    Route::get('/personel/riwayat-laporan', [\App\Http\Controllers\Personel\ReportController::class, 'index'])->name('personel.report.index');
    Route::get('/personel/laporan', [\App\Http\Controllers\Personel\ReportController::class, 'create'])->name('personel.report.create');
    Route::post('/personel/laporan', [\App\Http\Controllers\Personel\ReportController::class, 'store'])->name('personel.report.store');
});

// ==========================================
// RUTE KLIEN
// ==========================================
Route::middleware(['auth', 'role:klien'])->group(function () {
    Route::get('/klien/dashboard', [\App\Http\Controllers\Klien\DashboardController::class, 'index'])->name('klien.dashboard');
    Route::get('/klien/tim-penjaga', [\App\Http\Controllers\Klien\DashboardController::class, 'team'])->name('klien.team');
    Route::get('/klien/log-absensi', [\App\Http\Controllers\Klien\DashboardController::class, 'attendance'])->name('klien.attendance');
    Route::get('/klien/laporan-lapangan', [\App\Http\Controllers\Klien\DashboardController::class, 'report'])->name('klien.report');
});