@extends('layout.admin')

@section('content')
    <div class="container mx-auto px-4">
        {{-- Judul --}}
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Luaran Jurnal Penelitian</h1>

        {{-- Tombol Tambah + Filter Tahun --}}
        <div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
            {{-- Tombol Tambah --}}
            <a href="{{ route('luaran.penelitian.jurnal.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition">
                + Tambah Jurnal
            </a>

            {{-- Form Filter Tahun --}}
            <form method="GET" action="{{ route('luaran.penelitian.jurnal') }}">
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
        <div class="bg-white p-6 shadow-lg rounded-lg mb-6">
            {{-- ========== ROADMAP 1 ========== --}}
            <h2 class="text-xl font-semibold mt-6 mb-2">Pembelajaran Domain TIK</h2>
            @include('admin.penelitian.luaranJurnal._table', ['luarans' => $luaranRoadmap1])

            {{-- ========== ROADMAP 2 ========== --}}
            <h2 class="text-xl font-semibold mt-6 mb-2">Pembelajaran Berbantuan TIK</h2>
            @include('admin.penelitian.luaranJurnal._table', ['luarans' => $luaranRoadmap2])

            {{-- ========== ROADMAP 3 ========== --}}
            <h2 class="text-xl font-semibold mt-6 mb-2">Informatika Terapan</h2>
            @include('admin.penelitian.luaranJurnal._table', ['luarans' => $luaranRoadmap3])
        </div>

        {{-- Statistik Diagram (Doughnut dan Bar Berdampingan + Dark Mode) --}}
<div class="bg-gray-900 text-white p-6 shadow-lg rounded-lg mb-10 max-w-5xl mx-auto">
    <h2 class="text-xl font-semibold mb-6 text-center">Statistik Luaran Jurnal Per Roadmap (Tahun {{ request('tahun') ?? 'Semua' }})</h2>
    <div class="flex flex-col md:flex-row justify-center items-center gap-8">
        {{-- Doughnut Chart --}}
        <div class="w-full md:w-1/2">
            <h3 class="text-center font-semibold mb-2">Diagram Doughnut</h3>
            <canvas id="roadmapDoughnutChart" width="250" height="250"></canvas>
        </div>

        {{-- Horizontal Bar Chart --}}
        <div class="w-full md:w-1/2">
            <h3 class="text-center font-semibold mb-2">Diagram Bar Horizontal</h3>
            <canvas id="roadmapBarChart" width="250" height="250"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const roadmapStats = @json($roadmapStats); // Data dari controller sudah per tahun
    const labels = Object.keys(roadmapStats);
    const dataValues = Object.values(roadmapStats);
    const colors = ['#60A5FA', '#34D399', '#FBBF24']; // Tailwind-like colors for modern vibe

    Chart.defaults.color = '#fff'; // Set default font color to white for dark mode

    // Doughnut Chart
    new Chart(document.getElementById('roadmapDoughnutChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: dataValues,
                backgroundColor: colors,
                borderWidth: 2,
                borderColor: '#1F2937', // Gray-800 for border
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: {
                legend: { position: 'bottom', labels: { color: '#fff' } },
                tooltip: {
                    backgroundColor: '#1F2937',
                    titleColor: '#F9FAFB',
                    bodyColor: '#E5E7EB',
                    callbacks: {
                        label: ctx => `${ctx.label}: ${ctx.raw} jurnal`
                    }
                }
            }
        }
    });

    // Horizontal Bar Chart
    new Chart(document.getElementById('roadmapBarChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Jurnal',
                data: dataValues,
                backgroundColor: colors,
                borderRadius: 8,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1F2937',
                    titleColor: '#F9FAFB',
                    bodyColor: '#E5E7EB',
                    callbacks: {
                        label: ctx => `${ctx.raw} jurnal`
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: { color: '#374151' },
                    ticks: { color: '#E5E7EB' }
                },
                y: {
                    grid: { color: '#374151' },
                    ticks: { color: '#E5E7EB' }
                }
            }
        }
    });
</script>
@endsection
