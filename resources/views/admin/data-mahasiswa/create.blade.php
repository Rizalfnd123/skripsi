@extends('layout.admin')

@section('title', 'Tambah Data Mahasiswa')

@section('content')
<h2 class="text-2xl font-bold mb-4">Tambah Data Mahasiswa</h2>

<form action="{{ route('mahasiswa.store') }}" method="POST" class="space-y-4">
    @csrf
    <div>
        <label for="nama" class="block font-medium">Nama</label>
        <input type="text" id="nama" name="nama" class="w-full border border-gray-300 rounded px-4 py-2" required>
    </div>
    <div>
        <label for="nim" class="block font-medium">NIM</label>
        <input type="number" id="nim" name="nim" class="w-full border border-gray-300 rounded px-4 py-2" required>
    </div>
    <div>
        <label for="jenis_kelamin" class="block font-medium">Jenis Kelamin</label>
        <select id="jenis_kelamin" name="jenis_kelamin" class="w-full border border-gray-300 rounded px-4 py-2" required>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>
    </div>
    <div>
        <label for="angkatan" class="block font-medium">Angkatan</label>
        <input type="number" id="angkatan" name="angkatan" class="w-full border border-gray-300 rounded px-4 py-2" required>
    </div>
    <div>
        <label for="no_hp" class="block font-medium">No HP</label>
        <input type="text" id="no_hp" name="no_hp" class="w-full border border-gray-300 rounded px-4 py-2" required>
    </div>
    <div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('mahasiswa.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
    </div>
</form>
@endsection
