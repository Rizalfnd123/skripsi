@extends('layout.admin')

@section('title', 'Dashboard Admin')

@section('breadcrumbs')
<div class="w-full px-2">
    <h2 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}</h2>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-4 py-6">
    <!-- Total Penelitian -->
    <div class="bg-gradient-to-r from-blue-100 to-blue-200 shadow-md rounded-xl p-6 flex items-center space-x-4">
        <div class="bg-blue-500 text-white p-3 rounded-full">
            <i class="fas fa-flask text-xl"></i>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Total Penelitian</h3>
            <p class="text-2xl font-bold text-blue-700">{{ $penelitian ?? '0' }}</p>
        </div>
    </div>

    <!-- Total Pengabdian -->
    <div class="bg-gradient-to-r from-green-100 to-green-200 shadow-md rounded-xl p-6 flex items-center space-x-4">
        <div class="bg-green-500 text-white p-3 rounded-full">
            <i class="fas fa-hand-holding-heart text-xl"></i>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Total Pengabdian</h3>
            <p class="text-2xl font-bold text-green-700">{{ $pengabdian ?? '0' }}</p>
        </div>
    </div>

    <!-- Total Mitra -->
    <div class="bg-gradient-to-r from-pink-100 to-pink-200 shadow-md rounded-xl p-6 flex items-center space-x-4">
        <div class="bg-pink-500 text-white p-3 rounded-full">
            <i class="fas fa-users text-xl"></i>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Total Mitra</h3>
            <p class="text-2xl font-bold text-pink-700">{{ $mitra ?? '0' }}</p>
        </div>
    </div>
</div>




<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h3 class="text-2xl md:text-3xl font-bold text-center mb-10 text-gray-800">
            Statistik Penelitian dan Pengabdian <span class="text-blue-500">Tahun {{ $selectedYear }}</span>
        </h3>

        <!-- Filter Tahun -->
        <form method="GET" class="text-center mb-8">
            <label for="tahun" class="mr-2 font-semibold text-gray-700">Pilih Tahun:</label>
            <select name="tahun" id="tahun" onchange="this.form.submit()" class="border border-gray-300 px-4 py-2 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                @foreach ($tahunList as $tahun)
                    <option value="{{ $tahun }}" {{ (int)request('tahun', $selectedYear) === (int)$tahun ? 'selected' : '' }}>
                        {{ $tahun }}
                    </option>
                @endforeach
            </select>
        </form>

        <!-- Chart -->
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Pie Chart Penelitian -->
            <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition-shadow duration-300">
                <h4 class="text-xl font-semibold text-center mb-4 text-blue-700">Persentase Roadmap Penelitian</h4>
                <div class="w-full max-w-sm mx-auto">
                    <canvas id="piePenelitian"></canvas>
                </div>
            </div>

            <!-- Pie Chart Pengabdian -->
            <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition-shadow duration-300">
                <h4 class="text-xl font-semibold text-center mb-4 text-green-700">Persentase Roadmap Pengabdian</h4>
                <div class="w-full max-w-sm mx-auto">
                    <canvas id="piePengabdian"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
<script>
    // Tambahkan efek fade-in ketika halaman load
    document.addEventListener("DOMContentLoaded", () => {
        const cards = document.querySelectorAll(".rounded-xl");
        cards.forEach((card, i) => {
            card.style.opacity = 0;
            card.style.transform = "translateY(30px)";
            setTimeout(() => {
                card.style.transition = "all 0.5s ease-out";
                card.style.opacity = 1;
                card.style.transform = "translateY(0)";
            }, i * 150);
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dataPenelitian = @json($dataPenelitian);
        const dataPengabdian = @json($dataPengabdian);
        const roadmapLabels = @json($roadmapLabels);

        const cerahColors = [
    '#FF6384', // pink cerah
    '#36A2EB', // biru muda
    '#FFCE56', // kuning
    '#4BC0C0', // hijau tosca
    '#FF9F40', // oranye
    '#9966FF', // ungu terang
    '#66FF66', // hijau cerah
    '#FF66B2', // pink pastel
    '#66CCFF', // biru langit
    '#FFB266'  // peach
];

function generatePieChart(ctxId, labels, dataSet, titleText) {
    const total = dataSet.reduce((a, b) => a + b, 0);

    new Chart(document.getElementById(ctxId), {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: dataSet,
                backgroundColor: cerahColors,
                hoverOffset: 10,
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#333',
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                title: {
                    display: true,
                    text: titleText,
                    color: '#333',
                    font: {
                        size: 18,
                        weight: 'bold'
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            const value = tooltipItem.raw;
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${tooltipItem.label}: ${value} (${percentage}%)`;
                        }
                    }
                },
                datalabels: {
                    color: '#000',
                    formatter: function (value, context) {
                        const percentage = ((value / total) * 100).toFixed(1);
                        return `${value} (${percentage}%)`;
                    },
                    font: {
                        weight: 'bold',
                        size: 18
                    },
                    anchor: 'center',
                    align: 'center',
                    offset: 10
                }
            }
        },
        plugins: [ChartDataLabels]
    });
}



// Contoh penggunaan:
generatePieChart('piePenelitian', @json(array_keys($totalPenelitianPerRoadmap)), @json(array_values($totalPenelitianPerRoadmap)));
generatePieChart('piePengabdian', @json(array_keys($totalPengabdianPerRoadmap)), @json(array_values($totalPengabdianPerRoadmap)));

    });
</script>

@endsection
