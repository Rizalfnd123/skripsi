<?php

namespace App\Http\Controllers;

use App\Models\Luaran;
use App\Models\Pengabdian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dosen;

class LuaranPengabdianController extends Controller
{
    public function jurnal()
    {
        $tahun = request('tahun');

        $luaranQuery = Luaran::with('luarable')
            ->where('luarable_type', 'App\Models\Pengabdian')
            ->where('tipe', 'jurnal')
            ->when($tahun, fn($q) => $q->where('tahun', $tahun));

        $luarans = $luaranQuery->get();

        $tahunList = Luaran::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Filter luaran berdasarkan roadmap (misal berdasarkan ID roadmap)
        $luaranRoadmap1 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 1);
        $luaranRoadmap2 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 2);
        $luaranRoadmap3 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 3);
        $roadmapStats = [
            'Pembelajaran Domain TIK' => $luaranRoadmap1->count(),
            'Pembelajaran Berbantuan TIK' => $luaranRoadmap2->count(),
            'Informatika Terapan' => $luaranRoadmap3->count(),
        ];
        return view('admin.pengabdian.luaranJurnal.jurnal', compact('luaranRoadmap1', 'luaranRoadmap2', 'luaranRoadmap3', 'tahunList','roadmapStats'));
    }

    public function createJurnal()
    {
        $pengabdians = Pengabdian::select('id', 'judul', 'id_roadmap')->get(); // Ambil semua data pengabdian
        return view('admin.pengabdian.luaranJurnal.create', compact('pengabdians'));
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
        return redirect()->route('luaran.pengabdian.jurnal')->with('success', 'Jurnal berhasil ditambahkan.');
    }

    public function editJurnal($id)
    {
        $pengabdians = Pengabdian::all();
        $luaran = Luaran::findOrFail($id);
        return view('admin.pengabdian.luaranJurnal.edit', compact('luaran', 'pengabdians'));
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

        return redirect()->route('luaran.pengabdian.jurnal')->with('success', 'Luaran berhasil diperbarui.');
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

        $luaranQuery = Luaran::with('luarable')
            ->where('luarable_type', 'App\Models\Pengabdian')
            ->where('tipe', 'HKI')
            ->when($tahun, fn($q) => $q->where('tahun', $tahun));

        $luarans = $luaranQuery->get();

        $tahunList = Luaran::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Filter luaran berdasarkan roadmap (misal berdasarkan ID roadmap)
        $luaranRoadmap1 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 1);
        $luaranRoadmap2 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 2);
        $luaranRoadmap3 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 3);
        $statistikRoadmap = [
            'Pembelajaran Domain TIK' => $luaranRoadmap1->count(),
            'Pembelajaran Berbantuan TIK' => $luaranRoadmap2->count(),
            'Informatika Terapan' => $luaranRoadmap3->count(),
        ];
        return view('admin.pengabdian.luaranHki.index', compact('luaranRoadmap1', 'luaranRoadmap2', 'luaranRoadmap3', 'tahunList','statistikRoadmap'));
    }

    public function createHki()
    {
        $pengabdians = Pengabdian::select('id', 'judul', 'id_roadmap')->get(); // Ambil semua data pengabdian
        return view('admin.pengabdian.luaranHki.create', compact('pengabdians'));
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
        return redirect()->route('luaran.pengabdian.hki')->with('success', 'Jurnal berhasil ditambahkan.');
    }

    public function editHki($id)
    {
        $pengabdians = Pengabdian::all();
        $luaran = Luaran::findOrFail($id);
        return view('admin.pengabdian.luaranHki.edit', compact('luaran', 'pengabdians'));
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

        return redirect()->route('luaran.pengabdian.hki')->with('success', 'Luaran berhasil diperbarui.');
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

        $luaranQuery = Luaran::with('luarable')
            ->where('luarable_type', 'App\Models\Pengabdian')
            ->where('tipe', 'prosiding')
            ->when($tahun, fn($q) => $q->where('tahun', $tahun));

        $luarans = $luaranQuery->get();

        $tahunList = Luaran::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Filter luaran berdasarkan roadmap (misal berdasarkan ID roadmap)
        $luaranRoadmap1 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 1);
        $luaranRoadmap2 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 2);
        $luaranRoadmap3 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 3);
        $statistikRoadmap = [
            'Pembelajaran Domain TIK' => $luaranRoadmap1->count(),
            'Pembelajaran Berbantuan TIK' => $luaranRoadmap2->count(),
            'Informatika Terapan' => $luaranRoadmap3->count(),
        ];
        return view('admin.pengabdian.luaranProsiding.index', compact('luaranRoadmap1', 'luaranRoadmap2', 'luaranRoadmap3', 'tahunList','statistikRoadmap'));
    }

    public function createProsiding()
    {
        $pengabdians = Pengabdian::select('id', 'judul', 'id_roadmap')->get(); // Ambil semua data pengabdian
        return view('admin.pengabdian.luaranProsiding.create', compact('pengabdians'));
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
        return redirect()->route('luaran.pengabdian.prosiding')->with('success', 'Prosiding berhasil ditambahkan.');
    }

    public function editProsiding($id)
    {
        $pengabdians = Pengabdian::all();
        $luaran = Luaran::findOrFail($id);
        return view('admin.pengabdian.luaranProsiding.edit', compact('luaran', 'pengabdians'));
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

        return redirect()->route('luaran.pengabdian.prosiding')->with('success', 'Luaran berhasil diperbarui.');
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

        $luaranQuery = Luaran::with('luarable')
            ->where('luarable_type', 'App\Models\Pengabdian')
            ->where('tipe', 'buku')
            ->when($tahun, fn($q) => $q->where('tahun', $tahun));

        $luarans = $luaranQuery->get();

        $tahunList = Luaran::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Filter luaran berdasarkan roadmap (misal berdasarkan ID roadmap)
        $luaranRoadmap1 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 1);
        $luaranRoadmap2 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 2);
        $luaranRoadmap3 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 3);
        $statistikRoadmap = [
            'Pembelajaran Domain TIK' => $luaranRoadmap1->count(),
            'Pembelajaran Berbantuan TIK' => $luaranRoadmap2->count(),
            'Informatika Terapan' => $luaranRoadmap3->count(),
        ];
        return view('admin.pengabdian.luaranBuku.index', compact('luaranRoadmap1', 'luaranRoadmap2', 'luaranRoadmap3', 'tahunList','statistikRoadmap'));
    }

    public function createBuku()
    {
        $pengabdians = Pengabdian::select('id', 'judul', 'id_roadmap')->get(); // Ambil semua data pengabdian
        return view('admin.pengabdian.luaranBuku.create', compact('pengabdians'));
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
        return redirect()->route('luaran.pengabdian.buku')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function editBuku($id)
    {
        $pengabdians = Pengabdian::all();
        $luaran = Luaran::findOrFail($id);
        return view('admin.pengabdian.luaranBuku.edit', compact('luaran', 'pengabdians'));
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

        return redirect()->route('luaran.pengabdian.buku')->with('success', 'Luaran berhasil diperbarui.');
    }

    public function destroyBuku($id)
    {
        $luaran = Luaran::findOrFail($id);
        $luaran->delete();

        return redirect()->back()->with('success', 'Luaran berhasil dihapus.');
    }

    public function video()
    {
        $tahun = request('tahun');

        $luaranQuery = Luaran::with('luarable')
            ->where('luarable_type', 'App\Models\Pengabdian')
            ->where('tipe', 'video')
            ->when($tahun, fn($q) => $q->where('tahun', $tahun));

        $luarans = $luaranQuery->get();

        $tahunList = Luaran::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Filter luaran berdasarkan roadmap (misal berdasarkan ID roadmap)
        $luaranRoadmap1 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 1);
        $luaranRoadmap2 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 2);
        $luaranRoadmap3 = $luarans->filter(fn($l) => $l->luarable?->id_roadmap === 3);
        $statistikRoadmap = [
            'Pembelajaran Domain TIK' => $luaranRoadmap1->count(),
            'Pembelajaran Berbantuan TIK' => $luaranRoadmap2->count(),
            'Informatika Terapan' => $luaranRoadmap3->count(),
        ];
        return view('admin.pengabdian.luaranVideo.index', compact('luaranRoadmap1', 'luaranRoadmap2', 'luaranRoadmap3', 'tahunList','statistikRoadmap'));
    }

    public function createVideo()
    {
        $dosens = Dosen::all();
        $pengabdians = Pengabdian::select('id', 'judul', 'id_roadmap')->get(); // Ambil semua data pengabdian
        return view('admin.pengabdian.luaranVideo.create', compact('pengabdians'));
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
        return redirect()->route('luaran.pengabdian.video')->with('success', 'Video berhasil ditambahkan.');
    }

    public function editVideo($id)
    {
        $pengabdians = Pengabdian::all();
        $luaran = Luaran::findOrFail($id);
        return view('admin.pengabdian.luaranVideo.edit', compact('luaran', 'pengabdians'));
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

        return redirect()->route('luaran.pengabdian.video')->with('success', 'Luaran berhasil diperbarui.');
    }

    public function destroyVideo($id)
    {
        $luaran = Luaran::findOrFail($id);
        $luaran->delete();

        return redirect()->back()->with('success', 'Luaran berhasil dihapus.');
    }
}

