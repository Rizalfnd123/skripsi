@extends('layout.admin')

@section('title', 'Edit Data Dosen')

@section('content')
<h2 class="text-2xl font-bold mb-4">Edit Data Dosen</h2>

<form action="{{ route('dosen.update', $dosen->id_dosen) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label for="nama" class="block font-medium">Nama</label>
        <input type="text" id="nama" name="nama" class="w-full border border-gray-300 rounded px-4 py-2" value="{{ $dosen->nama }}" required>
    </div>
    <div>
        <label for="email" class="block font-medium">Email</label>
        <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded px-4 py-2" value="{{ $dosen->email }}" required>
    </div>
    <div>
        <label for="nip" class="block font-medium">NIP</label>
        <input type="text" id="nip" name="nip" class="w-full border border-gray-300 rounded px-4 py-2" value="{{ $dosen->nip }}" required>
    </div>
    <div>
        <label for="nidn" class="block font-medium">NIDN</label>
        <input type="text" id="nidn" name="nidn" class="w-full border border-gray-300 rounded px-4 py-2" value="{{ $dosen->nidn }}" required>
    </div>
    <div>
        <label for="jenis_kelamin" class="block font-medium">Jenis Kelamin</label>
        <select id="jenis_kelamin" name="jenis_kelamin" class="w-full border border-gray-300 rounded px-4 py-2" required>
            <option value="Laki-laki" {{ $dosen->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ $dosen->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div>
    <div>
        <label for="foto" class="block font-medium">Foto</label>
        <input type="file" id="foto" name="foto" class="w-full border border-gray-300 rounded px-4 py-2">
        @if ($dosen->foto)
            <img src="{{ asset('storage/' . $dosen->foto) }}" alt="Foto Dosen" class="w-16 h-16 mt-2">
        @endif
    </div>
    <div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Perubahan</button>
        <a href="{{ route('dosen.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
    </div>
</form>
@endsection
