@extends('layout.admin')

@section('title', 'Data Roadmap')

@section('breadcrumbs')
<div class="w-full px-2">
    <h2 class="text-2xl font-bold">Data Roadmap</h2>
</div>
@endsection

@section('content')
<div class="flex justify-between items-center mb-4">
    <a href="{{ route('roadmap.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Roadmap</a>
</div>

<table class="w-full border-collapse border border-gray-300">
    <thead>
        <tr>
            <th class="border border-gray-300 px-4 py-2">No</th>
            <th class="border border-gray-300 px-4 py-2">Jenis Roadmap</th>
            <th class="border border-gray-300 px-4 py-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($roadmaps as $roadmap)
        <tr>
            <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $roadmap->jenis_roadmap }}</td>
            <td class="border border-gray-300 px-4 py-2 flex space-x-2">
                <a href="{{ route('roadmap.edit', $roadmap->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                <form action="{{ route('roadmap.destroy', $roadmap->id) }}" method="POST">
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
