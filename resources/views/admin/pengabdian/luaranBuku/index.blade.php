@extends('layout.admin')

@section('content')
    <div class="container mx-auto px-4">
        {{-- Judul --}}
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Luaran Buku ber-ISBN Pengabdian</h1>

        {{-- Tombol Tambah + Filter Tahun --}}
        <div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
            {{-- Tombol Tambah --}}
            <a href="{{ route('luaran.pengabdian.buku.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition">
                + Tambah Buku
            </a>

            {{-- Form Filter Tahun --}}
            <form method="GET" action="{{ route('luaran.pengabdian.buku') }}">
                <div class="flex items-center gap-2">
                    <label for="tahun" class="font-semibold text-gray-700">Filter Tahun:</label>
                    <select name="tahun" id="tahun" onchange="this.form.submit()"
                        class="border px-3 py-2 rounded shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">-- Semua Tahun --</option>
                        @foreach ($tahunList as $t)
                            <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        {{-- Loop Per Roadmap --}}
        <div class="bg-white p-4 shadow rounded-lg mb-6">
            {{-- ========== ROADMAP 1 ========== --}}
            <h2 class="text-xl font-semibold mt-6 mb-2">Pembelajaran Domain TIK</h2>
            @include('admin.pengabdian.luaranBuku._table', ['luarans' => $luaranRoadmap1])

            {{-- ========== ROADMAP 2 ========== --}}
            <h2 class="text-xl font-semibold mt-6 mb-2">Pembelajaran Berbantuan TIK</h2>
            @include('admin.pengabdian.luaranBuku._table', ['luarans' => $luaranRoadmap2])

            {{-- ========== ROADMAP 3 ========== --}}
            <h2 class="text-xl font-semibold mt-6 mb-2">Informatika Terapan</h2>
            @include('admin.pengabdian.luaranBuku._table', ['luarans' => $luaranRoadmap3])
        </div>
    </div>
{{-- Statistik Diagram Buku --}}
<div class="max-w-6xl mx-auto px-4">
    <div class="bg-gray-900 text-white p-6 shadow-lg rounded-lg mt-10">
        <h2 class="text-2xl font-bold mb-6 text-center">
            Statistik Buku ber-ISBN per Roadmap @if(request('tahun')) ({{ request('tahun') }}) @endif
        </h2>
        <div class="flex flex-col md:flex-row gap-8 justify-center items-center">
            <div class="w-full md:w-1/2">
                <h3 class="text-center text-lg font-semibold mb-2">Diagram Doughnut</h3>
                <canvas id="bukuDoughnutChart" height="300"></canvas>
            </div>
            <div class="w-full md:w-1/2">
                <h3 class="text-center text-lg font-semibold mb-2">Diagram Bar Horizontal</h3>
                <canvas id="bukuBarChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const bukuData = @json($statistikRoadmap);
    const labels = Object.keys(bukuData);
    const dataValues = Object.values(bukuData);
    const colors = ['#6366F1', '#F97316', '#10B981'];

    // Doughnut Chart
    new Chart(document.getElementById('bukuDoughnutChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Buku',
                data: dataValues,
                backgroundColor: colors,
                borderColor: '#1F2937',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: { color: 'white' }
                },
                tooltip: {
                    callbacks: {
                        label: ctx => `${ctx.label}: ${ctx.raw} Buku`
                    }
                }
            }
        }
    });

    // Bar Chart Horizontal
    new Chart(document.getElementById('bukuBarChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Buku',
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
                        label: ctx => `${ctx.label}: ${ctx.raw} Buku`
                    }
                }
            }
        }
    });
</script>

@endsection
