<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class YourController extends Controller
{
    public function store(Request $request)
    {
        // Ambil data yang dikirim dari form
        $dosen = $request->input('dosen');
        $mahasiswa = $request->input('mahasiswa');

        // Lakukan logika penyimpanan data ke dalam database
        // Contoh:
        // Dosen::create([...]);
        // Mahasiswa::create([...]);

        // Redirect setelah berhasil
        return redirect()->route('yourRouteName')->with('success', 'Data berhasil disimpan!');
    }
}
