<?php

namespace App\Http\Controllers;

use App\Models\Luaran;
use App\Models\Roadmap;
use App\Models\Penelitian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LuaranPenelitianDosenController extends Controller
{
    public function jurnal()
    {
        $tahun = request('tahun');
        $dosenLogin = Auth::guard('dosen')->user(); // Sesuaikan dengan model dosen jika bukan default auth

        // Ambil ID penelitian yang melibatkan dosen login (sebagai ketua atau anggota)
        $penelitianIds = Penelitian::where(function ($q) use ($dosenLogin) {
            $q->where('ketua', $dosenLogin->id)
                ->orWhereHas('anggotaPenelitian', function ($q2) use ($dosenLogin) {
                    $q2->where('anggota_id', $dosenLogin->id)
                        ->where('anggota_type', 'Dosen');
                });
        })
            ->pluck('id');

        // Ambil luaran tipe jurnal dari penelitian dosen login
        $luaranQuery = Luaran::with('luarable')
            ->where('luarable_type', \App\Models\Penelitian::class)
            ->whereIn('luarable_id', $penelitianIds)
            ->where('tipe', 'jurnal')
            ->when($tahun, fn($q) => $q->where('tahun', $tahun));

        $luarans = $luaranQuery->get();

        // Ambil list tahun untuk filter dropdown
        $tahunList = Luaran::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Filter luaran berdasarkan roadmap (jika luaran punya relasi ke penelitian dan roadmap-nya)
        $luaranRoadmap1 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 1);
        $luaranRoadmap2 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 2);
        $luaranRoadmap3 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 3);

        // Hitung jumlah jurnal per roadmap
        $roadmapStats = [
            'Pembelajaran Domain TIK' => $luaranRoadmap1->count(),
            'Pembelajaran Berbantuan TIK' => $luaranRoadmap2->count(),
            'Informatika Terapan' => $luaranRoadmap3->count(),
        ];

        return view('dosen.penelitian.luaranJurnal.jurnal', compact(
            'luaranRoadmap1',
            'luaranRoadmap2',
            'luaranRoadmap3',
            'tahunList',
            'roadmapStats'
        ));
    }

    public function createJurnal()
    {
        $dosenLogin = Auth::guard('dosen')->user(); // Ambil dosen yang login

        // Ambil hanya penelitian yang terkait dengan dosen login
        $penelitians = Penelitian::where(function ($query) use ($dosenLogin) {
            $query->where('ketua', $dosenLogin->id)
                ->orWhereHas('anggotaPenelitian', function ($subQuery) use ($dosenLogin) {
                    $subQuery->where('anggota_id', $dosenLogin->id)
                        ->where('anggota_type', 'Dosen');
                });
        })
            ->select('id', 'judul', 'id_roadmap')
            ->get();

        return view('dosen.penelitian.luaranJurnal.create', compact('penelitians'));
    }

    // Fungsi untuk menyimpan jurnal
    public function storeJurnal(Request $request)
    {
        // Validasi input
        $request->validate([
            'penelitian_id' => 'required|exists:penelitian,id', // Validasi ID penelitian
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
            'luarable_id' => $request->penelitian_id, // Menyimpan ID penelitian yang dipilih
            'luarable_type' => 'App\Models\Penelitian', // Menyimpan tipe 'Penelitian'
        ]);

        // Redirect setelah berhasil
        return redirect()->route('luaran.penelitian.jurnal.dosen')->with('success', 'Jurnal berhasil ditambahkan.');
    }

    public function editJurnal($id)
    {
        $dosenLogin = Auth::guard('dosen')->user(); // Ambil dosen yang login

        // Ambil hanya penelitian yang terkait dengan dosen login
        $penelitians = Penelitian::where(function ($query) use ($dosenLogin) {
            $query->where('ketua', $dosenLogin->id)
                ->orWhereHas('anggotaPenelitian', function ($subQuery) use ($dosenLogin) {
                    $subQuery->where('anggota_id', $dosenLogin->id)
                        ->where('anggota_type', 'Dosen');
                });
        })
            ->select('id', 'judul', 'id_roadmap')
            ->get();
        $luaran = Luaran::findOrFail($id);
        return view('dosen.penelitian.luaranJurnal.edit', compact('luaran', 'penelitians'));
    }

    public function updateJurnal(Request $request, $id)
    {
        $request->validate([
            'penelitian_id' => 'required|exists:penelitian,id',
            'judul' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'sinta' => 'nullable|string|max:100',
            'link' => 'nullable|url',
        ]);

        $luaran = Luaran::findOrFail($id);
        $luaran->update([
            'penelitian_id' => $request->penelitian_id,
            'judul' => $request->judul,
            'tahun' => $request->tahun,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'sinta' => $request->sinta,
            'link' => $request->link,
        ]);

        return redirect()->route('luaran.penelitian.jurnal.dosen')->with('success', 'Luaran berhasil diperbarui.');
    }

    public function destroyJurnal($id)
    {
        $luaran = Luaran::findOrFail($id);
        $luaran->delete();

        return redirect()->back()->with('success', 'Luaran berhasil dihapus.');
    }


    public function hki()
    {
        $tahun = request('tahun');
        $dosenLogin = Auth::guard('dosen')->user(); // Sesuaikan dengan model dosen jika bukan default auth

        // Ambil ID penelitian yang melibatkan dosen login (sebagai ketua atau anggota)
        $penelitianIds = Penelitian::where(function ($q) use ($dosenLogin) {
            $q->where('ketua', $dosenLogin->id)
                ->orWhereHas('anggotaPenelitian', function ($q2) use ($dosenLogin) {
                    $q2->where('anggota_id', $dosenLogin->id)
                        ->where('anggota_type', 'Dosen');
                });
        })
            ->pluck('id');

        // Ambil luaran tipe HKI dari penelitian dosen login
        $luaranQuery = Luaran::with('luarable')
            ->where('luarable_type', \App\Models\Penelitian::class)
            ->whereIn('luarable_id', $penelitianIds)
            ->where('tipe', 'HKI')
            ->when($tahun, fn($q) => $q->where('tahun', $tahun));

        $luarans = $luaranQuery->get();

        // Ambil list tahun untuk filter dropdown
        $tahunList = Luaran::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Filter luaran berdasarkan roadmap (jika luaran punya relasi ke penelitian dan roadmap-nya)
        $luaranRoadmap1 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 1);
        $luaranRoadmap2 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 2);
        $luaranRoadmap3 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 3);

        // Hitung jumlah HKI per roadmap
        $statistikRoadmap = [
            'Pembelajaran Domain TIK' => $luaranRoadmap1->count(),
            'Pembelajaran Berbantuan TIK' => $luaranRoadmap2->count(),
            'Informatika Terapan' => $luaranRoadmap3->count(),
        ];

        return view('dosen.penelitian.luaranHki.index', compact(
            'luaranRoadmap1',
            'luaranRoadmap2',
            'luaranRoadmap3',
            'tahunList',
            'statistikRoadmap'
        ));
    }

    public function createHki()
    {
        $dosenLogin = Auth::guard('dosen')->user(); // Ambil dosen yang login

        // Ambil hanya penelitian yang terkait dengan dosen login
        $penelitians = Penelitian::where(function ($query) use ($dosenLogin) {
            $query->where('ketua', $dosenLogin->id)
                ->orWhereHas('anggotaPenelitian', function ($subQuery) use ($dosenLogin) {
                    $subQuery->where('anggota_id', $dosenLogin->id)
                        ->where('anggota_type', 'Dosen');
                });
        })
            ->select('id', 'judul', 'id_roadmap')
            ->get();

        return view('dosen.penelitian.luaranHki.create', compact('penelitians'));
    }

    // Fungsi untuk menyimpan jurnal
    public function storeHki(Request $request)
    {
        // Validasi input
        // $request->validate([
        //     'penelitian_id' => 'required|exists:penelitian,id', // Validasi ID penelitian
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
            'luarable_id' => $request->penelitian_id, // Menyimpan ID penelitian yang dipilih
            'luarable_type' => 'App\Models\Penelitian', // Menyimpan tipe 'Penelitian'
        ]);

        // Redirect setelah berhasil
        return redirect()->route('luaran.penelitian.hki.dosen')->with('success', 'Jurnal berhasil ditambahkan.');
    }

    public function editHki($id)
    {
        $dosenLogin = Auth::guard('dosen')->user();

        // Ambil hanya penelitian yang terkait dengan dosen login
        $penelitians = Penelitian::where(function ($query) use ($dosenLogin) {
            $query->where('ketua', $dosenLogin->id)
                ->orWhereHas('anggotaPenelitian', function ($subQuery) use ($dosenLogin) {
                    $subQuery->where('anggota_id', $dosenLogin->id)
                        ->where('anggota_type', 'Dosen');
                });
        })
            ->select('id', 'judul', 'id_roadmap')
            ->get();

        // Ambil data luaran berdasarkan ID
        $luaran = Luaran::findOrFail($id);

        return view('dosen.penelitian.luaranHki.edit', compact('luaran', 'penelitians'));
    }

    public function updateHki(Request $request, $id)
    {
        // $request->validate([
        //     'penelitian_id' => 'required|exists:penelitian,id',
        //     'judul' => 'required|string|max:255',
        //     'tahun' => 'required|integer',
        //     'sinta' => 'nullable|string|max:100',
        //     'link' => 'nullable|url',
        // ]);

        $luaran = Luaran::findOrFail($id);
        $luaran->update([
            'penelitian_id' => $request->penelitian_id,
            'nama_karya' => $request->nama_karya,
            'jenis' => $request->jenis,
            'pencipta' => $request->pencipta,
            'pemegang_hak_cipta' => $request->pemegang_hak_cipta,
            'nomor_pengajuan' => $request->nomor_pengajuan,
            'tanggal_diterima' => $request->tanggal_diterima,
            'link' => $request->link,
        ]);

        return redirect()->route('luaran.penelitian.hki.dosen')->with('success', 'Luaran berhasil diperbarui.');
    }

    public function destroyHki($id)
    {
        $luaran = Luaran::findOrFail($id);
        $luaran->delete();

        return redirect()->back()->with('success', 'Luaran berhasil dihapus.');
    }


    public function prosiding()
    {
        $tahun = request('tahun');
        $dosenLogin = Auth::guard('dosen')->user();

        // Ambil ID penelitian yang terkait dengan dosen login
        $penelitianIds = Penelitian::where(function ($q) use ($dosenLogin) {
            $q->where('ketua', $dosenLogin->id)
                ->orWhereHas('anggotaPenelitian', function ($q2) use ($dosenLogin) {
                    $q2->where('anggota_id', $dosenLogin->id)
                        ->where('anggota_type', 'Dosen');
                });
        })->pluck('id');

        // Ambil luaran tipe prosiding dari penelitian dosen login
        $luaranQuery = Luaran::with('luarable')
            ->where('luarable_type', \App\Models\Penelitian::class)
            ->whereIn('luarable_id', $penelitianIds)
            ->where('tipe', 'prosiding')
            ->when($tahun, fn($q) => $q->where('tahun', $tahun));

        $luarans = $luaranQuery->get();

        // List tahun untuk filter
        $tahunList = Luaran::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        // Filter berdasarkan roadmap
        $luaranRoadmap1 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 1);
        $luaranRoadmap2 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 2);
        $luaranRoadmap3 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 3);

        $statistikRoadmap = [
            'Pembelajaran Domain TIK' => $luaranRoadmap1->count(),
            'Pembelajaran Berbantuan TIK' => $luaranRoadmap2->count(),
            'Informatika Terapan' => $luaranRoadmap3->count(),
        ];

        return view('dosen.penelitian.luaranProsiding.index', compact(
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

        // Ambil hanya penelitian yang dimiliki atau diikuti oleh dosen login
        $penelitians = Penelitian::where(function ($query) use ($dosenLogin) {
            $query->where('ketua', $dosenLogin->id)
                ->orWhereHas('anggotaPenelitian', function ($subQuery) use ($dosenLogin) {
                    $subQuery->where('anggota_id', $dosenLogin->id)
                        ->where('anggota_type', 'Dosen');
                });
        })
            ->select('id', 'judul', 'id_roadmap')
            ->get();

        return view('dosen.penelitian.luaranProsiding.create', compact('penelitians'));
    }

    // Fungsi untuk menyimpan jurnal
    public function storeProsiding(Request $request)
    {
        // Validasi input
        $request->validate([
            'penelitian_id' => 'required|exists:penelitian,id', // Validasi ID penelitian
            'judul' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'sinta' => 'nullable|string|max:10',
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
            'penyelenggara' => $request->penyelenggara,
            'nama_konferensi' => $request->nama_konferensi,
            'tempat_konferensi' => $request->tempat_konferensi,
            'tgl_konferensi' => $request->tgl_konferensi,
            'tipe' => 'prosiding',
            'luarable_id' => $request->penelitian_id, // Menyimpan ID penelitian yang dipilih
            'luarable_type' => 'App\Models\Penelitian', // Menyimpan tipe 'Penelitian'
        ]);

        // Redirect setelah berhasil
        return redirect()->route('luaran.penelitian.prosiding.dosen')->with('success', 'Prosiding berhasil ditambahkan.');
    }

    public function editProsiding($id)
    {
        $dosenLogin = Auth::guard('dosen')->user();

        // Ambil hanya penelitian yang dimiliki atau diikuti oleh dosen login
        $penelitians = Penelitian::where(function ($query) use ($dosenLogin) {
            $query->where('ketua', $dosenLogin->id)
                ->orWhereHas('anggotaPenelitian', function ($subQuery) use ($dosenLogin) {
                    $subQuery->where('anggota_id', $dosenLogin->id)
                        ->where('anggota_type', 'Dosen');
                });
        })
            ->select('id', 'judul', 'id_roadmap')
            ->get();

        $luaran = Luaran::findOrFail($id);

        return view('dosen.penelitian.luaranProsiding.edit', compact('luaran', 'penelitians'));
    }

    public function updateProsiding(Request $request, $id)
    {
        // $request->validate([
        //     'penelitian_id' => 'required|exists:penelitian,id',
        //     'judul' => 'required|string|max:255',
        //     'tahun' => 'required|integer',
        //     'sinta' => 'nullable|string|max:100',
        //     'link' => 'nullable|url',
        // ]);

        $luaran = Luaran::findOrFail($id);
        $luaran->update([
            'penelitian_id' => $request->penelitian_id,
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

        return redirect()->route('luaran.penelitian.prosiding.dosen')->with('success', 'Luaran berhasil diperbarui.');
    }

    public function destroyProsiding($id)
    {
        $luaran = Luaran::findOrFail($id);
        $luaran->delete();

        return redirect()->back()->with('success', 'Luaran berhasil dihapus.');
    }


    public function buku()
    {
        $tahun = request('tahun');
        $dosenLogin = Auth::guard('dosen')->user();

        // Ambil ID penelitian yang melibatkan dosen login
        $penelitianIds = Penelitian::where(function ($q) use ($dosenLogin) {
            $q->where('ketua', $dosenLogin->id)
                ->orWhereHas('anggotaPenelitian', function ($q2) use ($dosenLogin) {
                    $q2->where('anggota_id', $dosenLogin->id)
                        ->where('anggota_type', 'Dosen');
                });
        })->pluck('id');

        // Ambil luaran tipe buku dari penelitian dosen login
        $luaranQuery = Luaran::with('luarable')
            ->where('luarable_type', \App\Models\Penelitian::class)
            ->whereIn('luarable_id', $penelitianIds)
            ->where('tipe', 'buku')
            ->when($tahun, fn($q) => $q->where('tahun', $tahun));

        $luarans = $luaranQuery->get();

        // Ambil list tahun untuk filter dropdown
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

        return view('dosen.penelitian.luaranBuku.index', compact(
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

        // Ambil penelitian yang hanya melibatkan dosen login
        $penelitians = Penelitian::where(function ($query) use ($dosenLogin) {
            $query->where('ketua', $dosenLogin->id)
                ->orWhereHas('anggotaPenelitian', function ($subQuery) use ($dosenLogin) {
                    $subQuery->where('anggota_id', $dosenLogin->id)
                        ->where('anggota_type', 'Dosen');
                });
        })
            ->select('id', 'judul', 'id_roadmap')
            ->get();

        return view('dosen.penelitian.luaranBuku.create', compact('penelitians'));
    }

    // Fungsi untuk menyimpan jurnal
    public function storeBuku(Request $request)
    {
        // Validasi input
        // $request->validate([
        //     'penelitian_id' => 'required|exists:penelitian,id', // Validasi ID penelitian
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
            'luarable_id' => $request->penelitian_id, // Menyimpan ID penelitian yang dipilih
            'luarable_type' => 'App\Models\Penelitian', // Menyimpan tipe 'Penelitian'
        ]);

        // Redirect setelah berhasil
        return redirect()->route('luaran.penelitian.buku.dosen')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function editBuku($id)
    {
        $dosenLogin = Auth::guard('dosen')->user();

        // Ambil hanya penelitian yang terkait dengan dosen login (sebagai ketua atau anggota)
        $penelitians = Penelitian::where(function ($query) use ($dosenLogin) {
            $query->where('ketua', $dosenLogin->id)
                ->orWhereHas('anggotaPenelitian', function ($subQuery) use ($dosenLogin) {
                    $subQuery->where('anggota_id', $dosenLogin->id)
                        ->where('anggota_type', 'Dosen');
                });
        })->get();

        $luaran = Luaran::findOrFail($id);

        return view('dosen.penelitian.luaranBuku.edit', compact('luaran', 'penelitians'));
    }

    public function updateBuku(Request $request, $id)
    {
        // $request->validate([
        //     'penelitian_id' => 'required|exists:penelitian,id',
        //     'judul' => 'required|string|max:255',
        //     'tahun' => 'required|integer',
        //     'sinta' => 'nullable|string|max:100',
        //     'link' => 'nullable|url',
        // ]);

        $luaran = Luaran::findOrFail($id);
        $luaran->update([
            'penelitian_id' => $request->penelitian_id,
            'judul' => $request->judul,
            'tahun' => $request->tahun,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'isbn' => $request->isbn,
            'link' => $request->link,
        ]);

        return redirect()->route('luaran.penelitian.buku.dosen')->with('success', 'Luaran berhasil diperbarui.');
    }

    public function destroyBuku($id)
    {
        $luaran = Luaran::findOrFail($id);
        $luaran->delete();

        return redirect()->back()->with('success', 'Luaran berhasil dihapus.');
    }
}
