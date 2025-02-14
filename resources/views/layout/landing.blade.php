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
    <!-- Main Content -->
    <div id="mainContent" class="ml-0 w-full transition-all duration-300">
        <div class="p-8">
            @yield('breadcrumbs')

            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-6">
        <div class="container mx-auto text-center">
            <p>&copy; {{ date('Y') }} SIPPMas. All rights reserved.</p>
        </div>
    </footer>

</body>
@yield('scripts')
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
