@extends('layout.admin')

@section('title', 'Tambah Data Tingkat')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Tambah Data Pendanaan</h2>

    <form action="{{ route('tingkat.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="jenis_tingkat" class="block font-medium">Jenis Pendanaan</label>
            <input type="text" id="jenis_tingkat" name="jenis_tingkat" class="w-full border border-gray-300 rounded px-4 py-2" required>
        </div>

        <div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('tingkat.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
        </div>
    </form>
@endsection
