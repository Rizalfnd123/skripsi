<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Luaran;
use App\Models\Pengabdian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LuaranPengabdianDosenController extends Controller
{
    public function jurnal()
    {
        $dosenLogin = Auth::guard('dosen')->user();
        $tahun = request('tahun');

        // Ambil hanya pengabdian yang terkait dengan dosen login
        $pengabdianIds = Pengabdian::where('ketua', $dosenLogin->id)
            ->orWhereHas('anggotaPengabdian', function ($query) use ($dosenLogin) {
                $query->where('anggota_id', $dosenLogin->id)
                    ->where('anggota_type', 'Dosen');
            })
            ->pluck('id');

        $luaranQuery = Luaran::with('luarable')
            ->where('luarable_type', 'App\Models\Pengabdian')
            ->where('tipe', 'jurnal')
            ->whereIn('luarable_id', $pengabdianIds)
            ->when($tahun, fn($q) => $q->where('tahun', $tahun));

        $luarans = $luaranQuery->get();

        $tahunList = Luaran::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Filter luaran berdasarkan roadmap
        $luaranRoadmap1 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 1);
        $luaranRoadmap2 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 2);
        $luaranRoadmap3 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 3);
        $roadmapStats = [
            'Pembelajaran Domain TIK' => $luaranRoadmap1->count(),
            'Pembelajaran Berbantuan TIK' => $luaranRoadmap2->count(),
            'Informatika Terapan' => $luaranRoadmap3->count(),
        ];

        return view('dosen.pengabdian.luaranJurnal.jurnal', compact('luaranRoadmap1', 'luaranRoadmap2', 'luaranRoadmap3', 'tahunList', 'roadmapStats'));
    }

    public function createJurnal()
    {
        $dosenLogin = Auth::guard('dosen')->user();

        $pengabdians = Pengabdian::where('ketua', $dosenLogin->id)
            ->orWhereHas('anggotaPengabdian', function ($query) use ($dosenLogin) {
                $query->where('anggota_id', $dosenLogin->id)
                    ->where('anggota_type', 'Dosen');
            })
            ->select('id', 'judul', 'id_roadmap')
            ->get();

        return view('dosen.pengabdian.luaranJurnal.create', compact('pengabdians'));
    }

    // Fungsi untuk menyimpan jurnal
    public function storeJurnal(Request $request)
    {
        // Validasi input
        $request->validate([
            'pengabdian_id' => 'required|exists:pengabdian,id', // Validasi ID pengabdian
            'judul' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'sinta' => 'nullable',
            'link' => 'nullable|url',
        ]);

        // Menyimpan data jurnal ke dalam database
        Luaran::create([
            'judul' => $request->judul,
            'tahun' => $request->tahun,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'sinta' => $request->sinta,
            'link' => $request->link,
            'tipe' => 'jurnal',
            'luarable_id' => $request->pengabdian_id, // Menyimpan ID pengabdian yang dipilih
            'luarable_type' => 'App\Models\Pengabdian', // Menyimpan tipe 'pengabdian'
        ]);

        // Redirect setelah berhasil
        return redirect()->route('luaran.pengabdian.jurnal.dosen')->with('success', 'Jurnal berhasil ditambahkan.');
    }

    public function editJurnal($id)
    {
        $dosenLogin = Auth::guard('dosen')->user();

        $pengabdians = Pengabdian::where('ketua', $dosenLogin->id)
            ->orWhereHas('anggotaPengabdian', function ($query) use ($dosenLogin) {
                $query->where('anggota_id', $dosenLogin->id)
                    ->where('anggota_type', 'Dosen');
            })
            ->get();

        $luaran = Luaran::findOrFail($id);

        return view('dosen.pengabdian.luaranJurnal.edit', compact('luaran', 'pengabdians'));
    }

    public function updateJurnal(Request $request, $id)
    {
        // $request->validate([
        //     'pengabdian_id' => 'required|exists:pengabdian,id',
        //     'judul' => 'required|string|max:255',
        //     'tahun' => 'required|integer',
        //     'sinta' => 'nullable|string|max:100',
        //     'link' => 'nullable|url',
        // ]);

        $luaran = Luaran::findOrFail($id);
        $luaran->update([
            'pengabdian_id' => $request->pengabdian_id,
            'judul' => $request->judul,
            'tahun' => $request->tahun,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'sinta' => $request->sinta,
            'link' => $request->link,
        ]);

        return redirect()->route('luaran.pengabdian.jurnal.dosen')->with('success', 'Luaran berhasil diperbarui.');
    }

    public function destroyJurnal($id)
    {
        $luaran = Luaran::findOrFail($id);
        $luaran->delete();

        return redirect()->back()->with('success', 'Luaran berhasil dihapus.');
    }

    public function hki()
    {
        $dosenLogin = Auth::guard('dosen')->user();
        $tahun = request('tahun');

        // Ambil hanya pengabdian yang terkait dengan dosen login
        $pengabdianIds = Pengabdian::where('ketua', $dosenLogin->id)
            ->orWhereHas('anggotaPengabdian', function ($query) use ($dosenLogin) {
                $query->where('anggota_id', $dosenLogin->id)
                    ->where('anggota_type', 'Dosen');
            })
            ->pluck('id');

        $luaranQuery = Luaran::with('luarable')
            ->where('luarable_type', 'App\Models\Pengabdian')
            ->where('tipe', 'HKI')
            ->whereIn('luarable_id', $pengabdianIds)
            ->when($tahun, fn($q) => $q->where('tahun', $tahun));

        $luarans = $luaranQuery->get();

        $tahunList = Luaran::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Filter luaran berdasarkan roadmap
        $luaranRoadmap1 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 1);
        $luaranRoadmap2 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 2);
        $luaranRoadmap3 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 3);

        $statistikRoadmap = [
            'Pembelajaran Domain TIK' => $luaranRoadmap1->count(),
            'Pembelajaran Berbantuan TIK' => $luaranRoadmap2->count(),
            'Informatika Terapan' => $luaranRoadmap3->count(),
        ];

        return view('dosen.pengabdian.luaranHki.index', compact(
            'luaranRoadmap1',
            'luaranRoadmap2',
            'luaranRoadmap3',
            'tahunList',
            'statistikRoadmap'
        ));
    }

    public function createHki()
    {
        $dosenLogin = Auth::guard('dosen')->user();

        $pengabdians = Pengabdian::where('ketua', $dosenLogin->id)
            ->orWhereHas('anggotaPengabdian', function ($query) use ($dosenLogin) {
                $query->where('anggota_id', $dosenLogin->id)
                    ->where('anggota_type', 'Dosen');
            })
            ->select('id', 'judul', 'id_roadmap')
            ->get();

        return view('dosen.pengabdian.luaranHki.create', compact('pengabdians'));
    }

    // Fungsi untuk menyimpan jurnal
    public function storeHki(Request $request)
    {
        // Validasi input
        // $request->validate([
        //     'pengabdian_id' => 'required|exists:pengabdian,id', // Validasi ID pengabdian
        //     'judul' => 'required|string|max:255',
        //     'tahun' => 'required|integer',
        //     'sinta' => 'nullable|string|max:10',
        //     'link' => 'nullable|url',
        // ]);

        // Menyimpan data jurnal ke dalam database
        Luaran::create([
            'nama_karya' => $request->nama_karya,
            'jenis' => $request->jenis,
            'pencipta' => $request->pencipta,
            'pemegang_hak_cipta' => $request->pemegang_hak_cipta,
            'nomor_pengajuan' => $request->nomor_pengajuan,
            'tanggal_diterima' => $request->tanggal_diterima,
            'link' => $request->link,
            'tipe' => 'HKI',
            'luarable_id' => $request->pengabdian_id, // Menyimpan ID pengabdian yang dipilih
            'luarable_type' => 'App\Models\Pengabdian', // Menyimpan tipe 'pengabdian'
        ]);

        // Redirect setelah berhasil
        return redirect()->route('luaran.pengabdian.hki.dosen')->with('success', 'Jurnal berhasil ditambahkan.');
    }

    public function editHki($id)
    {
        $dosenLogin = Auth::guard('dosen')->user();

        $pengabdians = Pengabdian::where('ketua', $dosenLogin->id)
            ->orWhereHas('anggotaPengabdian', function ($query) use ($dosenLogin) {
                $query->where('anggota_id', $dosenLogin->id)
                    ->where('anggota_type', 'Dosen');
            })
            ->get();

        $luaran = Luaran::findOrFail($id);

        return view('dosen.pengabdian.luaranHki.edit', compact('luaran', 'pengabdians'));
    }

    public function updateHki(Request $request, $id)
    {
        // $request->validate([
        //     'pengabdian_id' => 'required|exists:pengabdian,id',
        //     'judul' => 'required|string|max:255',
        //     'tahun' => 'required|integer',
        //     'sinta' => 'nullable|string|max:100',
        //     'link' => 'nullable|url',
        // ]);

        $luaran = Luaran::findOrFail($id);
        $luaran->update([
            'pengabdian_id' => $request->pengabdian_id,
            'nama_karya' => $request->nama_karya,
            'jenis' => $request->jenis,
            'pencipta' => $request->pencipta,
            'pemegang_hak_cipta' => $request->pemegang_hak_cipta,
            'nomor_pengajuan' => $request->nomor_pengajuan,
            'tanggal_diterima' => $request->tanggal_diterima,
            'link' => $request->link,
        ]);

        return redirect()->route('luaran.pengabdian.hki.dosen')->with('success', 'Luaran berhasil diperbarui.');
    }

    public function destroyHki($id)
    {
        $luaran = Luaran::findOrFail($id);
        $luaran->delete();

        return redirect()->back()->with('success', 'Luaran berhasil dihapus.');
    }


    public function prosiding()
    {
        $dosenLogin = Auth::guard('dosen')->user();
        $tahun = request('tahun');

        // Ambil ID pengabdian yang melibatkan dosen login (sebagai ketua atau anggota)
        $pengabdianIds = Pengabdian::where('ketua', $dosenLogin->id)
            ->orWhereHas('anggotaPengabdian', function ($query) use ($dosenLogin) {
                $query->where('anggota_id', $dosenLogin->id)
                    ->where('anggota_type', 'Dosen');
            })
            ->pluck('id');

        // Ambil luaran dengan tipe prosiding dan luarable pengabdian sesuai dosen login
        $luaranQuery = Luaran::with('luarable')
            ->where('luarable_type', 'App\Models\Pengabdian')
            ->where('tipe', 'prosiding')
            ->whereIn('luarable_id', $pengabdianIds)
            ->when($tahun, fn($q) => $q->where('tahun', $tahun));

        $luarans = $luaranQuery->get();

        // Ambil daftar tahun unik
        $tahunList = Luaran::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Filter berdasarkan id_roadmap
        $luaranRoadmap1 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 1);
        $luaranRoadmap2 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 2);
        $luaranRoadmap3 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 3);

        $statistikRoadmap = [
            'Pembelajaran Domain TIK' => $luaranRoadmap1->count(),
            'Pembelajaran Berbantuan TIK' => $luaranRoadmap2->count(),
            'Informatika Terapan' => $luaranRoadmap3->count(),
        ];

        return view('dosen.pengabdian.luaranProsiding.index', compact(
            'luaranRoadmap1',
            'luaranRoadmap2',
            'luaranRoadmap3',
            'tahunList',
            'statistikRoadmap'
        ));
    }

    public function createProsiding()
    {
        $dosenLogin = Auth::guard('dosen')->user();

        $pengabdians = Pengabdian::where('ketua', $dosenLogin->id)
            ->orWhereHas('anggotaPengabdian', function ($query) use ($dosenLogin) {
                $query->where('anggota_id', $dosenLogin->id)
                    ->where('anggota_type', 'Dosen');
            })
            ->select('id', 'judul', 'id_roadmap')
            ->get();

        return view('dosen.pengabdian.luaranProsiding.create', compact('pengabdians'));
    }

    // Fungsi untuk menyimpan jurnal
    public function storeProsiding(Request $request)
    {
        // Validasi input
        // $request->validate([
        //     'pengabdian_id' => 'required|exists:pengabdian,id', // Validasi ID pengabdian
        //     'judul' => 'required|string|max:255',
        //     'tahun' => 'required|integer',
        //     'sinta' => 'nullable|string|max:10',
        //     'link' => 'nullable|url',
        // ]);

        // Menyimpan data jurnal ke dalam database
        Luaran::create([
            'judul' => $request->judul,
            'tahun' => $request->tahun,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'sinta' => $request->sinta,
            'link' => $request->link,
            'penyelenggara' => $request->penyelenggara,
            'nama_konferensi' => $request->nama_konferensi,
            'tempat_konferensi' => $request->tempat_konferensi,
            'tgl_konferensi' => $request->tgl_konferensi,
            'tipe' => 'prosiding',
            'luarable_id' => $request->pengabdian_id, // Menyimpan ID pengabdian yang dipilih
            'luarable_type' => 'App\Models\Pengabdian', // Menyimpan tipe 'pengabdian'
        ]);

        // Redirect setelah berhasil
        return redirect()->route('luaran.pengabdian.prosiding.dosen')->with('success', 'Prosiding berhasil ditambahkan.');
    }

    public function editProsiding($id)
    {
        $dosenLogin = Auth::guard('dosen')->user();

        // Mengambil semua pengabdian yang terkait dengan dosen yang login (sebagai ketua atau anggota)
        $pengabdians = Pengabdian::where('ketua', $dosenLogin->id)
            ->orWhereHas('anggotaPengabdian', function ($query) use ($dosenLogin) {
                $query->where('anggota_id', $dosenLogin->id)
                    ->where('anggota_type', 'Dosen');
            })
            ->get();

        $luaran = Luaran::findOrFail($id);

        return view('dosen.pengabdian.luaranProsiding.edit', compact('luaran', 'pengabdians'));
    }

    public function updateProsiding(Request $request, $id)
    {
        // $request->validate([
        //     'pengabdian_id' => 'required|exists:pengabdian,id',
        //     'judul' => 'required|string|max:255',
        //     'tahun' => 'required|integer',
        //     'sinta' => 'nullable|string|max:100',
        //     'link' => 'nullable|url',
        // ]);

        $luaran = Luaran::findOrFail($id);
        $luaran->update([
            'pengabdian_id' => $request->pengabdian_id,
            'judul' => $request->judul,
            'tahun' => $request->tahun,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'sinta' => $request->sinta,
            'link' => $request->link,
            'penyelenggara' => $request->penyelenggara,
            'nama_konferensi' => $request->nama_konferensi,
            'tempat_konferensi' => $request->tempat_konferensi,
            'tgl_konferensi' => $request->tgl_konferensi,
        ]);

        return redirect()->route('luaran.pengabdian.prosiding.dosen')->with('success', 'Luaran berhasil diperbarui.');
    }

    public function destroyProsiding($id)
    {
        $luaran = Luaran::findOrFail($id);
        $luaran->delete();

        return redirect()->back()->with('success', 'Luaran berhasil dihapus.');
    }


    public function buku()
    {
        $dosenLogin = Auth::guard('dosen')->user();
        $tahun = request('tahun');

        // Ambil ID pengabdian yang melibatkan dosen login
        $pengabdianIds = Pengabdian::where('ketua', $dosenLogin->id)
            ->orWhereHas('anggotaPengabdian', function ($query) use ($dosenLogin) {
                $query->where('anggota_id', $dosenLogin->id)
                    ->where('anggota_type', 'Dosen');
            })
            ->pluck('id');

        // Ambil luaran tipe 'buku' yang terkait dengan pengabdian dosen login
        $luaranQuery = Luaran::with('luarable')
            ->where('luarable_type', 'App\Models\Pengabdian')
            ->where('tipe', 'buku')
            ->whereIn('luarable_id', $pengabdianIds)
            ->when($tahun, fn($q) => $q->where('tahun', $tahun));

        $luarans = $luaranQuery->get();

        $tahunList = Luaran::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Filter berdasarkan id_roadmap
        $luaranRoadmap1 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 1);
        $luaranRoadmap2 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 2);
        $luaranRoadmap3 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 3);

        $statistikRoadmap = [
            'Pembelajaran Domain TIK' => $luaranRoadmap1->count(),
            'Pembelajaran Berbantuan TIK' => $luaranRoadmap2->count(),
            'Informatika Terapan' => $luaranRoadmap3->count(),
        ];

        return view('dosen.pengabdian.luaranBuku.index', compact(
            'luaranRoadmap1',
            'luaranRoadmap2',
            'luaranRoadmap3',
            'tahunList',
            'statistikRoadmap'
        ));
    }

    public function createBuku()
    {
        $dosenLogin = Auth::guard('dosen')->user();

        // Ambil hanya pengabdian yang relevan dengan dosen login
        $pengabdians = Pengabdian::where('ketua', $dosenLogin->id)
            ->orWhereHas('anggotaPengabdian', function ($query) use ($dosenLogin) {
                $query->where('anggota_id', $dosenLogin->id)
                    ->where('anggota_type', 'Dosen');
            })
            ->select('id', 'judul', 'id_roadmap')
            ->get();

        return view('dosen.pengabdian.luaranBuku.create', compact('pengabdians'));
    }

    // Fungsi untuk menyimpan jurnal
    public function storeBuku(Request $request)
    {
        // Validasi input
        // $request->validate([
        //     'pengabdian_id' => 'required|exists:pengabdian,id', // Validasi ID pengabdian
        //     'judul' => 'required|string|max:255',
        //     'tahun' => 'required|integer',
        //     'sinta' => 'nullable|string|max:10',
        //     'link' => 'nullable|url',
        // ]);

        // Menyimpan data jurnal ke dalam database
        Luaran::create([
            'judul' => $request->judul,
            'tahun' => $request->tahun,
            'isbn' => $request->isbn,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'link' => $request->link,
            'tipe' => 'buku',
            'luarable_id' => $request->pengabdian_id, // Menyimpan ID pengabdian yang dipilih
            'luarable_type' => 'App\Models\Pengabdian', // Menyimpan tipe 'pengabdian'
        ]);

        // Redirect setelah berhasil
        return redirect()->route('luaran.pengabdian.buku.dosen')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function editBuku($id)
    {
        $pengabdians = Pengabdian::all();
        $luaran = Luaran::findOrFail($id);
        return view('dosen.pengabdian.luaranBuku.edit', compact('luaran', 'pengabdians'));
    }

    public function updateBuku(Request $request, $id)
    {
        // $request->validate([
        //     'pengabdian_id' => 'required|exists:pengabdian,id',
        //     'judul' => 'required|string|max:255',
        //     'tahun' => 'required|integer',
        //     'sinta' => 'nullable|string|max:100',
        //     'link' => 'nullable|url',
        // ]);

        $luaran = Luaran::findOrFail($id);
        $luaran->update([
            'pengabdian_id' => $request->pengabdian_id,
            'judul' => $request->judul,
            'tahun' => $request->tahun,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'isbn' => $request->isbn,
            'link' => $request->link,
        ]);

        return redirect()->route('luaran.pengabdian.buku.dosen')->with('success', 'Luaran berhasil diperbarui.');
    }

    public function destroyBuku($id)
    {
        $luaran = Luaran::findOrFail($id);
        $luaran->delete();

        return redirect()->back()->with('success', 'Luaran berhasil dihapus.');
    }

    public function video()
{
    $dosenLogin = Auth::guard('dosen')->user();
    $tahun = request('tahun');

    // Ambil ID pengabdian yang melibatkan dosen login
    $pengabdianIds = Pengabdian::where('ketua', $dosenLogin->id)
        ->orWhereHas('anggotaPengabdian', function ($query) use ($dosenLogin) {
            $query->where('anggota_id', $dosenLogin->id)
                  ->where('anggota_type', 'Dosen');
        })
        ->pluck('id');

    // Ambil luaran tipe 'video' yang terkait dengan pengabdian dosen login
    $luaranQuery = Luaran::with('luarable')
        ->where('luarable_type', 'App\Models\Pengabdian')
        ->where('tipe', 'video')
        ->whereIn('luarable_id', $pengabdianIds)
        ->when($tahun, fn($q) => $q->where('tahun', $tahun));

    $luarans = $luaranQuery->get();

    $tahunList = Luaran::select('tahun')
        ->distinct()
        ->orderBy('tahun', 'desc')
        ->pluck('tahun');

    // Filter berdasarkan id_roadmap
    $luaranRoadmap1 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 1);
    $luaranRoadmap2 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 2);
    $luaranRoadmap3 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 3);

    $statistikRoadmap = [
        'Pembelajaran Domain TIK' => $luaranRoadmap1->count(),
        'Pembelajaran Berbantuan TIK' => $luaranRoadmap2->count(),
        'Informatika Terapan' => $luaranRoadmap3->count(),
    ];

    return view('dosen.pengabdian.luaranVideo.index', compact(
        'luaranRoadmap1',
        'luaranRoadmap2',
        'luaranRoadmap3',
        'tahunList',
        'statistikRoadmap'
    ));
}

public function createVideo()
{
    $dosenLogin = Auth::guard('dosen')->user();

    // Ambil hanya pengabdian yang relevan dengan dosen login
    $pengabdians = Pengabdian::where('ketua', $dosenLogin->id)
        ->orWhereHas('anggotaPengabdian', function ($query) use ($dosenLogin) {
            $query->where('anggota_id', $dosenLogin->id)
                  ->where('anggota_type', 'Dosen');
        })
        ->select('id', 'judul', 'id_roadmap')
        ->get();

    return view('dosen.pengabdian.luaranVideo.create', compact('pengabdians'));
}

    // Fungsi untuk menyimpan jurnal
    public function storeVideo(Request $request)
    {
        // Validasi input
        // $request->validate([
        //     'pengabdian_id' => 'required|exists:pengabdian,id', // Validasi ID pengabdian
        //     'judul' => 'required|string|max:255',
        //     'tahun' => 'required|integer',
        //     'sinta' => 'nullable|string|max:10',
        //     'link' => 'nullable|url',
        // ]);

        // Menyimpan data jurnal ke dalam database
        Luaran::create([
            'judul' => $request->judul,
            'tahun' => $request->tahun,
            'tempat_konferensi' => $request->tempat_konferensi,
            'link' => $request->link,
            'tipe' => 'video',
            'luarable_id' => $request->pengabdian_id, // Menyimpan ID pengabdian yang dipilih
            'luarable_type' => 'App\Models\Pengabdian', // Menyimpan tipe 'pengabdian'
        ]);

        // Redirect setelah berhasil
        return redirect()->route('luaran.pengabdian.video.dosen')->with('success', 'Video berhasil ditambahkan.');
    }

    public function editVideo($id)
    {
        $pengabdians = Pengabdian::all();
        $luaran = Luaran::findOrFail($id);
        return view('dosen.pengabdian.luaranVideo.edit', compact('luaran', 'pengabdians'));
    }

    public function updateVideo(Request $request, $id)
    {
        $request->validate([
            'pengabdian_id' => 'required|exists:pengabdian,id',
            'judul' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'sinta' => 'nullable|string|max:100',
            'link' => 'nullable|url',
        ]);

        $luaran = Luaran::findOrFail($id);
        $luaran->update([
            'pengabdian_id' => $request->pengabdian_id,
            'judul' => $request->judul,
            'tahun' => $request->tahun,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'sinta' => $request->sinta,
            'link' => $request->link,
        ]);

        return redirect()->route('luaran.pengabdian.video.dosen')->with('success', 'Luaran berhasil diperbarui.');
    }

    public function destroyVideo($id)
    {
        $luaran = Luaran::findOrFail($id);
        $luaran->delete();

        return redirect()->back()->with('success', 'Luaran berhasil dihapus.');
    }
}
