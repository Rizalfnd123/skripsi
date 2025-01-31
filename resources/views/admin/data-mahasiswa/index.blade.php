@extends('layout.admin')

@section('title', 'Data Mahasiswa')

@section('content')
<a href="{{ route('mahasiswa.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Mahasiswa</a>
<table class="border-collapse border border-gray-300 w-full mt-4">
    <thead>
        <tr>
            <th class="border border-gray-300 px-4 py-2">No</th>
            <th class="border border-gray-300 px-4 py-2">Nama</th>
            <th class="border border-gray-300 px-4 py-2">NIM</th>
            <th class="border border-gray-300 px-4 py-2">Jenis Kelamin</th>
            <th class="border border-gray-300 px-4 py-2">Angkatan</th>
            <th class="border border-gray-300 px-4 py-2">No HP</th>
            <th class="border border-gray-300 px-4 py-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($mahasiswa as $m)
            <tr>
                <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $m->nama }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $m->nim }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $m->jenis_kelamin }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $m->angkatan }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $m->no_hp }}</td>
                <td class="border border-gray-300 px-4 py-2 flex space-x-2">
                    <a href="{{ route('mahasiswa.edit', $m->id_mahasiswa) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                    <form action="{{ route('mahasiswa.destroy', $m->id_mahasiswa) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
