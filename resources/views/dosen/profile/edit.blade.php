@extends('layout.dosen')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow mt-6">
    <h2 class="text-2xl font-bold mb-4">Edit Profil</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update.dosen') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label for="nama" class="block font-medium">Nama</label>
            <input type="text" name="nama" value="{{ old('nama', $dosen->nama) }}" required
                   class="w-full border border-gray-300 p-2 rounded">
        </div>

        <div>
            <label for="email" class="block font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $dosen->email) }}" required
                   class="w-full border border-gray-300 p-2 rounded">
        </div>

        <div>
            <label for="nip" class="block font-medium">NIP</label>
            <input type="text" name="nip" value="{{ old('nip', $dosen->nip) }}"
                   class="w-full border border-gray-300 p-2 rounded">
        </div>

        <div>
            <label for="nidn" class="block font-medium">NIDN</label>
            <input type="text" name="nidn" value="{{ old('nidn', $dosen->nidn) }}"
                   class="w-full border border-gray-300 p-2 rounded">
        </div>

        <div>
            <label for="jenis_kelamin" class="block font-medium">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="w-full border border-gray-300 p-2 rounded">
                <option value="">-- Pilih --</option>
                <option value="L" {{ $dosen->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ $dosen->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div>
            <label for="foto" class="block font-medium">Foto Profil</label>
            @if($dosen->foto)
                <img src="{{ asset('storage/' . $dosen->foto) }}" class="h-24 mb-2 rounded">
            @endif
            <input type="file" name="foto" class="w-full border border-gray-300 p-2 rounded">
        </div>

        <div>
            <button type="submit"
                    class="bg-purple-700 text-white px-4 py-2 rounded hover:bg-purple-800 transition">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
