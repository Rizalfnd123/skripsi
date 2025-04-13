<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mitra;
use App\Models\Berita;
use App\Models\Roadmap;
use App\Models\Tingkat;
use App\Models\Penelitian;
use App\Models\Pengabdian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DosenController extends Controller
{
    public function index()
    {
        $dosens = Dosen::all();
        return view('admin.data-dosen.index', compact('dosens'));
    }

    public function create()
    {
        return view('admin.data-dosen.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'nip' => 'required|string',
            'nidn' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('dosen', 'public');
            $validated['foto'] = $path;
        }

        Dosen::create($validated);

        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil ditambahkan.');
    }


    public function edit(Dosen $dosen)
    {
        return view('admin.data-dosen.edit', compact('dosen'));
    }

    public function update(Request $request, Dosen $dosen)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:dosens,email,' . $dosen->id_dosen . ',id_dosen',
            'nip' => 'required|string|unique:dosens,nip,' . $dosen->id_dosen . ',id_dosen',
            'nidn' => 'required|string|unique:dosens,nidn,' . $dosen->id_dosen . ',id_dosen',
            'jenis_kelamin' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);        

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($dosen->foto) {
                Storage::delete('public/' . $dosen->foto);
            }
            $path = $request->file('foto')->store('dosen', 'public');
            $validated['foto'] = $path;
        }

        $dosen->update($validated);

        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil diperbarui.');
    }


    public function destroy(Dosen $dosen)
    {
        if ($dosen->foto) {
            Storage::delete($dosen->foto);
        }
        $dosen->delete();
        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil dihapus.');
    }
    public function show()
    {
        $dosen = Auth::guard('dosen')->user(); // Ambil data dosen yang login
        $beritas = Berita::latest()->get();
        $roadmaps = Roadmap::all();
        $tingkats = Tingkat::all();
        $tpenelitian = Penelitian::count();
        $tpengabdian = Pengabdian::count();
        $tmitra = Mitra::count();

        // Ambil daftar tahun unik dari penelitian dan pengabdian
        $years = Penelitian::selectRaw("YEAR(tanggal) as tahun")
            ->union(Pengabdian::selectRaw("YEAR(tanggal) as tahun"))
            ->distinct()
            ->orderBy('tahun', 'DESC')
            ->pluck('tahun')
            ->toArray();

        // Ambil roadmap yang tersedia
        $roadmapLabels = Roadmap::pluck('jenis_roadmap')->toArray();

        // Ambil data penelitian berdasarkan tahun & roadmap
        $penelitianStats = Penelitian::selectRaw("YEAR(tanggal) as tahun, id_roadmap, COUNT(*) as total")
            ->groupBy('tahun', 'id_roadmap')
            ->get();

        // Ambil data pengabdian berdasarkan tahun & roadmap
        $pengabdianStats = Pengabdian::selectRaw("YEAR(tanggal) as tahun, id_roadmap, COUNT(*) as total")
            ->groupBy('tahun', 'id_roadmap')
            ->get();

        // Format data untuk Chart.js
        $dataPenelitian = [];
        $dataPengabdian = [];

        foreach ($roadmaps as $roadmap) {
            foreach ($years as $year) {
                $dataPenelitian[$roadmap->jenis_roadmap][$year] = 0;
                $dataPengabdian[$roadmap->jenis_roadmap][$year] = 0;
            }
        }

        foreach ($penelitianStats as $stat) {
            $roadmapName = Roadmap::find($stat->id_roadmap)?->jenis_roadmap;
            if ($roadmapName) {
                $dataPenelitian[$roadmapName][$stat->tahun] = $stat->total;
            }
        }

        foreach ($pengabdianStats as $stat) {
            $roadmapName = Roadmap::find($stat->id_roadmap)?->jenis_roadmap;
            if ($roadmapName) {
                $dataPengabdian[$roadmapName][$stat->tahun] = $stat->total;
            }
        }
        return view('dosen.beranda', compact(
            'dosen',
            'beritas',
            'roadmaps',
            'tingkats',
            'dataPenelitian',
            'dataPengabdian',
            'roadmapLabels',
            'years',
            'tpenelitian',
            'tpengabdian',
            'tmitra',
        ));
    }
}
