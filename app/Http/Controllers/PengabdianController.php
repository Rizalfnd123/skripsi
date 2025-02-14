<?php

namespace App\Http\Controllers;

use App\Models\AnggotaPengabdian;
use App\Models\pengabdian;
use App\Models\Tingkat;
use App\Models\Roadmap;
use App\Models\Dosen;
use App\Models\Luaran;
use App\Models\Mahasiswa;
use App\Models\Mitra;
use Illuminate\Http\Request;

class PengabdianController extends Controller
{

    public function storeLuaran(Request $request, $pengabdianId)
    {
        $request->validate([
            'tipe' => 'required|in:jurnal,HKI,produk,sertifikat',
            'dokumen' => 'required|file|mimes:pdf,docx,jpg,png|max:10240',
        ]);

        $pengabdian = pengabdian::findOrFail($pengabdianId);

        $dokumenPath = $request->file('dokumen')->store('luaran_documents', 'public');

        Luaran::create([
            'pengabdian_id' => $pengabdian->id,
            'tipe' => $request->tipe,
            'dokumen' => $dokumenPath,
        ]);

        return redirect()->route('pengabdian.edit', $pengabdian->id)
            ->with('success', 'Luaran berhasil ditambahkan!');
    }

    public function index()
    {

        $tingkat = Tingkat::all();
        $roadmap = Roadmap::all();
        $dosens = Dosen::all();
        $mahasiswa  = Mahasiswa::all();
        $mitra = Mitra::all();
        $pengabdian = Pengabdian::with([
            'tingkat',
            'roadmap',
            'ketuaDosen',
            'anggotaPengabdian.dosen',
            'anggotaPengabdian.mahasiswa'
        ])->paginate(10);
        // dd($pengabdian);
        return view('admin.pengabdian.index', compact('pengabdian', 'tingkat', 'roadmap', 'dosens', 'mitra', 'mahasiswa'));
    }

    public function create()
    {
        $tingkat = Tingkat::all();
        $roadmap = Roadmap::all();
        $dosens = Dosen::all();
        $mahasiswa  = Mahasiswa::all();
        $mitra = Mitra::all();
        // dd($mahasiswa);
        return view('admin.pengabdian.create', compact('tingkat', 'roadmap', 'dosens', 'mitra', 'mahasiswa'));
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

        return redirect()->route('pengabdian.index')->with('success', 'pengabdian berhasil disimpan.');
    }


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
        return view('admin.pengabdian.edit', compact(
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
        return redirect()->route('pengabdian.index')->with('success', 'pengabdian berhasil diperbarui');
    }
    public function destroy($id)
    {
        $pengabdian = Pengabdian::findOrFail($id);
        $pengabdian->delete();

        return redirect()->route('pengabdian.index')->with('success', 'Data pengabdian berhasil dihapus.');
    }
    public function list()
    {

        $tingkat = Tingkat::all();
        $roadmap = Roadmap::all();
        $dosens = Dosen::all();
        $mahasiswa  = Mahasiswa::all();
        $mitra = Mitra::all();
        $pengabdians = Pengabdian::with([
            'tingkat',
            'roadmap',
            'ketuaDosen',
            'anggotaPengabdian.dosen',
            'anggotaPengabdian.mahasiswa'
        ])->paginate(10);
        // dd($pengabdian);
        return view('pengabdian', compact('pengabdians', 'tingkat', 'roadmap', 'dosens', 'mitra', 'mahasiswa'));
    }
    public function menumitra()
    {

        $tingkat = Tingkat::all();
        $roadmap = Roadmap::all();
        $dosens = Dosen::all();
        $mahasiswa  = Mahasiswa::all();
        $mitra = Mitra::all();
        $pengabdians = Pengabdian::with([
            'tingkat',
            'roadmap',
            'ketuaDosen',
            'anggotaPengabdian.dosen',
            'anggotaPengabdian.mahasiswa'
        ])->paginate(10);
        // dd($pengabdian);
        return view('mitra.pengabdian', compact('pengabdians', 'tingkat', 'roadmap', 'dosens', 'mitra', 'mahasiswa'));
    }
}
