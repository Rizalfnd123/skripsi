@extends('layout.admin')

@section('title', 'Tambah Berita')

@section('content')
<h2 class="text-2xl font-bold mb-4">Tambah Berita</h2>

<form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <div>
        <label for="tanggal" class="block font-medium">Tanggal</label>
        <input type="text" id="tanggal" name="tanggal" class="w-full border border-gray-300 rounded px-4 py-2" required>
    </div>
    <div>
        <label for="foto" class="block font-medium">Foto</label>
        <input type="file" id="foto" name="foto" class="w-full border border-gray-300 rounded px-4 py-2" required>
    </div>
    <div>
        <label for="judul" class="block font-medium">Judul</label>
        <input type="text" id="judul" name="judul" class="w-full border border-gray-300 rounded px-4 py-2" required>
    </div>
    <div>
        <label for="keterangan" class="block font-medium">Keterangan</label>
        <textarea id="keterangan" name="keterangan" rows="5" class="w-full border border-gray-300 rounded px-4 py-2" required></textarea>
    </div>
    <div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('berita.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
    </div>
</form>
@endsection
