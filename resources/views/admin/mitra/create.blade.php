@extends('layout.admin')

@section('title', 'Tambah Data Mitra')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Tambah Data Mitra</h2>

    <form action="{{ route('mitra.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="nama" class="block font-medium">Nama</label>
            <input type="text" id="nama" name="nama" class="w-full border border-gray-300 rounded px-4 py-2" required>
        </div>
        <div>
            <label for="no_hp" class="block font-medium">No HP</label>
            <input type="text" id="no_hp" name="no_hp" class="w-full border border-gray-300 rounded px-4 py-2" required>
        </div>
        <div>
            <label for="username" class="block font-medium">Username</label>
            <input type="text" id="username" name="username" class="w-full border border-gray-300 rounded px-4 py-2" required>
        </div>
        <div>
            <label for="password" class="block font-medium">Password</label>
            <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded px-4 py-2" required>
        </div>
        <div>
            <label for="status" class="block font-medium">Status</label>
            <select id="status" name="status" class="w-full border border-gray-300 rounded px-4 py-2" required>
                <option value="tervalidasi">Tervalidasi</option>
                <option value="tidak">Tidak</option>
            </select>
        </div>
        <div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('mitra.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
        </div>
    </form>
@endsection
