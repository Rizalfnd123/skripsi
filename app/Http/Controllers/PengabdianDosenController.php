<?php

namespace App\Http\Controllers;


use App\Models\Dosen;
use App\Models\Mitra;
use App\Models\Luaran;
use App\Models\Roadmap;
use App\Models\Tingkat;
use App\Models\Mahasiswa;
use App\Models\pengabdian;
use Illuminate\Http\Request;
use App\Models\AnggotaPengabdian;
use Illuminate\Support\Facades\Auth;

class PengabdianDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $tingkat = Tingkat::all();
    $roadmap = Roadmap::all();
    $dosens = Dosen::all();
    $mahasiswa = Mahasiswa::all();
    $mitra = Mitra::all();

    $dosenLogin = Auth::guard('dosen')->user();
    $tahun = $request->tahun;

    // Ambil daftar tahun unik dari tanggal pengabdian
    $tahunList = Pengabdian::selectRaw('YEAR(tanggal) as tahun')
        ->distinct()
        ->orderByDesc('tahun')
        ->pluck('tahun');

    // Data pengabdian dikelompokkan per roadmap
    $pengabdianPerRoadmap = [];

    foreach ($roadmap as $rm) {
        $query = Pengabdian::with([
            'tingkat',
            'roadmap',
            'ketuaDosen',
            'anggotaPengabdian.dosen',
            'anggotaPengabdian.mahasiswa'
        ])
        ->where('id_roadmap', $rm->id)
        ->where(function ($q) use ($dosenLogin) {
            $q->where('ketua', $dosenLogin->id)
              ->orWhereHas('anggotaPengabdian', function ($q2) use ($dosenLogin) {
                  $q2->where('anggota_id', $dosenLogin->id)
                      ->where('anggota_type', 'Dosen');
              });
        });

        if ($tahun) {
            $query->whereYear('tanggal', $tahun);
        }

        // Paginate per roadmap, gunakan page unik agar tidak konflik
        $pengabdianPerRoadmap[$rm->id] = $query->paginate(10, ['*'], 'page_roadmap_' . $rm->id);
    }
    $chartData = [
        'labels' => $roadmap->pluck('jenis_roadmap'),
        'jumlahPengabdian' => $roadmap->map(function ($rm) use ($dosenLogin, $tahun) {
            $query = Pengabdian::where('id_roadmap', $rm->id)
                ->where(function ($q) use ($dosenLogin) {
                    $q->where('ketua', $dosenLogin->id)
                      ->orWhereHas('anggotaPengabdian', function ($q2) use ($dosenLogin) {
                          $q2->where('anggota_id', $dosenLogin->id)->where('anggota_type', 'Dosen');
                      });
                });
            if ($tahun) {
                $query->whereYear('tanggal', $tahun);
            }
            return $query->count();
        }),
    ];

    return view('dosen.pengabdian.index', compact(
        'tingkat', 'roadmap', 'dosens', 'mahasiswa', 'mitra',
        'tahunList', 'tahun', 'pengabdianPerRoadmap','chartData'
    ));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tingkat = Tingkat::all();
        $roadmap = Roadmap::all();
        $dosens = Dosen::all();
        $mahasiswa  = Mahasiswa::all();
        $mitra = Mitra::all();
        // dd($mahasiswa);
        return view('dosen.pengabdian.create', compact('tingkat', 'roadmap', 'dosens', 'mitra', 'mahasiswa'));
    }

    /**
     * Store a newly created resource in storage.
     */
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

        // Simpan data pengabdian ke database
        $pengabdian = Pengabdian::create([
            'judul' => $validated['judul'],
            'tanggal' => $validated['tanggal'],
            'id_tingkat' => $validated['id_tingkat'],
            'id_roadmap' => $validated['id_roadmap'],
            'ketua' => $validated['ketua'],
        ]);

        // Simpan anggota dosen ke tabel anggota_pengabdian
        foreach ($validated['anggota_dosen'] as $dosenId) {
            \App\Models\AnggotaPengabdian::create([
                'id_pengabdian' => $pengabdian->id,
                'anggota_id' => $dosenId,
                'anggota_type' => 'Dosen',
            ]);
        }

        foreach ($validated['anggota_mahasiswa'] as $mahasiswaId) {
            \App\Models\AnggotaPengabdian::create([
                'id_pengabdian' => $pengabdian->id,
                'anggota_id' => $mahasiswaId,
                'anggota_type' => 'Mahasiswa',
            ]);
        }

        return redirect()->route('pengabdian-guru.index')->with('success', 'pengabdian berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tingkat = Tingkat::all();
        $roadmap = Roadmap::all();
        $dosens = Dosen::all();
        $mahasiswa = Mahasiswa::all();
        $mitra = Mitra::all();

        // Ambil data pengabdian yang sedang diedit
        $pengabdian = Pengabdian::findOrFail($id);

        // Ambil ID dosen & mahasiswa yang sudah menjadi anggota
        $anggotaDosenIds = $pengabdian->anggotaPengabdian->where('anggota_type', 'Dosen')->pluck('anggota_id')->toArray();
        $anggotaMahasiswaIds = $pengabdian->anggotaPengabdian->where('anggota_type', 'Mahasiswa')->pluck('anggota_id')->toArray();

        // dd($anggotaDosenIds);
        return view('dosen.pengabdian.edit', compact(
            'pengabdian',
            'tingkat',
            'roadmap',
            'dosens',
            'mahasiswa',
            'mitra',
            'anggotaDosenIds',
            'anggotaMahasiswaIds'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
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

        // Cari pengabdian yang akan diperbarui
        $pengabdian = Pengabdian::findOrFail($id);

        // Update data pengabdian
        $pengabdian->update([
            'judul' => $request->judul,
            'tanggal' => $request->tanggal,
            'id_tingkat' => $request->id_tingkat,
            'id_roadmap' => $request->id_roadmap,
            'ketua' => $request->ketua,
        ]);

        // Hapus anggota yang lama dan tambahkan yang baru
        // Menghapus anggota dosen lama
        $pengabdian->anggotaPengabdian()->where('anggota_type', 'Dosen')->delete();

        // Menghapus anggota mahasiswa lama
        $pengabdian->anggotaPengabdian()->where('anggota_type', 'Mahasiswa')->delete();

        // Menambahkan anggota dosen baru
        if ($request->has('anggota_dosen')) {
            foreach ($request->anggota_dosen as $dosen_id) {
                $pengabdian->anggotaPengabdian()->create([
                    'anggota_id' => $dosen_id,
                    'anggota_type' => 'Dosen',
                ]);
            }
        }

        // Menambahkan anggota mahasiswa baru
        if ($request->has('anggota_mahasiswa')) {
            foreach ($request->anggota_mahasiswa as $mahasiswa_id) {
                $pengabdian->anggotaPengabdian()->create([
                    'anggota_id' => $mahasiswa_id,
                    'anggota_type' => 'Mahasiswa',
                ]);
            }
        }

        // Redirect dengan pesan sukses
        return redirect()->route('pengabdian-guru.index')->with('success', 'pengabdian berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pengabdian = Pengabdian::findOrFail($id);
        $pengabdian->delete();

        return redirect()->route('pengabdian-dosen.index')->with('success', 'Data pengabdian berhasil dihapus.');
    }
}
