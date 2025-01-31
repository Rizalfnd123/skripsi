<?php
namespace App\Http\Controllers;

use App\Models\Tingkat;
use Illuminate\Http\Request;

class TingkatController extends Controller
{
    public function index()
    {
        $tingkats = Tingkat::all();
        return view('admin.tingkat.index', compact('tingkats'));
    }

    public function create()
    {
        return view('admin.tingkat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_tingkat' => 'required|string|max:255',
        ]);

        Tingkat::create([
            'jenis_tingkat' => $request->jenis_tingkat,
        ]);

        return redirect()->route('tingkat.index');
    }

    public function edit($id)
    {
        $tingkat = Tingkat::findOrFail($id);
        return view('admin.tingkat.edit', compact('tingkat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_tingkat' => 'required|string|max:255',
        ]);

        $tingkat = Tingkat::findOrFail($id);
        $tingkat->update([
            'jenis_tingkat' => $request->jenis_tingkat,
        ]);

        return redirect()->route('tingkat.index');
    }

    public function destroy($id)
    {
        $tingkat = Tingkat::findOrFail($id);
        $tingkat->delete();

        return redirect()->route('tingkat.index');
    }
}
