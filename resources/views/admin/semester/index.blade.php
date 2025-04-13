@extends('layout.admin')

@section('title', 'Data Semester')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Semester</h2>

    <a href="{{ route('semester.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Pendanaan</a>

    <table class="min-w-full table-auto">
        <thead>
            <tr>
                <th class="border px-4 py-2 text-left">No</th>
                <th class="border px-4 py-2 text-left">Semester</th>
                <th class="border px-4 py-2 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($semesters as $semester)
                <tr>
                    <td class="border px-4 py-2">{{ $semester->id }}</td>
                    <td class="border px-4 py-2">{{ $semester->nama }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('semester.edit', $semester->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</a>
                        <form action="{{ route('semester.destroy', $semester->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
