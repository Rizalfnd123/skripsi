@extends('layout.admin')

@section('title', 'Edit Data Semester')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Edit Data Semester</h2>

    <form action="{{ route('semester.update', $semester->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="nama" class="block font-medium">Jenis Pendanaan</label>
            <input type="text" id="nama" name="nama" value="{{ $semester->nama }}" class="w-full border border-gray-300 rounded px-4 py-2" required>
        </div>

        <div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            <a href="{{ route('semester.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
        </div>
    </form>
@endsection
