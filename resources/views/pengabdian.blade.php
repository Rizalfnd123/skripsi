@extends('layout.landing')

@section('content')
<div class="container mx-auto mt-6">
    <h2 class="text-2xl font-bold mb-4">Daftar Pengabdian</h2>
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-300 px-4 py-2">Judul</th>
                <th class="border border-gray-300 px-4 py-2">Tanggal</th>
                <th class="border border-gray-300 px-4 py-2">Tingkat</th>
                <th class="border border-gray-300 px-4 py-2">Roadmap</th>
                <th class="border border-gray-300 px-4 py-2">Ketua</th>
                <th class="border border-gray-300 px-4 py-2">Dana</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengabdians as $pengabdian)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $pengabdian->judul }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $pengabdian->tanggal }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $pengabdian->tingkat->jenis_tingkat ?? '-' }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $pengabdian->roadmap->jenis_roadmap ?? '-' }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $pengabdian->ketuaDosen->nama ?? '-' }}</td>
                    <td class="border border-gray-300 px-4 py-2">Rp {{ number_format($pengabdian->dana, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
