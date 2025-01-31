<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::latest()->paginate(5);
        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date_format:d/m/Y', // Validasi format dd/mm/yyyy
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'judul' => 'required|string|max:255',
            'keterangan' => 'required',
        ]);

        // Mengubah format tanggal dari dd/mm/yyyy menjadi yyyy-mm-dd
        $tanggal = \DateTime::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d');

        // Menyimpan foto
        $fotoPath = $request->file('foto')->store('berita', 'public');

        // Menyimpan data berita
        Berita::create([
            'tanggal' => $tanggal,
            'foto' => $fotoPath,
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        // Validasi input
        $request->validate([
            'tanggal' => 'required|date_format:d/m/Y',  // Pastikan validasi sesuai dengan format dd/mm/yyyy
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'judul' => 'required|string|max:255',
            'keterangan' => 'required',
        ]);

        // Mengonversi tanggal dari dd/mm/yyyy ke yyyy-mm-dd
        $tanggal = \Carbon\Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d');

        // Menyimpan foto jika ada
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('berita', 'public');
            $berita->foto = $fotoPath;
        }

        // Update data berita
        $berita->update([
            'tanggal' => $tanggal,  // Menggunakan tanggal yang sudah dikonversi
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diupdate.');
    }


    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->delete();

        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}
