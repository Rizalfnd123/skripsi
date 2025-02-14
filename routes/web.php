<?php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YourController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\RoadmapController;
use App\Http\Controllers\TingkatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PenelitianController;
use App\Http\Controllers\PengabdianController;
use App\Http\Controllers\Auth\CustomRegisteredUserController;
use App\Http\Controllers\RequestController;

Route::middleware(['auth:mitra'])->group(function () {
    Route::get('/request', [RequestController::class, 'index'])->name('request.index');
});


Route::post('/request/store', [RequestController::class, 'store'])->name('request.store');



Route::get('/list-penelitian', [PenelitianController::class, 'menumitra']);
Route::get('/list-pengabdian', [PengabdianController::class, 'menumitra']);

Route::get('/daftar-penelitian', [PenelitianController::class, 'list'])->name('penelitian.landing');
Route::get('/daftar-pengabdian', [PengabdianController::class, 'list'])->name('pengabdian.landing');


Route::resource('pengabdian', PengabdianController::class);


Route::post('penelitian/{penelitianId}/luaran', [PenelitianController::class, 'storeLuaran'])->name('penelitian.luaran.store');



Route::resource('penelitian', PenelitianController::class);


Route::resource('mitra', MitraController::class);


Route::resource('tingkat', TingkatController::class);


Route::resource('berita', BeritaController::class);


Route::resource('mahasiswa', MahasiswaController::class);
Route::get('/admin/data-mahasiswa/index', [MahasiswaController::class, 'index'])->name('mahasiswa.index');


Route::resource('dosen', DosenController::class);
Route::get('/admin/data-dosen/index', [DosenController::class, 'index'])->name('dosen.index');


Route::resource('roadmap', RoadmapController::class);


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

Route::get('/mitra/dashboard', function () {
    return view('mitra.landing');
})->middleware('auth:mitra');

// Route::get('/', function () {
//     return view('landing-page');
// });

Route::get('/', [YourController::class, 'index'])->name('landing');
