<!-- resources/views/landing.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPPMas</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Untuk menghindari konten tersembunyi di bawah fixed navbar */
        body {
            padding-top: 80px;
        }
    </style>
</head>

<body class="font-sans bg-gray-100">

    <!-- Navbar Sticking -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-gray-800 text-white shadow-md">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <div class="text-3xl font-bold">
                <a href="{{ url('/') }}" class="hover:text-yellow-400 transition-colors">SIPPMas</a>
            </div>
            <nav class="flex items-center space-x-6">
                <a href="{{ url('/daftar-penelitian') }}" class="hover:text-yellow-400 transition-colors">Penelitian</a>
                <a href="{{ url('/daftar-pengabdian') }}" class="hover:text-yellow-400 transition-colors">Pengabdian</a>
                <!-- Tombol Login yang dibedakan -->
                <a href="{{ url('/login') }}"
                    class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-semibold py-2 px-4 rounded-full transition-colors">
                    Login
                </a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative w-full h-screen bg-cover bg-center"
        style="background-image: url('{{ asset('assets/img/hero-bg.jpg') }}');">
        <div class="absolute inset-0 bg-black opacity-60"></div>
        <div
            class="relative container mx-auto h-full flex flex-col justify-center items-center text-center text-white px-4">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-4">Selamat Datang di SIPPMas</h1>
            <p class="text-xl md:text-2xl max-w-2xl">Sistem Informasi Penelitian dan Pengabdian Masyarakat yang
                memudahkan kolaborasi dan inovasi.</p>
        </div>
    </section>

    <!-- Welcome Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto text-center px-4">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Selamat Datang di Pusat Penelitian</h2>
            <p class="text-lg text-gray-700 max-w-2xl mx-auto">
                Kami menyediakan platform untuk mempermudah penelitian dan pengabdian masyarakat melalui inovasi digital
                dan kolaborasi.
            </p>
        </div>
    </section>

    <!-- Latest News Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h3 class="text-2xl md:text-3xl font-bold text-center mb-10">Berita Terbaru</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($beritas as $berita)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition-shadow">
                        <!-- Menampilkan foto dari storage/public/berita -->
                        <img src="{{ asset('storage/' . $berita->foto) }}" alt="{{ $berita->judul }}"
                            class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h4 class="font-bold text-xl mb-2">{{ $berita->judul }}</h4>
                            <p class="text-gray-600 text-sm mb-2">
                                Tanggal: {{ \Carbon\Carbon::parse($berita->tanggal)->format('d M Y') }}
                            </p>
                            <p class="text-gray-700 text-sm">
                                {{ Str::limit($berita->keterangan, 100) }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center">
                        <p class="text-gray-600">Belum ada berita terbaru.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- Grafik Data Penelitian & Pengabdian Selama Setahun -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h3 class="text-2xl md:text-3xl font-bold text-center mb-10">
                Statistik Penelitian dan Pengabdian Selama Setahun
            </h3>
            <div class="flex justify-center">
                <canvas id="researchChart" class="w-full md:w-2/3 lg:w-1/2"></canvas>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-6">
        <div class="container mx-auto text-center">
            <p>&copy; {{ date('Y') }} SIPPMas. All rights reserved.</p>
        </div>
    </footer>

</body>
<!-- Tambahkan Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById("researchChart").getContext("2d");
        
        const researchChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
                datasets: [
                    {
                        label: "Penelitian",
                        data: [5, 8, 6, 10, 7, 9, 4, 6, 8, 5, 7, 10],
                        backgroundColor: "rgba(75, 192, 192, 0.6)",
                        borderColor: "rgba(75, 192, 192, 1)",
                        borderWidth: 1
                    },
                    {
                        label: "Pengabdian",
                        data: [4, 6, 5, 8, 6, 7, 3, 5, 6, 4, 6, 8],
                        backgroundColor: "rgba(255, 99, 132, 0.6)",
                        borderColor: "rgba(255, 99, 132, 1)",
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

</html>
