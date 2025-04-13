@extends('layout.admin')

@section('content')
<div class="container mx-auto px-4">
    {{-- Judul --}}
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Daftar Penelitian</h1>

    {{-- Baris Filter dan Tombol --}}
    <div class="flex justify-between items-center mb-4 bg-white p-4 shadow rounded-lg">
        {{-- Tombol Tambah --}}
        <a href="{{ route('penelitian.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition">
            + Tambah Penelitian
        </a>

        {{-- Filter Semester --}}
        <div class="flex items-center gap-2">
        <form method="GET" action="{{ route('penelitian.index') }}">
            <label for="semester" class="font-semibold">Filter Semester:</label>
            <select name="semester" id="semester" onchange="this.form.submit()" 
                class="border px-3 py-2 rounded shadow-sm focus:ring focus:ring-blue-300">
                <option value="">-- Semua Semester --</option>
                @foreach (\App\Models\Semester::all() as $semester)
                    <option value="{{ $semester->nama }}" {{ request('semester') == $semester->nama ? 'selected' : '' }}>
                        {{ $semester->nama }}
                    </option>
                @endforeach
            </select>
        </form>
        </div>
    </div>

    {{-- Tabel Penelitian --}}
    <div class="bg-white p-4 shadow rounded-lg">
        <div class=" mb-4 flex justify-end">
            <a href="{{ route('rekap.export-pdf', ['semester' => request('semester')]) }}"
                class="bg-red-500 text-white px-4 py-2 rounded shadow hover:bg-red-600 transition">
                Export PDF
            </a>
        </div>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="py-3 px-4 border">No</th>
                    <th class="py-3 px-4 border">Judul Penelitian</th>
                    <th class="py-3 px-4 border">Ketua Tim</th>
                    <th class="py-3 px-4 border">Kepakaran Ketua</th>
                    <th class="py-3 px-4 border">Anggota Dosen</th>
                    <th class="py-3 px-4 border">Mahasiswa Terlibat</th>
                    <th class="py-3 px-4 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penelitian as $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4 border text-center">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4 border">{{ $item->judul }}</td>
                        <td class="py-3 px-4 border">{{ $item->ketuaDosen->nama ?? '-' }}</td>
                        <td class="py-3 px-4 border">{{ $item->keahlian_ketua }}</td>
                        <td class="py-3 px-4 border">
                            @foreach ($item->anggotaPenelitian->where('anggota_type', 'Dosen') as $anggota)
                                <div>{{ $anggota->dosen->nama ?? '-' }} 
                                    <span class="text-gray-500">({{ $anggota->dosen->nip ?? '-' }})</span>
                                </div>
                            @endforeach
                        </td>
                        <td class="py-3 px-4 border">
                            @foreach ($item->anggotaPenelitian->where('anggota_type', 'Mahasiswa') as $anggota)
                                <div>{{ $anggota->mahasiswa->nama ?? '-' }} 
                                    <span class="text-gray-500">({{ $anggota->mahasiswa->nim ?? '-' }})</span>
                                </div>
                            @endforeach
                        </td>
                        <td class="py-3 px-4 border text-center">
                            <a href="{{ route('penelitian.edit', $item->id) }}" class="text-blue-500 hover:underline">Edit</a> |
                            <form action="{{ route('penelitian.destroy', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus penelitian ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
