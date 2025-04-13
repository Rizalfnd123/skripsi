<?php
namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::all();
        return view('admin.semester.index', compact('semesters'));
    }

    public function create()
    {
        return view('admin.semester.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Semester::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('semester.index');
    }

    public function edit($id)
    {
        $semester = Semester::findOrFail($id);
        return view('admin.semester.edit', compact('semester'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $semester = Semester::findOrFail($id);
        $semester->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('semester.index');
    }

    public function destroy($id)
    {
        $semester = Semester::findOrFail($id);
        $semester->delete();

        return redirect()->route('semester.index');
    }
}
