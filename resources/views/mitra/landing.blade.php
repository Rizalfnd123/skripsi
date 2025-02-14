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
            <!-- Logo -->
            <div class="text-3xl font-bold">
                <a href="{{ url('/mitra/dashboard') }}" class="hover:text-yellow-400 transition-colors">SIPPMas</a>
            </div>

            <!-- Navigasi -->
            <nav class="flex items-center space-x-6">
                <a href="{{ url('/list-penelitian') }}" class="hover:text-yellow-400 transition-colors">Penelitian</a>
                <a href="{{ url('/list-pengabdian') }}" class="hover:text-yellow-400 transition-colors">Pengabdian</a>
                <a href="{{ route('request.index') }}" class="hover:text-yellow-400 transition-colors">Request</a>


                <!-- Dropdown Profil -->
                <div class="relative">
                    <div class="flex items-center space-x-2">
                        @if (Auth::guard('mitra')->check())
                            <span class="text-white font-semibold">{{ Auth::guard('mitra')->user()->nama }}</span>
                        @else
                            <span class="text-white font-semibold">Guest</span>
                        @endif
                        <button id="userDropdownBtn"
                            class="focus:outline-none p-2 rounded-full border-2 border-yellow-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M12 2C13.933 2 15.5 3.567 15.5 5.5S13.933 9 12 9 8.5 7.433 8.5 5.5 10.067 2 12 2zm0 18c-3.866 0-7-3.134-7-7 0-1.308.421-2.519 1.142-3.5h11.716C18.579 10.481 19 11.692 19 13c0 3.866-3.134 7-7 7z" />
                            </svg>
                        </button>
                    </div>


                    <!-- Menu Dropdown -->
                    <div id="userDropdown"
                        class="hidden absolute right-0 mt-2 w-40 bg-white text-gray-800 rounded-md shadow-lg overflow-hidden">
                        <a href="{{ url('/profile') }}" class="block px-4 py-2 hover:bg-gray-200">Profile</a>
                        <form method="POST" action="{{ url('/logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-200">Logout</button>
                        </form>
                    </div>
                </div>
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
    document.addEventListener("DOMContentLoaded", function() {
        const userDropdownBtn = document.getElementById("userDropdownBtn");
        const userDropdown = document.getElementById("userDropdown");

        userDropdownBtn.addEventListener("click", function() {
            userDropdown.classList.toggle("hidden");
        });

        document.addEventListener("click", function(event) {
            if (!userDropdown.contains(event.target) && !userDropdownBtn.contains(event.target)) {
                userDropdown.classList.add("hidden");
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById("researchChart").getContext("2d");

        const researchChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov",
                    "Des"
                ],
                datasets: [{
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
