<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Berita;
use App\Models\Roadmap;
use App\Models\Tingkat;
use App\Models\Semester;
use App\Models\Penelitian;
use App\Models\Pengabdian;
use Illuminate\Http\Request;

class YourController extends Controller
{
    public function index()
    {
        $beritas = Berita::latest()->get();
        $roadmaps = Roadmap::all();
        $tingkats = Tingkat::all();

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

        return view('landing-page', compact(
            'beritas',
            'roadmaps',
            'tingkats',
            'dataPenelitian',
            'dataPengabdian',
            'roadmapLabels',
            'years'
        ));
    }

    public function adminhome()
    {
        $beritas = Berita::latest()->get();
        $roadmaps = Roadmap::all();
        $tingkats = Tingkat::all();

        // Ambil roadmap yang tersedia
        $roadmapLabels = Roadmap::pluck('jenis_roadmap')->toArray();

        // Ambil data penelitian berdasarkan roadmap dan bulan
        $penelitianStats = Penelitian::selectRaw('MONTH(tanggal) as bulan, id_roadmap, COUNT(*) as total')
            ->groupBy('bulan', 'id_roadmap')
            ->get();

        // Ambil data pengabdian berdasarkan roadmap dan bulan
        $pengabdianStats = Pengabdian::selectRaw('MONTH(tanggal) as bulan, id_roadmap, COUNT(*) as total')
            ->groupBy('bulan', 'id_roadmap')
            ->get();

        // Data untuk frontend (ubah ke format yang cocok untuk Chart.js)
        $dataPenelitian = [];
        $dataPengabdian = [];

        foreach ($roadmaps as $roadmap) {
            $dataPenelitian[$roadmap->jenis_roadmap] = array_fill(0, 12, 0);
            $dataPengabdian[$roadmap->jenis_roadmap] = array_fill(0, 12, 0);
        }

        foreach ($penelitianStats as $stat) {
            $roadmapName = Roadmap::find($stat->id_roadmap)?->jenis_roadmap;
            if ($roadmapName) {
                $dataPenelitian[$roadmapName][$stat->bulan - 1] = $stat->total;
            }
        }

        foreach ($pengabdianStats as $stat) {
            $roadmapName = Roadmap::find($stat->id_roadmap)?->jenis_roadmap;
            if ($roadmapName) {
                $dataPengabdian[$roadmapName][$stat->bulan - 1] = $stat->total;
            }
        }

        return view('admin.dashboard', compact(
            'beritas',
            'roadmaps',
            'tingkats',
            'dataPenelitian',
            'dataPengabdian',
            'roadmapLabels'
        ));
    }
}
