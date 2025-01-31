<!-- resources/views/landing.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPPMas</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans bg-gray-100">

    <!-- Navbar -->
    <header class="flex justify-between items-center p-4 bg-brown-700 text-white">
        <div class="text-3xl font-semibold">
            SIPPMas
        </div>
        <nav class="space-x-6">
            <a href="{{ url('/penelitian') }}" class="hover:text-yellow-300">Penelitian</a>
            <a href="{{ url('/pengabdian') }}" class="hover:text-yellow-300">Pengabdian</a>
            <a href="{{ url('/login') }}" class="hover:text-yellow-300">Login</a>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="relative w-full h-96 bg-cover bg-center" style="background-image: url('/path/to/your-image.jpg');">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="absolute inset-0 flex justify-center items-center text-white text-4xl font-bold">
            <p>Selamat datang di Sistem Informasi Penelitian dan Pengabdian Masyarakat</p>
        </div>
    </section>

    <!-- Section: Selamat datang -->
    <section class="text-center p-10">
        <h2 class="text-3xl font-semibold mb-4">Selamat datang di Pusat Penelitian</h2>
        <p class="text-lg text-gray-700">Kami menyediakan platform untuk mempermudah penelitian dan pengabdian masyarakat.</p>
    </section>

    <!-- Section: Berita Terbaru -->
    <section class="p-10 bg-gray-200">
        <h3 class="text-2xl font-semibold text-center mb-6">Berita Terbaru</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Berita 1 -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <img src="/path/to/berita1.jpg" alt="Berita 1" class="w-full h-40 object-cover rounded-lg mb-4">
                <h4 class="font-semibold text-xl">Judul Berita 1</h4>
                <p class="text-gray-600">Tanggal: 2025-01-29</p>
            </div>
            <!-- Berita 2 -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <img src="/path/to/berita2.jpg" alt="Berita 2" class="w-full h-40 object-cover rounded-lg mb-4">
                <h4 class="font-semibold text-xl">Judul Berita 2</h4>
                <p class="text-gray-600">Tanggal: 2025-01-28</p>
            </div>
            <!-- Berita 3 -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <img src="/path/to/berita3.jpg" alt="Berita 3" class="w-full h-40 object-cover rounded-lg mb-4">
                <h4 class="font-semibold text-xl">Judul Berita 3</h4>
                <p class="text-gray-600">Tanggal: 2025-01-27</p>
            </div>
        </div>
    </section>

    <!-- Section: Penelitian dan Pengabdian Terbaru -->
    <section class="p-10">
        <h3 class="text-2xl font-semibold text-center mb-6">Penelitian dan Pengabdian Terbaru</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Penelitian 1 -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <img src="/path/to/penelitian1.jpg" alt="Penelitian 1" class="w-full h-40 object-cover rounded-lg mb-4">
                <h4 class="font-semibold text-xl">Judul Penelitian 1</h4>
                <p class="text-gray-600">Ketua: Dr. John Doe</p>
                <p class="text-gray-600">Tanggal: 2025-01-29</p>
            </div>
            <!-- Pengabdian 2 -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <img src="/path/to/pengabdian1.jpg" alt="Pengabdian 1" class="w-full h-40 object-cover rounded-lg mb-4">
                <h4 class="font-semibold text-xl">Judul Pengabdian 1</h4>
                <p class="text-gray-600">Ketua: Dr. Jane Smith</p>
                <p class="text-gray-600">Tanggal: 2025-01-28</p>
            </div>
            <!-- Penelitian 3 -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <img src="/path/to/penelitian2.jpg" alt="Penelitian 3" class="w-full h-40 object-cover rounded-lg mb-4">
                <h4 class="font-semibold text-xl">Judul Penelitian 2</h4>
                <p class="text-gray-600">Ketua: Prof. Mike Lee</p>
                <p class="text-gray-600">Tanggal: 2025-01-27</p>
            </div>
        </div>
    </section>

</body>
</html>
