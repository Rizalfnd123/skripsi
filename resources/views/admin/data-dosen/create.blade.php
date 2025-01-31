@extends('layout.admin')

@section('title', 'Tambah Data Dosen')

@section('content')
<h2 class="text-2xl font-bold mb-4">Tambah Data Dosen</h2>

<form action="{{ route('dosen.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <div>
        <label for="nama" class="block font-medium">Nama</label>
        <input type="text" id="nama" name="nama" class="w-full border border-gray-300 rounded px-4 py-2" required>
    </div>
    <div>
        <label for="email" class="block font-medium">Email</label>
        <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded px-4 py-2" required>
    </div>
    <div>
        <label for="nip" class="block font-medium">NIP</label>
        <input type="text" id="nip" name="nip" class="w-full border border-gray-300 rounded px-4 py-2" required>
    </div>
    <div>
        <label for="nidn" class="block font-medium">NIDN</label>
        <input type="text" id="nidn" name="nidn" class="w-full border border-gray-300 rounded px-4 py-2" required>
    </div>
    <div>
        <label for="jenis_kelamin" class="block font-medium">Jenis Kelamin</label>
        <select id="jenis_kelamin" name="jenis_kelamin" class="w-full border border-gray-300 rounded px-4 py-2" required>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>
    </div>
    <div>
        <label for="foto" class="block font-medium">Foto</label>
        <input type="file" id="foto" name="foto" class="w-full border border-gray-300 rounded px-4 py-2">
    </div>
    <div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('dosen.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
    </div>
</form>
@endsection
