<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RequestPenelitian; // Gantilah nama model agar tidak bentrok

class RequestAdminController extends Controller
{
    public function index()
    {

        $requests = RequestPenelitian::with(['mitra', 'penelitian'])->get();

        // Kirim data ke view
        return view('admin.request.index', compact('requests'));
    }
    public function index2()
    {

        $requests = RequestPenelitian::with(['mitra', 'penelitian'])->get();

        // Kirim data ke view
        return view('dosen.request.index', compact('requests'));
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
    public function updateStatus(Request $request, $id)
    {
        $requestData = RequestPenelitian::findOrFail($id); // Ganti 'RequestModel' dengan model yang sesuai
        $requestData->status = $request->status;
        $requestData->save();

        return response()->json(['message' => 'Status berhasil diperbarui!']);
        // return redirect()->back()->with('success', 'Status berhasil diperbarui!');
    }
}
