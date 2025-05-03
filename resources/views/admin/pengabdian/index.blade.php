@extends('layout.admin')

@section('content')
    <div class="container mx-auto px-4">
        {{-- Judul --}}
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Daftar pengabdian</h1>

        {{-- Baris Filter dan Tombol --}}
        <div class="flex justify-between items-center mb-4 bg-white p-4 shadow rounded-lg">
            <a href="{{ route('pengabdian.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition">
                + Tambah pengabdian
            </a>

            {{-- Filter Tahun --}}
            <form method="GET" action="{{ route('pengabdian.index') }}">
                <label for="tahun" class="font-semibold">Filter Tahun:</label>
                <select name="tahun" id="tahun" onchange="this.form.submit()"
                    class="border px-3 py-2 rounded shadow-sm focus:ring focus:ring-blue-300">
                    <option value="">-- Semua Tahun --</option>
                    @foreach ($tahunList as $t)
                        <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>
                            {{ $t }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- Export PDF --}}
        <div class="bg-white p-4 shadow rounded-lg mb-6">
            <div class="mb-4 flex justify-end">
                <a href="{{ route('rekap2.export-pdf', ['tahun' => request('tahun')]) }}"
                    class="bg-red-500 text-white px-4 py-2 rounded shadow hover:bg-red-600 transition">
                    Export PDF
                </a>
            </div>

            {{-- Tabel Per Roadmap --}}
            @foreach ($roadmap as $rm)
                <h2 class="text-2xl font-bold text-gray-700 mt-8 mb-4">Roadmap: {{ $rm->jenis_roadmap }}</h2>

                @if (isset($pengabdiansPerRoadmap[$rm->id]) && $pengabdiansPerRoadmap[$rm->id]->count())
                    <table class="w-full border-collapse border border-gray-300 mb-6">
                        <thead>
                            <tr class="bg-gray-100 border-b">
                                <th class="py-3 px-4 border">No</th>
                                <th class="py-3 px-4 border">Judul pengabdian</th>
                                <th class="py-3 px-4 border">Ketua Tim</th>
                                <th class="py-3 px-4 border">Kepakaran Ketua</th>
                                <th class="py-3 px-4 border">Anggota Dosen</th>
                                <th class="py-3 px-4 border">Mahasiswa Terlibat</th>
                                <th class="py-3 px-4 border">Tahun</th>
                                <th class="py-3 px-4 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengabdiansPerRoadmap[$rm->id] as $item)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4 border text-center">{{ $loop->iteration }}</td>
                                    <td class="py-3 px-4 border">{{ $item->judul }}</td>
                                    <td class="py-3 px-4 border">{{ $item->ketuaDosen->nama ?? '-' }}</td>
                                    <td class="py-3 px-4 border">{{ $item->keahlian_ketua }}</td>
                                    <td class="py-3 px-4 border">
                                        @foreach ($item->anggotapengabdian->where('anggota_type', 'Dosen') as $anggota)
                                            <div>{{ $anggota->dosen->nama ?? '-' }}
                                                <span class="text-gray-500">({{ $anggota->dosen->nip ?? '-' }})</span>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td class="py-3 px-4 border">
                                        @foreach ($item->anggotapengabdian->where('anggota_type', 'Mahasiswa') as $anggota)
                                            <div>{{ $anggota->mahasiswa->nama ?? '-' }}
                                                <span class="text-gray-500">({{ $anggota->mahasiswa->nim ?? '-' }})</span>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td class="py-3 px-4 border text-center">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('Y') }}
                                    </td>
                                    <td class="py-3 px-4 border text-center">
                                        <a href="{{ route('pengabdian.edit', $item->id) }}"
                                            class="text-blue-500 hover:underline">Edit</a> |
                                        <form action="{{ route('pengabdian.destroy', $item->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline"
                                                onclick="return confirm('Hapus pengabdian ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Paginasi --}}
                    <div class="mb-8">
                        {{ $pengabdiansPerRoadmap[$rm->id]->appends(request()->except('page'))->links() }}
                    </div>
                @else
                    <p class="text-gray-500 italic">Tidak ada data pengabdian untuk roadmap ini.</p>
                @endif
            @endforeach
        </div>
        {{-- Statistik Diagram --}}
    <div class="bg-gray-900 text-white p-6 shadow-lg rounded-lg mb-10 max-w-5xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-center">
            Statistik pengabdian per Roadmap @if(request('tahun')) ({{ request('tahun') }}) @endif
        </h2>
        <div class="flex flex-col md:flex-row gap-8 justify-center items-center">
            <div class="w-full md:w-1/2">
                <h3 class="text-center text-lg font-semibold mb-2">Diagram Doughnut</h3>
                <canvas id="doughnutChart" height="300"></canvas>
            </div>
            <div class="w-full md:w-1/2">
                <h3 class="text-center text-lg font-semibold mb-2">Diagram Bar Horizontal</h3>
                <canvas id="barChart" height="300"></canvas>
            </div>
        </div>
    </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const roadmapData = @json($statistikRoadmap);

    const labels = Object.keys(roadmapData);
    const dataValues = Object.values(roadmapData);

    const colors = ['#60A5FA', '#34D399', '#FBBF24', '#F87171', '#A78BFA'];

    // Doughnut Chart
    new Chart(document.getElementById('doughnutChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah pengabdian',
                data: dataValues,
                backgroundColor: colors,
                borderColor: '#111827',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top', labels: { color: 'white' } },
                tooltip: {
                    callbacks: {
                        label: ctx => `${ctx.label}: ${ctx.raw} pengabdian`
                    }
                }
            }
        }
    });

    // Horizontal Bar Chart
    new Chart(document.getElementById('barChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah pengabdian',
                data: dataValues,
                backgroundColor: colors,
                borderRadius: 6
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            scales: {
                x: {
                    ticks: { color: 'white' },
                    grid: { color: '#374151' }
                },
                y: {
                    ticks: { color: 'white' },
                    grid: { color: '#374151' }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => `${ctx.label}: ${ctx.raw} pengabdian`
                    }
                }
            }
        }
    });
</script>

@endsection
