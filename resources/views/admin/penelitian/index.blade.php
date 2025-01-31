@extends('layout.admin')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Daftar Penelitian</h1>
    <a href="{{ route('penelitian.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Penelitian</a>
    <table class="min-w-full bg-white border rounded">
        <thead>
            <tr class="border-b">
                <th class="py-2 px-4">No</th>
                <th class="py-2 px-4">Judul</th>
                <th class="py-2 px-4">Roadmap</th>
                <th class="py-2 px-4">Pendanaan</th>
                <th class="py-2 px-4">Ketua</th>
                <th class="py-2 px-4">Anggota Dosen</th>
                <th class="py-2 px-4">Anggota Mahasiswa</th>
                <th class="py-2 px-4">Tindakan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penelitian as $item)
            <tr class="border-b">
                <td class="py-2 px-4">{{ $loop->iteration }}</td>
                <td class="py-2 px-4">{{ $item->judul }}</td>
                <td class="py-2 px-4">{{ $item->tingkat->jenis_tingkat }}</td>
                <td class="py-2 px-4">{{ $item->roadmap->jenis_roadmap }}</td>
                <td class="py-2 px-4">{{ $item->ketuaDosen->nama ?? '-' }}</td>
                <td class="py-2 px-4">
                    @if ($item->anggotaPenelitian->where('anggota_type', 'Dosen')->isNotEmpty())
                        @foreach ($item->anggotaPenelitian->where('anggota_type', 'Dosen') as $anggota)
                            <div>{{ $anggota->dosen->nama ?? 'Nama Tidak Ditemukan' }} 
                                <span class="text-gray-500">({{ $anggota->dosen->nip ?? '-' }})</span>
                            </div>
                        @endforeach
                    @else
                        <div class="text-gray-500">Tidak ada dosen</div>
                    @endif
                </td>
                
                <td class="py-2 px-4">
                    @if ($item->anggotaPenelitian->where('anggota_type', 'Mahasiswa')->isNotEmpty())
                        @foreach ($item->anggotaPenelitian->where('anggota_type', 'Mahasiswa') as $anggota)
                            <div>{{ $anggota->mahasiswa->nama ?? 'Nama Tidak Ditemukan' }} 
                                <span class="text-gray-500">({{ $anggota->mahasiswa->nim ?? '-' }})</span>
                            </div>
                        @endforeach
                    @else
                        <div class="text-gray-500">Tidak ada mahasiswa</div>
                    @endif
                </td>
                                        
                <td class="py-2 px-4">
                    <a href="{{ route('penelitian.edit', $item->id) }}" class="text-blue-500">Edit</a> |
                    <form action="{{ route('penelitian.destroy', $item->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500" onclick="return confirm('Hapus penelitian ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>    
</div>
@endsection
