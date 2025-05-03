@extends('layout.dosen')

@section('content')
    <div class="container mx-auto px-4 bg-purple-50 min-h-screen py-6">
        {{-- Judul --}}
        <h1 class="text-3xl font-bold text-purple-800 mb-6 text-center">Daftar Penelitian</h1>

        {{-- Baris Filter dan Tombol --}}
        <div class="flex justify-between items-center mb-4 bg-purple-100 p-4 shadow rounded-lg">
            {{-- Tombol Tambah --}}
            <a href="{{ route('penelitian-dosen.create') }}"
                class="bg-purple-500 text-white px-4 py-2 rounded shadow hover:bg-purple-600 transition">
                + Tambah Penelitian
            </a>

            {{-- Filter Tahun --}}
            <div class="flex items-center gap-2">
                <form method="GET" action="{{ route('penelitian-dosen.index') }}">
                    <label for="tahun" class="font-semibold text-purple-800">Filter Tahun:</label>
                    <select name="tahun" id="tahun" onchange="this.form.submit()"
                        class="border px-3 py-2 rounded shadow-sm focus:ring focus:ring-purple-300">
                        <option value="">-- Semua Tahun --</option>
                        @foreach ($tahunList as $th)
                            <option value="{{ $th }}" {{ request('tahun') == $th ? 'selected' : '' }}>{{ $th }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        {{-- Tombol Export --}}
        <div class="flex justify-end mb-4">
            <a href="{{ route('rekap.export-pdf.dosen', ['semester' => request('semester')]) }}"
                class="bg-red-500 text-white px-4 py-2 rounded shadow hover:bg-red-600 transition">
                Export PDF
            </a>
        </div>

        {{-- Loop Roadmap --}}
        @foreach ($roadmap as $rm)
            <div class="my-8">
                <h2 class="text-2xl font-bold text-purple-700 mb-4">{{ $rm->jenis_roadmap }}</h2>

                @if ($penelitiansPerRoadmap[$rm->id]->count())
                    <div class="overflow-x-auto bg-white shadow rounded-lg border border-purple-200">
                        <table class="w-full table-auto">
                            <thead class="bg-purple-200 text-purple-800">
                                <tr>
                                    <th class="py-3 px-4 border">No</th>
                                    <th class="py-3 px-4 border">Judul Penelitian</th>
                                    <th class="py-3 px-4 border">Ketua Tim</th>
                                    <th class="py-3 px-4 border">Kepakaran Ketua</th>
                                    <th class="py-3 px-4 border">Anggota Dosen</th>
                                    <th class="py-3 px-4 border">Mahasiswa Terlibat</th>
                                    <th class="py-3 px-4 border">Tahun</th>
                                    <th class="py-3 px-4 border text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($penelitiansPerRoadmap[$rm->id] as $penelitian)
                                    <tr class="hover:bg-purple-50 transition">
                                        <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2">{{ $penelitian->judul }}</td>
                                        <td class="px-4 py-2">{{ $penelitian->ketuaDosen->nama ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $penelitian->keahlian_ketua }}</td>
                                        <td class="px-4 py-2">
                                            @foreach ($penelitian->anggotaPenelitian->where('anggota_type', 'Dosen') as $anggota)
                                                <div>{{ $anggota->dosen->nama ?? '-' }}
                                                    <span class="text-gray-500">({{ $anggota->dosen->nip ?? '-' }})</span>
                                                </div>
                                            @endforeach
                                        </td>
                                        <td class="px-4 py-2">
                                            @foreach ($penelitian->anggotaPenelitian->where('anggota_type', 'Mahasiswa') as $anggota)
                                                <div>{{ $anggota->mahasiswa->nama ?? '-' }}
                                                    <span class="text-gray-500">({{ $anggota->mahasiswa->nim ?? '-' }})</span>
                                                </div>
                                            @endforeach
                                        </td>
                                        <td class="px-4 py-2 text-center">{{ \Carbon\Carbon::parse($penelitian->tanggal)->format('Y') }}</td>
                                        <td class="px-4 py-2 text-center">
                                            <a href="{{ route('penelitian-dosen.edit', $penelitian->id) }}"
                                                class="text-purple-600 hover:text-purple-800 transition">Edit</a>
                                            |
                                            <form action="{{ route('penelitian-dosen.destroy', $penelitian->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-500 hover:text-red-700 transition"
                                                    onclick="return confirm('Hapus penelitian ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $penelitiansPerRoadmap[$rm->id]->links('pagination::tailwind') }}
                    </div>
                @else
                    <p class="text-gray-500 italic mt-4">Tidak ada penelitian untuk roadmap ini.</p>
                @endif
            </div>
        @endforeach
        {{-- Diagram Statistik --}}
<div class="mt-12">
    <h2 class="text-2xl font-bold text-purple-700 text-center mb-4">Statistik Penelitian per Grup Riset</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Bar Chart --}}
        <div class="bg-purple-100 p-4 rounded-lg shadow">
            <h3 class="text-center text-lg font-semibold text-purple-800 mb-2">Jumlah Penelitian </h3>
            <canvas id="barChart"></canvas>
        </div>

        {{-- Pie Chart --}}
        <div class="bg-purple-100 p-4 rounded-lg shadow">
            <h3 class="text-center text-lg font-semibold text-purple-800 mb-2">Proporsi Penelitian </h3>
            <canvas id="pieChart"></canvas>
        </div>
    </div>
</div>

{{-- Script Chart.js --}}
<script>
    const labels = {!! json_encode($chartData['labels']) !!};
    const data = {!! json_encode($chartData['jumlahPenelitian']) !!};

    const barChart = new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Penelitian',
                data: data,
                backgroundColor: 'rgba(168, 85, 247, 0.5)', // ungu muda
                borderColor: 'rgba(126, 34, 206, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    const pieChart = new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
        labels: labels,
        datasets: [{
            label: 'Jumlah Penelitian',
            data: data,
            backgroundColor: labels.map((_, i) =>
                `hsl(${(i * 60) % 360}, 70%, 80%)`
            )
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' },
            datalabels: {
                formatter: (value, ctx) => {
                    const dataArr = ctx.chart.data.datasets[0].data;
                    const total = dataArr.reduce((a, b) => a + b, 0);
                    const percentage = total ? (value / total * 100).toFixed(1) : 0;
                    return `${percentage}%`;
                },
                color: '#000',
                font: {
                    weight: 'bold'
                }
            }
        }
    },
    plugins: [ChartDataLabels] // aktifkan plugin
});
</script>
    </div>
@endsection
