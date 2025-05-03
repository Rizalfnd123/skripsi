<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('admin.profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($validated['password']) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('photo')) {
            $fotoPath = $request->file('photo')->store('profil', 'public');
            $user->photo = $fotoPath; // Simpan path-nya ke kolom 'photo'
        }

        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'Profil berhasil diperbarui.');
    }
    public function editdosen()
    {
        $dosen = Auth::user();
        return view('dosen.profile.edit', compact('dosen'));
    }

    public function updatedosen(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nip' => 'nullable|string|max:50',
            'nidn' => 'nullable|string|max:50',
            'jenis_kelamin' => 'nullable|in:L,P',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $dosen = Auth::user();

        $data = $request->only(['nama', 'email', 'nip', 'nidn', 'jenis_kelamin']);

        if ($request->hasFile('foto')) {
        // Hapus foto lama jika ada
        if ($dosen->foto) {
            Storage::disk('public')->delete($dosen->foto);
        }

        $fotoPath = $request->file('foto')->store('profil', 'public'); // Simpan ke storage/app/public/profil
        $data['foto'] = $fotoPath; // Simpan path ke DB
    }
        /** @var \App\Models\Dosen $dosen */
        $dosen->update($data);

        return redirect()->route('profile.edit.dosen')->with('success', 'Profil berhasil diperbarui.');
    }
}
