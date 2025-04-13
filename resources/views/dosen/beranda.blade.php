@extends('layout.dosen')

@section('title', 'Dashboard Dosen')

@section('breadcrumbs')
<div class="w-full px-2">
    <h2 class="text-2xl font-bold">Selamat Datang, {{ $dosen->nama }}</h2>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 px-4 py-6">
    <!-- Card for Total Users -->
    <div class="bg-white shadow-md rounded-lg p-4">
        <h3 class="text-xl font-semibold text-gray-700">Total Penelitian</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $tpenelitian }}</p>
    </div>

    <!-- Card for Total Jurnals -->
    <div class="bg-white shadow-md rounded-lg p-4">
        <h3 class="text-xl font-semibold text-gray-700">Total Pengabdian</h3>
        <p class="text-3xl font-bold text-green-600">{{ $tpengabdian }}</p>
    </div>

    <!-- Card for Today's Activities -->
    <div class="bg-white shadow-md rounded-lg p-4">
        <h3 class="text-xl font-semibold text-gray-700">Total Mitra</h3>
        <p class="text-3xl font-bold text-red-600">{{ $tmitra }}</p>
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
            const labels = @json($years);
            const dataPenelitian = @json($dataPenelitian);
            const dataPengabdian = @json($dataPengabdian);
            const chartColors = ['#9333ea', '#6366f1', '#a855f7'];

            function createDataset(dataObject) {
                return Object.keys(dataObject).map((key, index) => ({
                    label: key,
                    data: Object.values(dataObject[key]),
                    borderColor: chartColors[index % chartColors.length],
                    backgroundColor: chartColors[index % chartColors.length] + '80',
                    borderWidth: 2,
                }));
            }

            new Chart(document.getElementById('penelitianChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: createDataset(dataPenelitian)
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' }
                    }
                }
            });

            new Chart(document.getElementById('pengabdianChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: createDataset(dataPengabdian)
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' }
                    }
                }
            });
        });
</script>
@endsection
