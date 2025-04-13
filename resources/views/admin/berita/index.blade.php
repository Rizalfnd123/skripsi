@extends('layout.admin')

@section('title', 'Daftar Berita')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Daftar Berita</h2>

    <a href="{{ route('berita.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded shadow mb-6 inline-block">
        + Tambah Berita
    </a>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <table class="min-w-full border-collapse">
            <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                <tr>
                    <th class="px-4 py-3 border text-left">Tanggal</th>
                    <th class="px-4 py-3 border text-left">Foto</th>
                    <th class="px-4 py-3 border text-left">Judul</th>
                    <th class="px-4 py-3 border text-left">Keterangan</th>
                    <th class="px-4 py-3 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach ($berita as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="border px-4 py-3">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}</td>
                    <td class="border px-4 py-3">
                        <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Berita" class="w-16 h-16 rounded object-cover border">
                    </td>
                    <td class="border px-4 py-3 font-semibold">{{ $item->judul }}</td>
                    <td class="border px-4 py-3 truncate max-w-xs">{{ $item->keterangan }}</td>
                    <td class="border px-4 py-3 text-center">
                        <a href="{{ route('berita.edit', $item->id_berita) }}" class="text-blue-500 hover:text-blue-700">Edit</a> |
                        <form action="{{ route('berita.destroy', $item->id_berita) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $berita->links('pagination::tailwind') }}
    </div>
</div>
@endsection
