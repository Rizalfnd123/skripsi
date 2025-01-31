@extends('layout.admin')

@section('title', 'Edit Berita')

@section('content')
<h2 class="text-2xl font-bold mb-4">Edit Berita</h2>

<form action="{{ route('berita.update', $berita->id_berita) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @method('PUT') <!-- Method untuk update data -->
    <div>
        <label for="tanggal" class="block font-medium">Tanggal</label>
        <input type="text" id="tanggal" name="tanggal" class="w-full border border-gray-300 rounded px-4 py-2" 
               value="{{ \Carbon\Carbon::parse($berita->tanggal)->format('d/m/Y') }}" 
               placeholder="dd/mm/yyyy" required>
    </div>
    <div>
        <label for="judul" class="block font-medium">Judul</label>
        <input type="text" id="judul" name="judul" class="w-full border border-gray-300 rounded px-4 py-2" value="{{ $berita->judul }}" required>
    </div>
    <div>
        <label for="keterangan" class="block font-medium">Keterangan</label>
        <textarea id="keterangan" name="keterangan" class="w-full border border-gray-300 rounded px-4 py-2" rows="5" required>{{ $berita->keterangan }}</textarea>
    </div>
    <div>
        <label for="foto" class="block font-medium">Foto</label>
        <input type="file" id="foto" name="foto" class="w-full border border-gray-300 rounded px-4 py-2">
        @if ($berita->foto)
            <img src="{{ asset('storage/' . $berita->foto) }}" alt="Foto Berita" class="w-32 h-32 mt-2 rounded">
        @endif
    </div>
    <div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Perubahan</button>
        <a href="{{ route('berita.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
    </div>
</form>
@endsection
