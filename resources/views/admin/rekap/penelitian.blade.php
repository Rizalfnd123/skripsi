@extends('layout.admin')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Rekap Penelitian</h1>

        {{-- Filter Semester --}}
        <form method="GET" action="{{ route('rekapadmin.index') }}">
            <label for="semester">Pilih Semester:</label>
            <select name="semester" id="semester" onchange="this.form.submit()">
                <option value="">-- Semua Semester --</option>
                @foreach (\App\Models\Semester::all() as $semester)
                    <option value="{{ $semester->nama }}" {{ request('semester') == $semester->nama ? 'selected' : '' }}>
                        {{ $semester->nama }}
                    </option>
                @endforeach
            </select>
        </form>

        {{-- Tombol Export PDF dengan Semester yang Dipilih --}}
        <a href="{{ route('rekap.export-pdf', ['semester' => request('semester')]) }}"
            class="bg-red-500 text-white px-4 py-2 rounded mb-4 inline-block">
            Export PDF
        </a>

        <table class="min-w-full bg-white border rounded">
            <thead>
                <tr class="border-b">
                    <th class="py-2 px-4">No</th>
                    <th class="py-2 px-4">Judul Penelitian</th>
                    <th class="py-2 px-4">Nama Ketua Tim</th>
                    <th class="py-2 px-4">Kepakaran Ketua Tim</th>
                    <th class="py-2 px-4">Nama dan Identitas Dosen Anggota</th>
                    <th class="py-2 px-4">Nama dan Identitas Mahasiswa yang Dilibatkan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penelitian as $item)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $loop->iteration }}</td>
                        <td class="py-2 px-4">{{ $item->judul }}</td>
                        <td class="py-2 px-4">{{ $item->ketuaDosen->nama ?? '-' }}</td>
                        <td class="py-2 px-4">{{ $item->keahlian_ketua }}</td>
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
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
