<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    public function index()
    {
        $mitras = Mitra::all();
        return view('admin.mitra.index', compact('mitras'));
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
