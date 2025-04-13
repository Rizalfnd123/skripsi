@extends('layout.admin')

@section('title', 'Dashboard Admin')

@section('breadcrumbs')
<div class="w-full px-2">
    <h2 class="text-2xl font-bold">Welcome, {{ Auth::user()->name }}</h2>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 px-4 py-6">
    <!-- Card for Total Users -->
    <div class="bg-white shadow-md rounded-lg p-4">
        <h3 class="text-xl font-semibold text-gray-700">Total Penelitian</h3>
        {{-- <p class="text-3xl font-bold text-blue-600">{{ $totalUsers }}</p> --}}
    </div>

    <!-- Card for Total Jurnals -->
    <div class="bg-white shadow-md rounded-lg p-4">
        <h3 class="text-xl font-semibold text-gray-700">Total Pengabdian</h3>
        {{-- <p class="text-3xl font-bold text-green-600">{{ $totalJurnals }}</p> --}}
    </div>

    <!-- Card for Today's Activities -->
    <div class="bg-white shadow-md rounded-lg p-4">
        <h3 class="text-xl font-semibold text-gray-700">Total Mitra</h3>
        {{-- <p class="text-3xl font-bold text-red-600">{{ $todaysActivities }}</p> --}}
    </div>
</div>

<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h3 class="text-2xl md:text-3xl font-bold text-center mb-10">
            Statistik Penelitian dan Pengabdian Selama Setahun
        </h3>

        <div class="grid md:grid-cols-2 gap-6">
            <!-- Card Grafik Penelitian -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h4 class="text-xl font-semibold text-center mb-4">Penelitian</h4>
                <div class="w-full max-w-md mx-auto">
                    <canvas id="penelitianChart"></canvas>
                </div>
            </div>

            <!-- Card Grafik Pengabdian -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h4 class="text-xl font-semibold text-center mb-4">Pengabdian</h4>
                <div class="w-full max-w-md mx-auto">
                    <canvas id="pengabdianChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</section> 
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        // Data dari Controller (Convert ke JSON)
        const dataPenelitian = @json($dataPenelitian);
        const dataPengabdian = @json($dataPengabdian);
        const roadmapLabels = @json($roadmapLabels);

        const chartColors = ['#ff6384', '#36a2eb', '#ffce56']; // Warna dataset

        function createDataset(dataObject) {
            return Object.keys(dataObject).map((roadmap, index) => ({
                label: roadmap,
                data: dataObject[roadmap],
                borderColor: chartColors[index % chartColors.length],
                backgroundColor: Chart.helpers.color(chartColors[index % chartColors.length]).alpha(
                    0.5).rgbString(),
                borderWidth: 2,
                borderRadius: 5,
                borderSkipped: false,
            }));
        }

        // Inisialisasi Chart.js
        const penelitianCtx = document.getElementById('penelitianChart').getContext('2d');
        const pengabdianCtx = document.getElementById('pengabdianChart').getContext('2d');

        new Chart(penelitianCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: createDataset(dataPenelitian)
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Statistik Penelitian Berdasarkan Roadmap'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1, // Langkah skala 1
                        ticks: {
                            precision: 0 // Angka bulat saja (tanpa desimal)
                        }
                    }
                }
            }
        });

        new Chart(pengabdianCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: createDataset(dataPengabdian)
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Statistik Pengabdian Berdasarkan Roadmap'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1, // Langkah skala 1
                        ticks: {
                            precision: 0 // Angka bulat saja (tanpa desimal)
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
