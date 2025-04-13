<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPPMas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Navbar Transparan */
        .navbar {
            transition: background 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(88, 28, 135, 0.9); /* bg-purple-800 dengan transparansi */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
    </style>
</head>

<body class="font-sans bg-gray-100">

    <!-- Navbar -->
    <header id="navbar" class="navbar fixed top-0 left-0 right-0 z-50 bg-transparent text-white py-4 transition-all duration-300">
        <div class="container mx-auto flex justify-between items-center px-6">
            <div class="text-3xl font-bold">
                <a href="{{ url('/') }}" class="hover:text-purple-400 transition-colors">SIPPMas</a>
            </div>
            <nav class="flex items-center space-x-6">
                <a href="{{ url('/daftar-penelitian') }}" class="hover:text-purple-400 transition-colors">Penelitian</a>
                <a href="{{ url('/daftar-pengabdian') }}" class="hover:text-purple-400 transition-colors">Pengabdian</a>
                <a href="{{ url('/login') }}"
                    class="bg-purple-500 hover:bg-purple-600 text-white font-semibold py-2 px-4 rounded-full transition-all">
                    Login
                </a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative w-full h-screen flex items-center justify-center text-center text-white overflow-hidden">
        <!-- Video Background -->
        <video class="absolute top-0 left-0 w-full h-full object-cover" autoplay loop muted playsinline>
            <source src="{{ asset('videos/a.mp4') }}" type="video/mp4">
            Browser Anda tidak mendukung tag video.
        </video>

        <!-- Overlay Gelap -->
        <div class="absolute inset-0 bg-black opacity-50"></div>

        <!-- Konten Hero -->
        <div class="relative z-10 px-4">
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6">SIPPMas</h1>
            <p class="text-lg md:text-xl mb-6 max-w-2xl mx-auto">
                Meningkatkan inovasi penelitian dan pengabdian masyarakat dengan teknologi.
            </p>
            <a href="#tentang"
                class="bg-purple-500 hover:bg-purple-600 text-white font-semibold py-3 px-6 rounded-full text-lg transition-all">
                Pelajari Lebih Lanjut
            </a>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="py-20 bg-white">
        <div class="container mx-auto text-center px-6">
            <h2 class="text-4xl font-bold text-purple-700 mb-6">Tentang SIPPMas</h2>
            <p class="text-lg text-gray-700 max-w-2xl mx-auto">
                Platform inovatif untuk mempermudah penelitian dan pengabdian masyarakat dengan kolaborasi digital.
            </p>
        </div>
    </section>

    <!-- Latest News Section -->
    <section id="berita" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <h3 class="text-3xl font-bold text-center mb-10">Berita Terbaru</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse($beritas as $berita)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <img src="{{ asset('storage/' . $berita->foto) }}" alt="{{ $berita->judul }}"
                            class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h4 class="font-bold text-xl mb-2">{{ $berita->judul }}</h4>
                            <p class="text-gray-600 text-sm mb-2">
                                {{ \Carbon\Carbon::parse($berita->tanggal)->format('d M Y') }}</p>
                            <p class="text-gray-700 text-sm">{{ Str::limit($berita->keterangan, 100) }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 text-center w-full">Belum ada berita terbaru.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Statistik Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <h3 class="text-3xl font-bold text-center text-purple-700 mb-10">Statistik Penelitian & Pengabdian</h3>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h4 class="text-xl font-semibold text-center mb-4 text-purple-600">Penelitian</h4>
                    <div class="w-full max-w-md mx-auto">
                        <canvas id="penelitianChart"></canvas>
                    </div>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h4 class="text-xl font-semibold text-center mb-4 text-purple-600">Pengabdian</h4>
                    <div class="w-full max-w-md mx-auto">
                        <canvas id="pengabdianChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-purple-800 text-gray-300 py-6 text-center">
        <p>&copy; {{ date('Y') }} SIPPMas. All rights reserved.</p>
    </footer>

    <!-- Chart.js -->
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

    <!-- Navbar Scroll Effect -->
    <script>
        window.addEventListener("scroll", function () {
            const navbar = document.getElementById("navbar");
            if (window.scrollY > 50) {
                navbar.classList.add("bg-purple-800", "shadow-md");
                navbar.classList.remove("bg-transparent");
            } else {
                navbar.classList.add("bg-transparent");
                navbar.classList.remove("bg-purple-800", "shadow-md");
            }
        });
    </script>

</body>
</html>
