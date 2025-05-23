<?php

namespace App\Http\Controllers;

use App\Models\AnggotaPenelitian;
use App\Models\Penelitian;
use App\Models\Tingkat;
use App\Models\Roadmap;
use App\Models\Dosen;
use App\Models\Luaran;
use App\Models\Mahasiswa;
use App\Models\Mitra;
use Illuminate\Http\Request;

class PenelitianController extends Controller
{

    public function storeLuaran(Request $request, $penelitianId)
    {
        $request->validate([
            'tipe' => 'required|in:jurnal,HKI,produk,sertifikat',
            'dokumen' => 'required|file|mimes:pdf,docx,jpg,png|max:10240',
        ]);

        $penelitian = Penelitian::findOrFail($penelitianId);

        $dokumenPath = $request->file('dokumen')->store('luaran_documents', 'public');

        Luaran::create([
            'penelitian_id' => $penelitian->id,
            'tipe' => $request->tipe,
            'dokumen' => $dokumenPath,
        ]);

        return redirect()->route('penelitian.edit', $penelitian->id)
            ->with('success', 'Luaran berhasil ditambahkan!');
    }

    public function index(Request $request)
    {
        $tingkat = Tingkat::all();
        $roadmaps = Roadmap::all();
        $dosens = Dosen::all();
        $mahasiswa = Mahasiswa::all();
        $mitra = Mitra::all();

        $tahun = $request->tahun;

        // Ambil list tahun unik dari tabel penelitian
        $tahunList = Penelitian::selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        $penelitiansPerRoadmap = [];

        foreach ($roadmaps as $roadmap) {
            $query = Penelitian::with([
                'tingkat',
                'roadmap',
                'ketuaDosen',
                'anggotaPenelitian.dosen',
                'anggotaPenelitian.mahasiswa'
            ])->where('id_roadmap', $roadmap->id);

            // Filter berdasarkan tahun
            if ($tahun) {
                $query->whereYear('tanggal', $tahun);
            }

            // Paginasi per-roadmap
            $penelitiansPerRoadmap[$roadmap->id] = $query->paginate(10, ['*'], 'page_roadmap_' . $roadmap->id);
        }
        $statistikRoadmap = [];

        foreach ($roadmaps as $rm) {
            $count = Penelitian::where('id_roadmap', $rm->id)
                ->when($tahun, fn($q) => $q->whereYear('tanggal', $tahun))
                ->count();
            $statistikRoadmap[$rm->jenis_roadmap] = $count;
        }


        return view('admin.penelitian.index', [
            'penelitiansPerRoadmap' => $penelitiansPerRoadmap,
            'tingkat' => $tingkat,
            'roadmap' => $roadmaps,
            'dosens' => $dosens,
            'mahasiswa' => $mahasiswa,
            'mitra' => $mitra,
            'tahun' => $tahun,
            'tahunList' => $tahunList,
            'statistikRoadmap' => $statistikRoadmap,
        ]);
    }
    public function create()
    {
        $tingkat = Tingkat::all();
        $roadmap = Roadmap::all();
        $dosens = Dosen::all();
        $mahasiswa  = Mahasiswa::all();
        $mitra = Mitra::all();
        // dd($mahasiswa);
        return view('admin.penelitian.create', compact('tingkat', 'roadmap', 'dosens', 'mitra', 'mahasiswa'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'id_tingkat' => 'required|integer',
            'id_roadmap' => 'required|integer',
            'ketua' => 'required|integer',
            'anggota_dosen' => 'required|array',
            'anggota_mahasiswa' => 'required|array', // Pastikan mahasiswa bisa nullable
        ]);

        // Simpan data penelitian ke database
        $penelitian = Penelitian::create([
            'judul' => $validated['judul'],
            'tanggal' => $validated['tanggal'],
            'id_tingkat' => $validated['id_tingkat'],
            'id_roadmap' => $validated['id_roadmap'],
            'ketua' => $validated['ketua'],
        ]);

        // Simpan anggota dosen ke tabel anggota_penelitian
        foreach ($validated['anggota_dosen'] as $dosenId) {
            \App\Models\AnggotaPenelitian::create([
                'id_penelitian' => $penelitian->id,
                'anggota_id' => $dosenId,
                'anggota_type' => 'Dosen',
            ]);
        }

        foreach ($validated['anggota_mahasiswa'] as $mahasiswaId) {
            \App\Models\AnggotaPenelitian::create([
                'id_penelitian' => $penelitian->id,
                'anggota_id' => $mahasiswaId,
                'anggota_type' => 'Mahasiswa',
            ]);
        }

        return redirect()->route('penelitian.index')->with('success', 'Penelitian berhasil disimpan.');
    }


    public function edit($id)
    {
        $tingkat = Tingkat::all();
        $roadmap = Roadmap::all();
        $dosens = Dosen::all();
        $mahasiswa = Mahasiswa::all();
        $mitra = Mitra::all();

        // Ambil data penelitian yang sedang diedit
        $penelitian = Penelitian::findOrFail($id);

        // Ambil ID dosen & mahasiswa yang sudah menjadi anggota
        $anggotaDosenIds = $penelitian->anggotaPenelitian->where('anggota_type', 'Dosen')->pluck('anggota_id')->toArray();
        $anggotaMahasiswaIds = $penelitian->anggotaPenelitian->where('anggota_type', 'Mahasiswa')->pluck('anggota_id')->toArray();

        // dd($anggotaDosenIds);
        return view('admin.penelitian.edit', compact(
            'penelitian',
            'tingkat',
            'roadmap',
            'dosens',
            'mahasiswa',
            'mitra',
            'anggotaDosenIds',
            'anggotaMahasiswaIds'
        ));
    }


    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'id_tingkat' => 'required|exists:tingkat,id',
            'id_roadmap' => 'required|exists:roadmap,id',
            'ketua' => 'required|exists:dosens,id',
            'anggota_dosen' => 'nullable|array',
            'anggota_dosen.*' => 'exists:dosens,id',
            'anggota_mahasiswa' => 'nullable|array',
            'anggota_mahasiswa.*' => 'exists:mahasiswa,id_mahasiswa',
        ]);

        // Cari penelitian yang akan diperbarui
        $penelitian = Penelitian::findOrFail($id);

        // Update data penelitian
        $penelitian->update([
            'judul' => $request->judul,
            'tanggal' => $request->tanggal,
            'id_tingkat' => $request->id_tingkat,
            'id_roadmap' => $request->id_roadmap,
            'ketua' => $request->ketua,
        ]);

        // Hapus anggota yang lama dan tambahkan yang baru
        // Menghapus anggota dosen lama
        $penelitian->anggotaPenelitian()->where('anggota_type', 'Dosen')->delete();

        // Menghapus anggota mahasiswa lama
        $penelitian->anggotaPenelitian()->where('anggota_type', 'Mahasiswa')->delete();

        // Menambahkan anggota dosen baru
        if ($request->has('anggota_dosen')) {
            foreach ($request->anggota_dosen as $dosen_id) {
                $penelitian->anggotaPenelitian()->create([
                    'anggota_id' => $dosen_id,
                    'anggota_type' => 'Dosen',
                ]);
            }
        }

        // Menambahkan anggota mahasiswa baru
        if ($request->has('anggota_mahasiswa')) {
            foreach ($request->anggota_mahasiswa as $mahasiswa_id) {
                $penelitian->anggotaPenelitian()->create([
                    'anggota_id' => $mahasiswa_id,
                    'anggota_type' => 'Mahasiswa',
                ]);
            }
        }

        // Redirect dengan pesan sukses
        return redirect()->route('penelitian.index')->with('success', 'Penelitian berhasil diperbarui');
    }




    public function destroy($id)
    {
        $penelitian = Penelitian::findOrFail($id);
        $penelitian->delete();

        return redirect()->route('penelitian.index')->with('success', 'Data penelitian berhasil dihapus.');
    }
    public function list()
    {

        $tingkat = Tingkat::all();
        $roadmap = Roadmap::all();
        $dosens = Dosen::all();
        $mahasiswa  = Mahasiswa::all();
        $mitra = Mitra::all();
        $penelitians = Penelitian::with([
            'tingkat',
            'roadmap',
            'ketuaDosen',
            'anggotaPenelitian.dosen',
            'anggotaPenelitian.mahasiswa'
        ])->paginate(10);
        return view('penelitian', compact('penelitians', 'tingkat', 'roadmap', 'dosens', 'mitra', 'mahasiswa'));
    }
    public function menumitra()
    {

        $tingkat = Tingkat::all();
        $roadmap = Roadmap::all();
        $dosens = Dosen::all();
        $mahasiswa  = Mahasiswa::all();
        $mitra = Mitra::all();
        $penelitians = Penelitian::with([
            'tingkat',
            'roadmap',
            'ketuaDosen',
            'anggotaPenelitian.dosen',
            'anggotaPenelitian.mahasiswa'
        ])->paginate(10);
        return view('mitra.penelitian', compact('penelitians', 'tingkat', 'roadmap', 'dosens', 'mitra', 'mahasiswa'));
    }
}
