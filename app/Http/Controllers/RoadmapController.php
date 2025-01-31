<?php

namespace App\Http\Controllers;

use App\Models\Roadmap;
use Illuminate\Http\Request;

class RoadmapController extends Controller
{
    public function index()
    {
        $roadmaps = Roadmap::all();
        return view('admin.data-umum.index', compact('roadmaps'));
    }

    public function create()
    {
        return view('admin.data-umum.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_roadmap' => 'required|string|max:255',
        ]);

        Roadmap::create($request->all());

        return redirect()->route('roadmap.index')->with('success', 'Roadmap created successfully.');
    }

    public function edit(Roadmap $roadmap)
    {
        return view('admin.data-umum.edit', compact('roadmap'));
    }

    public function update(Request $request, Roadmap $roadmap)
    {
        $request->validate([
            'jenis_roadmap' => 'required|string|max:255',
        ]);

        $roadmap->update($request->all());

        return redirect()->route('roadmap.index')->with('success', 'Roadmap updated successfully.');
    }

    public function destroy(Roadmap $roadmap)
    {
        $roadmap->delete();

        return redirect()->route('roadmap.index')->with('success', 'Roadmap deleted successfully.');
    }
}
