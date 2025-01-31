@extends('layout.admin')

@section('title', 'Data Tingkat')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Pendanaan</h2>

    <a href="{{ route('tingkat.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Pendanaan</a>

    <table class="min-w-full table-auto">
        <thead>
            <tr>
                <th class="border px-4 py-2 text-left">ID</th>
                <th class="border px-4 py-2 text-left">Jenis Pendanaan</th>
                <th class="border px-4 py-2 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tingkats as $tingkat)
                <tr>
                    <td class="border px-4 py-2">{{ $tingkat->id_tingkat }}</td>
                    <td class="border px-4 py-2">{{ $tingkat->jenis_tingkat }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('tingkat.edit', $tingkat->id_tingkat) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</a>
                        <form action="{{ route('tingkat.destroy', $tingkat->id_tingkat) }}" method="POST" style="display:inline;">
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
