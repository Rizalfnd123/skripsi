<?php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\CustomRegisteredUserController;

Route::get('/register', [CustomRegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [CustomRegisteredUserController::class, 'store']);

Route::post('/login', [LoginController::class, 'login'])->name('login');

// Halaman Dashboard (hanya bisa diakses oleh user yang sudah login)
// Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/dosen', function () {
    return view('dosen.dashboard');
})->middleware('role:dosen');

Route::get('/mahasiswa', function () {
    return view('mahasiswa.dashboard');
})->middleware('role:mahasiswa');

Route::get('/umum', function () {
    return view('umum.dashboard');
})->middleware('role:umum');

Route::get('/', function () {
    return view('auth.login');
});
