@extends('layout.landing')

@section('content')
<div class="container mx-auto mt-6">
    <h2 class="text-2xl font-bold mb-4">Daftar Penelitian</h2>
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
            @foreach($penelitians as $penelitian)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $penelitian->judul }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $penelitian->tanggal }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $penelitian->tingkat->jenis_tingkat ?? '-' }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $penelitian->roadmap->jenis_roadmap ?? '-' }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $penelitian->ketuaDosen->nama ?? '-' }}</td>
                    <td class="border border-gray-300 px-4 py-2">Rp {{ number_format($penelitian->dana, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
