@extends('layout.admin')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Daftar Pengabdian</h1>
    <a href="{{ route('pengabdian.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Pengabdian</a>
    <table class="min-w-full bg-white border rounded">
        <thead>
            <tr class="border-b">
                <th class="py-2 px-4">No</th>
                <th class="py-2 px-4">Judul Peengabdian</th>
                <th class="py-2 px-4">Nama ketua Tim</th>
                <th class="py-2 px-4">Kepakaran Ketua Tim</th>
                <th class="py-2 px-4">Nama dan Identitas Dosen Anggota</th>
                <th class="py-2 px-4">Nama dan Identitas Mahasiswa yangdilibatkan</th>
                <th class="py-2 px-4">Tindakan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengabdian as $item)
            <tr class="border-b">
                <td class="py-2 px-4">{{ $loop->iteration }}</td>
                <td class="py-2 px-4">{{ $item->judul }}</td>
                <td class="py-2 px-4">{{ $item->ketuaDosen->nama ?? '-' }}</td>
                <td class="py-2 px-4">{{ $item->keahlian_ketua}}</td>
                <td class="py-2 px-4">
                    @if ($item->anggotaPengabdian->where('anggota_type', 'Dosen')->isNotEmpty())
                        @foreach ($item->anggotaPengabdian->where('anggota_type', 'Dosen') as $anggota)
                            <div>{{ $anggota->dosen->nama ?? 'Nama Tidak Ditemukan' }} 
                                <span class="text-gray-500">({{ $anggota->dosen->nip ?? '-' }})</span>
                            </div>
                        @endforeach
                    @else
                        <div class="text-gray-500">Tidak ada dosen</div>
                    @endif
                </td>
                
                <td class="py-2 px-4">
                    @if ($item->anggotaPengabdian->where('anggota_type', 'Mahasiswa')->isNotEmpty())
                        @foreach ($item->anggotaPengabdian->where('anggota_type', 'Mahasiswa') as $anggota)
                            <div>{{ $anggota->mahasiswa->nama ?? 'Nama Tidak Ditemukan' }} 
                                <span class="text-gray-500">({{ $anggota->mahasiswa->nim ?? '-' }})</span>
                            </div>
                        @endforeach
                    @else
                        <div class="text-gray-500">Tidak ada mahasiswa</div>
                    @endif
                </td>
                                        
                <td class="py-2 px-4">
                    <a href="{{ route('pengabdian.edit', $item->id) }}" class="text-blue-500">Edit</a> |
                    <form action="{{ route('pengabdian.destroy', $item->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500" onclick="return confirm('Hapus pengabdian ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>    
</div>
@endsection
