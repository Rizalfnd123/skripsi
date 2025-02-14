<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use App\Models\Penelitian;
use App\Models\Pengabdian;
use App\Models\Roadmap;
use App\Models\Tingkat;

class YourController extends Controller
{
    public function index()
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

        return view('landing-page', compact('penelitianCount', 'pengabdianCount', 'roadmaps', 'tingkats','beritas'));
    }
}
