@extends('layout.dosen')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-purple-700 mb-6 text-center">Luaran Jurnal Penelitian</h1>

        <div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <a href="{{ route('luaran.penelitian.jurnal.create.dosen') }}"
                class="bg-purple-500 text-white px-4 py-2 rounded shadow hover:bg-purple-600 transition">
                + Tambah Jurnal
            </a>

            <form method="GET" action="{{ route('luaran.penelitian.jurnal.dosen') }}">
                <div class="flex items-center gap-2">
                    <label for="tahun" class="font-semibold text-purple-800">Filter Tahun:</label>
                    <select name="tahun" id="tahun" onchange="this.form.submit()"
                        class="border px-3 py-2 rounded shadow-sm focus:ring focus:ring-purple-300">
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

        <div class="bg-white p-6 shadow-lg rounded-lg mb-6">
            <h2 class="text-xl font-semibold mt-6 mb-2 text-purple-700">Pembelajaran Domain TIK</h2>
            @include('dosen.penelitian.luaranJurnal._table', ['luarans' => $luaranRoadmap1])

            <h2 class="text-xl font-semibold mt-6 mb-2 text-purple-700">Pembelajaran Berbantuan TIK</h2>
            @include('dosen.penelitian.luaranJurnal._table', ['luarans' => $luaranRoadmap2])

            <h2 class="text-xl font-semibold mt-6 mb-2 text-purple-700">Informatika Terapan</h2>
            @include('dosen.penelitian.luaranJurnal._table', ['luarans' => $luaranRoadmap3])
        </div>

        <div class="bg-gray-900 text-white p-6 shadow-lg rounded-lg mb-10 max-w-5xl mx-auto">
            <h2 class="text-xl font-semibold mb-6 text-center text-purple-300">
                Statistik Luaran Jurnal Per Roadmap (Tahun {{ request('tahun') ?? 'Semua' }})
            </h2>
            <div class="flex flex-col md:flex-row justify-center items-center gap-8">
                <div class="w-full md:w-1/2">
                    <h3 class="text-center font-semibold mb-2">Diagram Doughnut</h3>
                    <canvas id="roadmapDoughnutChart" width="250" height="250"></canvas>
                </div>

                <div class="w-full md:w-1/2">
                    <h3 class="text-center font-semibold mb-2">Diagram Bar Horizontal</h3>
                    <canvas id="roadmapBarChart" width="250" height="250"></canvas>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>   
        <script>
            const roadmapStats = @json($roadmapStats);
            const labels = Object.keys(roadmapStats);
            const dataValues = Object.values(roadmapStats);
            const total = dataValues.reduce((a, b) => a + b, 0);
            const colors = ['#D8B4FE', '#C084FC', '#A855F7'];

            Chart.defaults.color = '#fff';

            // Doughnut Chart
            new Chart(document.getElementById('roadmapDoughnutChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: dataValues,
                        backgroundColor: ['#c084fc', '#a78bfa', '#d8b4fe'], // ungu muda aesthetic
                        borderWidth: 2,
                        borderColor: '#1F2937',
                        hoverOffset: 10,
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '60%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#fff'
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1F2937',
                            titleColor: '#F9FAFB',
                            bodyColor: '#E5E7EB',
                            callbacks: {
                                label: ctx => `${ctx.label}: ${ctx.raw} jurnal`
                            }
                        },
                        datalabels: {
                            color: '#fff',
                            font: {
                                weight: 'bold',
                                size: 14
                            },
                            formatter: (value, context) => {
                                const data = context.chart.data.datasets[0].data;
                                const total = data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${percentage}%`;
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
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
                        legend: {
                            display: false
                        },
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
                            grid: {
                                color: '#4B5563'
                            },
                            ticks: {
                                color: '#E5E7EB'
                            }
                        },
                        y: {
                            grid: {
                                color: '#4B5563'
                            },
                            ticks: {
                                color: '#E5E7EB'
                            }
                        }
                    }
                }
            });
        </script>
    </div>
@endsection
