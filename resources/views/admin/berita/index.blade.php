    @extends('layout.admin')

@section('title', 'Daftar Berita')

@section('content')
<h2 class="text-2xl font-bold mb-4">Daftar Berita</h2>

<a href="{{ route('berita.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Berita</a>

@if (session('success'))
    <div class="bg-green-100 text-green-800 p-4 mb-4 rounded">
        {{ session('success') }}
    </div>
@endif

<table class="w-full border border-gray-300">
    <thead>
        <tr>
            <th class="border px-4 py-2">Tanggal</th>
            <th class="border px-4 py-2">Foto</th>
            <th class="border px-4 py-2">Judul</th>
            <th class="border px-4 py-2">Keterangan</th>
            <th class="border px-4 py-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($berita as $item)
        <tr>
            <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
            <td class="border px-4 py-2">
                <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Berita" class="w-16 h-16">
            </td>
            <td class="border px-4 py-2">{{ $item->judul }}</td>
            <td class="border px-4 py-2">{{ $item->keterangan }}</td>
            <td class="border px-4 py-2">
                <a href="{{ route('berita.edit', $item->id_berita) }}" class="text-blue-500">Edit</a> |
                <form action="{{ route('berita.destroy', $item->id_berita) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $berita->links() }}
@endsection
