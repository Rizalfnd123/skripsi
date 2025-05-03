<?php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YourController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\RoadmapController;
use App\Http\Controllers\TingkatController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PenelitianController;
use App\Http\Controllers\PengabdianController;
use App\Http\Controllers\RequestAdminController;
use App\Http\Controllers\PenelitianDosenController;
use App\Http\Controllers\PengabdianDosenController;
use App\Http\Controllers\LuaranPenelitianController;
use App\Http\Controllers\LuaranPenelitianDosenController;
use App\Http\Controllers\LuaranPengabdianController;
use App\Http\Controllers\LuaranPengabdianDosenController;
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
    Route::get('/dosen/edit-profile', [ProfileController::class, 'editdosen'])->name('profile.edit.dosen');
    Route::post('/dosen/edit-profile', [ProfileController::class, 'updatedosen'])->name('profile.update.dosen');
    Route::get('/dosen/rekap-penelitian/export-pdf', [RekapController::class, 'exportPDFdosen'])->name('rekap.export-pdf.dosen');
    Route::get('/dosen/rekap-pengabdian/export-pdf', [RekapController::class, 'exportPDF2dosen'])->name('rekap2.export-pdf.dosen');

    Route::prefix('penelitian/luaran/dosen')->group(function () {
        Route::get('/jurnal', [LuaranPenelitianDosenController::class, 'jurnal'])->name('luaran.penelitian.jurnal.dosen');
        Route::get('/jurnal/create', [LuaranPenelitianDosenController::class, 'createJurnal'])->name('luaran.penelitian.jurnal.create.dosen');
        Route::post('/jurnal', [LuaranPenelitianDosenController::class, 'storeJurnal'])->name('luaran.penelitian.jurnal.store.dosen');
        Route::get('/jurnal/{id}/edit', [LuaranPenelitianDosenController::class, 'editJurnal'])->name('luaran.penelitian.jurnal.edit.dosen');
        Route::put('/jurnal/{id}', [LuaranPenelitianDosenController::class, 'updateJurnal'])->name('luaran.penelitian.jurnal.update.dosen');
        Route::delete('/jurnal/{id}', [LuaranPenelitianDosenController::class, 'destroyJurnal'])->name('luaran.penelitian.jurnal.destroy.dosen');

        Route::get('/hki', [LuaranPenelitianDosenController::class, 'hki'])->name('luaran.penelitian.hki.dosen');
        Route::get('/hki/create', [LuaranPenelitianDosenController::class, 'createHki'])->name('luaran.penelitian.hki.create.dosen');
        Route::post('/hki', [LuaranPenelitianDosenController::class, 'storeHki'])->name('luaran.penelitian.hki.store.dosen');
        Route::get('/hki/{id}/edit', [LuaranPenelitianDosenController::class, 'editHki'])->name('luaran.penelitian.hki.edit.dosen');
        Route::put('/hki/{id}', [LuaranPenelitianDosenController::class, 'updateHki'])->name('luaran.penelitian.hki.update.dosen');
        Route::delete('/hki/{id}', [LuaranPenelitianDosenController::class, 'destroyHki'])->name('luaran.penelitian.hki.destroy.dosen');

        Route::get('/prosiding', [LuaranPenelitianDosenController::class, 'prosiding'])->name('luaran.penelitian.prosiding.dosen');
        Route::get('/prosiding/create', [LuaranPenelitianDosenController::class, 'createProsiding'])->name('luaran.penelitian.prosiding.create.dosen');
        Route::post('/prosiding', [LuaranPenelitianDosenController::class, 'storeProsiding'])->name('luaran.penelitian.prosiding.store.dosen');
        Route::get('/prosiding/{id}/edit', [LuaranPenelitianDosenController::class, 'editProsiding'])->name('luaran.penelitian.prosiding.edit.dosen');
        Route::put('/prosiding/{id}', [LuaranPenelitianDosenController::class, 'updateProsiding'])->name('luaran.penelitian.prosiding.update.dosen');
        Route::delete('/prosiding/{id}', [LuaranPenelitianDosenController::class, 'destroyProsiding'])->name('luaran.penelitian.prosiding.destroy.dosen');

        Route::get('/buku', [LuaranPenelitianDosenController::class, 'buku'])->name('luaran.penelitian.buku.dosen');
        Route::get('/buku/create', [LuaranPenelitianDosenController::class, 'createBuku'])->name('luaran.penelitian.buku.create.dosen');
        Route::post('/buku', [LuaranPenelitianDosenController::class, 'storeBuku'])->name('luaran.penelitian.buku.store.dosen');
        Route::get('/buku/{id}/edit', [LuaranPenelitianDosenController::class, 'editBuku'])->name('luaran.penelitian.buku.edit.dosen');
        Route::put('/buku/{id}', [LuaranPenelitianDosenController::class, 'updateBuku'])->name('luaran.penelitian.buku.update.dosen');
        Route::delete('/buku/{id}', [LuaranPenelitianDosenController::class, 'destroyBuku'])->name('luaran.penelitian.buku.destroy.dosen');
    });
    Route::prefix('pengabdian/luaran/dosen')->group(function () {
        Route::get('/jurnal', [LuaranPengabdianDosenController::class, 'jurnal'])->name('luaran.pengabdian.jurnal.dosen');
        Route::get('/jurnal/create', [LuaranPengabdianDosenController::class, 'createJurnal'])->name('luaran.pengabdian.jurnal.create.dosen');
        Route::post('/jurnal', [LuaranPengabdianDosenController::class, 'storeJurnal'])->name('luaran.pengabdian.jurnal.store.dosen');
        Route::get('/jurnal/{id}/edit', [LuaranPengabdianDosenController::class, 'editJurnal'])->name('luaran.pengabdian.jurnal.edit.dosen');
        Route::put('/jurnal/{id}', [LuaranPengabdianDosenController::class, 'updateJurnal'])->name('luaran.pengabdian.jurnal.update.dosen');
        Route::delete('/jurnal/{id}', [LuaranPengabdianDosenController::class, 'destroyJurnal'])->name('luaran.pengabdian.jurnal.destroy.dosen');

        Route::get('/hki', [LuaranPengabdianDosenController::class, 'hki'])->name('luaran.pengabdian.hki.dosen');
        Route::get('/hki/create', [LuaranPengabdianDosenController::class, 'createHki'])->name('luaran.pengabdian.hki.create.dosen');
        Route::post('/hki', [LuaranPengabdianDosenController::class, 'storeHki'])->name('luaran.pengabdian.hki.store.dosen');
        Route::get('/hki/{id}/edit', [LuaranPengabdianDosenController::class, 'editHki'])->name('luaran.pengabdian.hki.edit.dosen');
        Route::put('/hki/{id}', [LuaranPengabdianDosenController::class, 'updateHki'])->name('luaran.pengabdian.hki.update.dosen');
        Route::delete('/hki/{id}', [LuaranPengabdianDosenController::class, 'destroyHki'])->name('luaran.pengabdian.hki.destroy.dosen');

        Route::get('/prosiding', [LuaranPengabdianDosenController::class, 'prosiding'])->name('luaran.pengabdian.prosiding.dosen');
        Route::get('/prosiding/create', [LuaranPengabdianDosenController::class, 'createProsiding'])->name('luaran.pengabdian.prosiding.create.dosen');
        Route::post('/prosiding', [LuaranPengabdianDosenController::class, 'storeProsiding'])->name('luaran.pengabdian.prosiding.store.dosen');
        Route::get('/prosiding/{id}/edit', [LuaranPengabdianDosenController::class, 'editProsiding'])->name('luaran.pengabdian.prosiding.edit.dosen');
        Route::put('/prosiding/{id}', [LuaranPengabdianDosenController::class, 'updateProsiding'])->name('luaran.pengabdian.prosiding.update.dosen');
        Route::delete('/prosiding/{id}', [LuaranPengabdianDosenController::class, 'destroyProsiding'])->name('luaran.pengabdian.prosiding.destroy.dosen');

        Route::get('/buku', [LuaranPengabdianDosenController::class, 'buku'])->name('luaran.pengabdian.buku.dosen');
        Route::get('/buku/create', [LuaranPengabdianDosenController::class, 'createBuku'])->name('luaran.pengabdian.buku.create.dosen');
        Route::post('/buku', [LuaranPengabdianDosenController::class, 'storeBuku'])->name('luaran.pengabdian.buku.store.dosen');
        Route::get('/buku/{id}/edit', [LuaranPengabdianDosenController::class, 'editBuku'])->name('luaran.pengabdian.buku.edit.dosen');
        Route::put('/buku/{id}', [LuaranPengabdianDosenController::class, 'updateBuku'])->name('luaran.pengabdian.buku.update.dosen');
        Route::delete('/buku/{id}', [LuaranPengabdianDosenController::class, 'destroyBuku'])->name('luaran.pengabdian.buku.destroy.dosen');

        Route::get('/video', [LuaranPengabdianDosenController::class, 'video'])->name('luaran.pengabdian.video.dosen');
        Route::get('/video/create', [LuaranPengabdianDosenController::class, 'createVideo'])->name('luaran.pengabdian.video.create.dosen');
        Route::post('/video', [LuaranPengabdianDosenController::class, 'storeVideo'])->name('luaran.pengabdian.video.store.dosen');
        Route::get('/video/{id}/edit', [LuaranPengabdianDosenController::class, 'editVideo'])->name('luaran.pengabdian.video.edit.dosen');
        Route::put('/video/{id}', [LuaranPengabdianDosenController::class, 'updateVideo'])->name('luaran.pengabdian.video.update.dosen');
        Route::delete('/video/{id}', [LuaranPengabdianDosenController::class, 'destroyVideo'])->name('luaran.pengabdian.video.destroy.dosen');
    });
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
    Route::get('/edit-profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/edit-profile', [ProfileController::class, 'update'])->name('profile.update');

    // PENELITIAN - LUARAN
    Route::prefix('penelitian/luaran')->group(function () {
        Route::get('/jurnal', [LuaranPenelitianController::class, 'jurnal'])->name('luaran.penelitian.jurnal');
        Route::get('/jurnal/create', [LuaranPenelitianController::class, 'createJurnal'])->name('luaran.penelitian.jurnal.create');
        Route::post('/jurnal', [LuaranPenelitianController::class, 'storeJurnal'])->name('luaran.penelitian.jurnal.store');
        Route::get('/jurnal/{id}/edit', [LuaranPenelitianController::class, 'editJurnal'])->name('luaran.penelitian.jurnal.edit');
        Route::put('/jurnal/{id}', [LuaranPenelitianController::class, 'updateJurnal'])->name('luaran.penelitian.jurnal.update');
        Route::delete('/jurnal/{id}', [LuaranPenelitianController::class, 'destroyJurnal'])->name('luaran.penelitian.jurnal.destroy');

        Route::get('/hki', [LuaranPenelitianController::class, 'hki'])->name('luaran.penelitian.hki');
        Route::get('/hki/create', [LuaranPenelitianController::class, 'createHki'])->name('luaran.penelitian.hki.create');
        Route::post('/hki', [LuaranPenelitianController::class, 'storeHki'])->name('luaran.penelitian.hki.store');
        Route::get('/hki/{id}/edit', [LuaranPenelitianController::class, 'editHki'])->name('luaran.penelitian.hki.edit');
        Route::put('/hki/{id}', [LuaranPenelitianController::class, 'updateHki'])->name('luaran.penelitian.hki.update');
        Route::delete('/hki/{id}', [LuaranPenelitianController::class, 'destroyHki'])->name('luaran.penelitian.hki.destroy');

        Route::get('/prosiding', [LuaranPenelitianController::class, 'prosiding'])->name('luaran.penelitian.prosiding');
        Route::get('/prosiding/create', [LuaranPenelitianController::class, 'createProsiding'])->name('luaran.penelitian.prosiding.create');
        Route::post('/prosiding', [LuaranPenelitianController::class, 'storeProsiding'])->name('luaran.penelitian.prosiding.store');
        Route::get('/prosiding/{id}/edit', [LuaranPenelitianController::class, 'editProsiding'])->name('luaran.penelitian.prosiding.edit');
        Route::put('/prosiding/{id}', [LuaranPenelitianController::class, 'updateProsiding'])->name('luaran.penelitian.prosiding.update');
        Route::delete('/prosiding/{id}', [LuaranPenelitianController::class, 'destroyProsiding'])->name('luaran.penelitian.prosiding.destroy');

        Route::get('/buku', [LuaranPenelitianController::class, 'buku'])->name('luaran.penelitian.buku');
        Route::get('/buku/create', [LuaranPenelitianController::class, 'createBuku'])->name('luaran.penelitian.buku.create');
        Route::post('/buku', [LuaranPenelitianController::class, 'storeBuku'])->name('luaran.penelitian.buku.store');
        Route::get('/buku/{id}/edit', [LuaranPenelitianController::class, 'editBuku'])->name('luaran.penelitian.buku.edit');
        Route::put('/buku/{id}', [LuaranPenelitianController::class, 'updateBuku'])->name('luaran.penelitian.buku.update');
        Route::delete('/buku/{id}', [LuaranPenelitianController::class, 'destroyBuku'])->name('luaran.penelitian.buku.destroy');
    });

    // PENGABDIAN - LUARAN
    Route::prefix('pengabdian/luaran')->group(function () {
        Route::get('/jurnal', [LuaranPengabdianController::class, 'jurnal'])->name('luaran.pengabdian.jurnal');
        Route::get('/jurnal/create', [LuaranPengabdianController::class, 'createJurnal'])->name('luaran.pengabdian.jurnal.create');
        Route::post('/jurnal', [LuaranPengabdianController::class, 'storeJurnal'])->name('luaran.pengabdian.jurnal.store');
        Route::get('/jurnal/{id}/edit', [LuaranPengabdianController::class, 'editJurnal'])->name('luaran.pengabdian.jurnal.edit');
        Route::put('/jurnal/{id}', [LuaranPengabdianController::class, 'updateJurnal'])->name('luaran.pengabdian.jurnal.update');
        Route::delete('/jurnal/{id}', [LuaranPengabdianController::class, 'destroyJurnal'])->name('luaran.pengabdian.jurnal.destroy');

        Route::get('/hki', [LuaranPengabdianController::class, 'hki'])->name('luaran.pengabdian.hki');
        Route::get('/hki/create', [LuaranPengabdianController::class, 'createHki'])->name('luaran.pengabdian.hki.create');
        Route::post('/hki', [LuaranPengabdianController::class, 'storeHki'])->name('luaran.pengabdian.hki.store');
        Route::get('/hki/{id}/edit', [LuaranPengabdianController::class, 'editHki'])->name('luaran.pengabdian.hki.edit');
        Route::put('/hki/{id}', [LuaranPengabdianController::class, 'updateHki'])->name('luaran.pengabdian.hki.update');
        Route::delete('/hki/{id}', [LuaranPengabdianController::class, 'destroyHki'])->name('luaran.pengabdian.hki.destroy');

        Route::get('/prosiding', [LuaranPengabdianController::class, 'prosiding'])->name('luaran.pengabdian.prosiding');
        Route::get('/prosiding/create', [LuaranPengabdianController::class, 'createProsiding'])->name('luaran.pengabdian.prosiding.create');
        Route::post('/prosiding', [LuaranPengabdianController::class, 'storeProsiding'])->name('luaran.pengabdian.prosiding.store');
        Route::get('/prosiding/{id}/edit', [LuaranPengabdianController::class, 'editProsiding'])->name('luaran.pengabdian.prosiding.edit');
        Route::put('/prosiding/{id}', [LuaranPengabdianController::class, 'updateProsiding'])->name('luaran.pengabdian.prosiding.update');
        Route::delete('/prosiding/{id}', [LuaranPengabdianController::class, 'destroyProsiding'])->name('luaran.pengabdian.prosiding.destroy');

        Route::get('/buku', [LuaranPengabdianController::class, 'buku'])->name('luaran.pengabdian.buku');
        Route::get('/buku/create', [LuaranPengabdianController::class, 'createBuku'])->name('luaran.pengabdian.buku.create');
        Route::post('/buku', [LuaranPengabdianController::class, 'storeBuku'])->name('luaran.pengabdian.buku.store');
        Route::get('/buku/{id}/edit', [LuaranPengabdianController::class, 'editBuku'])->name('luaran.pengabdian.buku.edit');
        Route::put('/buku/{id}', [LuaranPengabdianController::class, 'updateBuku'])->name('luaran.pengabdian.buku.update');
        Route::delete('/buku/{id}', [LuaranPengabdianController::class, 'destroyBuku'])->name('luaran.pengabdian.buku.destroy');

        Route::get('/video', [LuaranPengabdianController::class, 'video'])->name('luaran.pengabdian.video');
        Route::get('/video/create', [LuaranPengabdianController::class, 'createVideo'])->name('luaran.pengabdian.video.create');
        Route::post('/video', [LuaranPengabdianController::class, 'storeVideo'])->name('luaran.pengabdian.video.store');
        Route::get('/video/{id}/edit', [LuaranPengabdianController::class, 'editVideo'])->name('luaran.pengabdian.video.edit');
        Route::put('/video/{id}', [LuaranPengabdianController::class, 'updateVideo'])->name('luaran.pengabdian.video.update');
        Route::delete('/video/{id}', [LuaranPengabdianController::class, 'destroyVideo'])->name('luaran.pengabdian.video.destroy');
    });
});
