<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mitra;
use App\Models\Roadmap;
use App\Models\Tingkat;
use App\Models\Mahasiswa;
use App\Models\Penelitian;
use App\Models\Pengabdian;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Tambahkan untuk export PDF

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $tingkat = Tingkat::all();
        $roadmap = Roadmap::all();
        $dosens = Dosen::all();
        $mahasiswa = Mahasiswa::all();
        $mitra = Mitra::all();

        // Ambil filter semester dari request
        $semester = $request->semester;

        $penelitianQuery = Penelitian::with([
            'tingkat',
            'roadmap',
            'ketuaDosen',
            'anggotaPenelitian.dosen',
            'anggotaPenelitian.mahasiswa'
        ]);

        if ($semester) {
            // Cek apakah semester ganjil atau genap
            [$tahun, $jenisSemester] = explode(' ', $semester);

            if (strtolower($jenisSemester) == 'ganjil') {
                $penelitianQuery->whereBetween('tanggal', ["$tahun-07-01", "$tahun-12-31"]);
            } elseif (strtolower($jenisSemester) == 'genap') {
                $tahunGenap = (int) $tahun + 1; // Semester genap berlangsung hingga tahun berikutnya
                $penelitianQuery->whereBetween('tanggal', ["$tahunGenap-01-01", "$tahunGenap-06-30"]);
            }
        }

        $penelitian = $penelitianQuery->paginate(10);

        return view('admin.rekap.penelitian', compact('penelitian', 'tingkat', 'roadmap', 'dosens', 'mitra', 'mahasiswa', 'semester'));
    }


    public function exportPDF(Request $request)
    {
        $semester = $request->semester;
        $penelitianQuery = Penelitian::with([
            'tingkat',
            'roadmap',
            'ketuaDosen',
            'anggotaPenelitian.dosen',
            'anggotaPenelitian.mahasiswa'
        ]);

        if ($semester) {
            $semesterParts = explode(' ', $semester);
            if (count($semesterParts) == 2) {
                [$tahun, $jenisSemester] = $semesterParts;
                $tahunGenap = (int) $tahun + 1;

                if (strtolower($jenisSemester) == 'ganjil') {
                    $penelitianQuery->whereBetween('tanggal', ["$tahun-07-01", "$tahun-12-31"]);
                } elseif (strtolower($jenisSemester) == 'genap') {
                    $penelitianQuery->whereBetween('tanggal', ["$tahun-01-01", "$tahunGenap-06-30"]);
                }
            }
        }

        $penelitian = $penelitianQuery->get();

        // Load view PDF dan tambahkan semester ke dalamnya
        $pdf = Pdf::loadView('admin.rekap.penelitian_pdf', compact('penelitian', 'semester'));

        return $pdf->download('Rekap_Penelitian_' . ($semester ?: 'Semua') . '.pdf');
    }

    public function exportPDF2(Request $request)
    {
        $semester = $request->semester;
        $pengabdianQuery = Pengabdian::with([
            'tingkat',
            'roadmap',
            'ketuaDosen',
            'anggotaPengabdian.dosen',
            'anggotaPengabdian.mahasiswa'
        ]);

        if ($semester) {
            $semesterParts = explode(' ', $semester);
            if (count($semesterParts) == 2) {
                [$tahun, $jenisSemester] = $semesterParts;
                $tahunGenap = (int) $tahun + 1;

                if (strtolower($jenisSemester) == 'ganjil') {
                    $pengabdianQuery->whereBetween('tanggal', ["$tahun-07-01", "$tahun-12-31"]);
                } elseif (strtolower($jenisSemester) == 'genap') {
                    $pengabdianQuery->whereBetween('tanggal', ["$tahun-01-01", "$tahunGenap-06-30"]);
                }
            }
        }

        $pengabdian = $pengabdianQuery->get();

        // Load view PDF dan tambahkan semester ke dalamnya
        $pdf = Pdf::loadView('admin.rekap.pengabdian_pdf', compact('pengabdian', 'semester'));

        return $pdf->download('Rekap_Pengabdian_' . ($semester ?: 'Semua') . '.pdf');
    }
}
