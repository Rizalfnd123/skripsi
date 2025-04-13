@extends('layout.admin')

@section('title', 'Tambah Data Semester')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Tambah Data Semester</h2>

    <form action="{{ route('semester.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="nama" class="block font-medium">Semester</label>
            <input type="text" id="namar" name="nama" class="w-full border border-gray-300 rounded px-4 py-2" required>
        </div>

        <div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('semester.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
        </div>
    </form>
@endsection
