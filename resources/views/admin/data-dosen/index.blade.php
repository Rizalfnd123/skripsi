@extends('layout.admin')

@section('title', 'Data Dosen')

@section('content')
<a href="{{ route('dosen.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Dosen</a>
<table class="border-collapse border border-gray-300 w-full mt-4">
    <thead>
        <tr>
            <th class="border border-gray-300 px-4 py-2">No</th>
            <th class="border border-gray-300 px-4 py-2">Nama</th>
            <th class="border border-gray-300 px-4 py-2">Email</th>
            <th class="border border-gray-300 px-4 py-2">NIP</th>
            <th class="border border-gray-300 px-4 py-2">NIDN</th>
            <th class="border border-gray-300 px-4 py-2">Jenis Kelamin</th>
            <th class="border border-gray-300 px-4 py-2">Foto</th>
            <th class="border border-gray-300 px-4 py-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dosens as $dosen)
            <tr>
                <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $dosen->nama }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $dosen->email }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $dosen->nip }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $dosen->nidn }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $dosen->jenis_kelamin }}</td>
                <td class="border border-gray-300 px-4 py-2">
                    @if ($dosen->foto)
                        <img src="{{ asset('storage/' . $dosen->foto) }}" alt="Foto" class="w-24 h-24 rounded object-contain">
                    @endif
                </td>                                         
                <td class="border border-gray-300 px-4 py-2 flex space-x-2">
                    <a href="{{ route('dosen.edit', $dosen->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                    <form action="{{ route('dosen.destroy', $dosen->id) }}" method="POST">
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
