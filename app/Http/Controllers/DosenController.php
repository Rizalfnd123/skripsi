<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
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
}
