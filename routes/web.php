<?php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YourController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\RoadmapController;
use App\Http\Controllers\TingkatController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PenelitianController;
use App\Http\Controllers\PengabdianController;
use App\Http\Controllers\RequestAdminController;
use App\Http\Controllers\PenelitianDosenController;
use App\Http\Controllers\PengabdianDosenController;
use App\Http\Controllers\Auth\CustomRegisteredUserController;


Route::get('/', [YourController::class, 'index'])->name('landing');
Route::get('/register', [CustomRegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [CustomRegisteredUserController::class, 'store']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/daftar-penelitian', [PenelitianController::class, 'list'])->name('penelitian.landing');
Route::get('/daftar-pengabdian', [PengabdianController::class, 'list'])->name('pengabdian.landing');


Route::middleware(['auth:dosen'])->group(function () {
    Route::get('/dosen/dashboard',  [DosenController::class, 'show'])->name('dosen.dashboard');
    Route::resource('penelitian-dosen', PenelitianDosenController::class);
    Route::resource('pengabdian-dosen', PengabdianDosenController::class);
    Route::post('penelitian-dosen/{penelitianId}/luaran', [PenelitianController::class, 'storeLuaran'])->name('penelitian-dosen.luaran.store');
    Route::get('/dosen/request', [RequestAdminController::class, 'index2'])->name('requestdosen.index');
    Route::post('/ubah-status/{id}', [RequestAdminController::class, 'updateStatus']);
});


Route::middleware(['auth:mitra'])->group(function () {
    Route::get('/mitra/dashboard', [MitraController::class, 'dashboard'])->name('mitra.dashboard');
    Route::get('/request', [RequestController::class, 'index'])->name('request.index');
    Route::post('/request/store', [RequestController::class, 'store'])->name('request.store');
    Route::get('/list-penelitian', [PenelitianController::class, 'menumitra']);
    Route::get('/list-pengabdian', [PengabdianController::class, 'menumitra']);
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [YourController::class, 'adminhome'])->name('admin.dashboard');
    Route::resource('pengabdian', PengabdianController::class);
    Route::post('penelitian/{penelitianId}/luaran', [PenelitianController::class, 'storeLuaran'])->name('penelitian.luaran.store');
    Route::resource('penelitian', PenelitianController::class);
    Route::resource('mitra', MitraController::class);
    Route::resource('tingkat', TingkatController::class);
    Route::resource('berita', BeritaController::class);
    Route::resource('semester', SemesterController::class);
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::get('/admin/data-mahasiswa/index', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::resource('dosen', DosenController::class);
    Route::get('/admin/data-dosen/index', [DosenController::class, 'index'])->name('dosen.index');
    Route::resource('roadmap', RoadmapController::class);
    Route::get('/admin/rekap', [RekapController::class, 'index'])->name('rekapadmin.index');
    Route::get('/rekap-penelitian/export-pdf', [RekapController::class, 'exportPDF'])->name('rekap.export-pdf');
    Route::get('/rekap-pengabdian/export-pdf', [RekapController::class, 'exportPDF2'])->name('rekap2.export-pdf');
    Route::get('/admin/request', [RequestAdminController::class, 'index'])->name('requestadmin.index');
    Route::post('/update-status/{id}', [RequestAdminController::class, 'updateStatus']);
});
