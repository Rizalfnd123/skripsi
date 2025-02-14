<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RequestPenelitian; // Gantilah nama model agar tidak bentrok

class RequestController extends Controller
{
    public function index()
    {
        // Ambil ID mitra yang login
        $mitraId = Auth::guard('mitra')->id();

        // Ambil data request berdasarkan ID mitra
        $requests = RequestPenelitian::where('id_mitra', $mitraId)->get();

        // Kirim data ke view
        return view('mitra.request', compact('requests'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_penelitian' => 'required|exists:penelitian,id',
            'id_mitra' => 'required|exists:mitra,id',
            'keterangan' => 'nullable|string',
        ]);

        RequestPenelitian::create([
            'id_penelitian' => $request->id_penelitian,
            'id_mitra' => $request->id_mitra,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Request berhasil dikirim.');
    }
}
