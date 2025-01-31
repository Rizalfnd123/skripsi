@extends('layout.admin')

@section('title', 'Data Mitra')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Data Mitra</h2>

    <a href="{{ route('mitra.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Mitra</a>

    <table class="min-w-full table-auto">
        <thead>
            <tr>
                <th class="border px-4 py-2 text-left">ID</th>
                <th class="border px-4 py-2 text-left">Nama</th>
                <th class="border px-4 py-2 text-left">No HP</th>
                <th class="border px-4 py-2 text-left">Username</th>
                <th class="border px-4 py-2 text-left">Status</th>
                <th class="border px-4 py-2 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mitras as $mitra)
                <tr>
                    <td class="border px-4 py-2">{{ $mitra->id_mitra }}</td>
                    <td class="border px-4 py-2">{{ $mitra->nama }}</td>
                    <td class="border px-4 py-2">{{ $mitra->no_hp }}</td>
                    <td class="border px-4 py-2">{{ $mitra->username }}</td>
                    <td class="border px-4 py-2">{{ $mitra->status }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('mitra.edit', $mitra->id_mitra) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</a>
                        <form action="{{ route('mitra.destroy', $mitra->id_mitra) }}" method="POST" style="display:inline;">
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
