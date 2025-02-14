<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\Berita;
use App\Models\Roadmap;
use App\Models\Tingkat;
use App\Models\Penelitian;
use App\Models\Pengabdian;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MitraController extends Controller
{
    public function index()
    {
        $mitras = Mitra::all();
        return view('admin.mitra.index', compact('mitras'));
    }
    public function show()
    {
        $beritas = Berita::latest()->get(); 
        $roadmaps = Roadmap::all(); // Ambil semua roadmap
        $tingkats = Tingkat::all(); // Ambil semua tingkat

        // Ambil data penelitian dan pengabdian berdasarkan filter roadmap dan tingkat
        $penelitianQuery = Penelitian::query();
        $pengabdianQuery = Pengabdian::query();

        // Filter berdasarkan roadmap dan tingkat jika ada parameter
        if (request()->has('roadmap_id')) {
            $penelitianQuery->where('id_roadmap', request('roadmap_id'));
            $pengabdianQuery->where('id_roadmap', request('roadmap_id'));
        }

        if (request()->has('tingkat_id')) {
            $penelitianQuery->where('id_tingkat', request('tingkat_id'));
            $pengabdianQuery->where('id_tingkat', request('tingkat_id'));
        }

        // Ambil data penelitian dan pengabdian yang difilter
        $penelitian = $penelitianQuery->get();
        $pengabdian = $pengabdianQuery->get();

        // Ambil data statistik untuk grafik
        $penelitianCount = $penelitian->count();
        $pengabdianCount = $pengabdian->count();
        return view('mitra.landing', compact('penelitianCount', 'pengabdianCount', 'roadmaps', 'tingkats','beritas'));
    }

    public function create()
    {
        return view('admin.mitra.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|numeric',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'status' => 'required|in:tervalidasi,tidak',
        ]);

        Mitra::create($request->all());

        return redirect()->route('mitra.index')->with('success', 'Mitra berhasil ditambahkan');
    }

    public function edit($id)
    {
        $mitra = Mitra::findOrFail($id);
        return view('admin.mitra.edit', compact('mitra'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|numeric',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'status' => 'required|in:tervalidasi,tidak',
        ]);

        $mitra = Mitra::findOrFail($id);
        $mitra->update($request->all());

        return redirect()->route('mitra.index')->with('success', 'Mitra berhasil diperbarui');
    }

    public function destroy($id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->delete();

        return redirect()->route('mitra.index')->with('success', 'Mitra berhasil dihapus');
    }
}
