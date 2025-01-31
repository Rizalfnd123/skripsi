@extends('layout.admin')

@section('title', 'Edit Data Mitra')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Edit Data Mitra</h2>

    <form action="{{ route('mitra.update', $mitra->id_mitra) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label for="nama" class="block font-medium">Nama</label>
            <input type="text" id="nama" name="nama" value="{{ $mitra->nama }}" class="w-full border border-gray-300 rounded px-4 py-2" required>
        </div>
        <div>
            <label for="no_hp" class="block font-medium">No HP</label>
            <input type="text" id="no_hp" name="no_hp" value="{{ $mitra->no_hp }}" class="w-full border border-gray-300 rounded px-4 py-2" required>
        </div>
        <div>
            <label for="username" class="block font-medium">Username</label>
            <input type="text" id="username" name="username" value="{{ $mitra->username }}" class="w-full border border-gray-300 rounded px-4 py-2" required>
        </div>
        <div>
            <label for="password" class="block font-medium">Password</label>
            <input type="password" id="password" name="password" value="{{ $mitra->password }}" class="w-full border border-gray-300 rounded px-4 py-2" required>
        </div>
        <div>
            <label for="status" class="block font-medium">Status</label>
            <select id="status" name="status" class="w-full border border-gray-300 rounded px-4 py-2" required>
                <option value="tervalidasi" {{ $mitra->status == 'tervalidasi' ? 'selected' : '' }}>Tervalidasi</option>
                <option value="tidak" {{ $mitra->status == 'tidak' ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>
        <div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            <a href="{{ route('mitra.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
        </div>
    </form>
@endsection
