<?php
namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    // Display all mahasiswa
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        return view('admin.data-mahasiswa.index', compact('mahasiswa'));
    }

    // Show form for creating a new mahasiswa
    public function create()
    {
        return view('admin.data-mahasiswa.create');
    }

    // Store a newly created mahasiswa in database
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|integer',
            'jenis_kelamin' => 'required|string',
            'angkatan' => 'required|integer',
            'no_hp' => 'required|string|max:15',
        ]);

        Mahasiswa::create($request->all());
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    // Show form for editing a mahasiswa
    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('admin.data-mahasiswa.edit', compact('mahasiswa'));
    }

    // Update a mahasiswa
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|integer',
            'jenis_kelamin' => 'required|string',
            'angkatan' => 'required|integer',
            'no_hp' => 'required|string|max:15',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update($request->all());
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil diperbarui.');
    }

    // Delete a mahasiswa
    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus.');
    }
}
