<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <title>@yield('title') - SIPPMas</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 transition-colors duration-300">

    <!-- Navbar -->
    <nav class="bg-gray-200 text-gray-800 px-4 py-3 flex justify-between items-center shadow-lg">
        <div class="flex items-center">
            <button id="toggleSidebar" class="text-gray-800 focus:outline-none mr-4">
                ☰
            </button>
            <h1 class="text-xl font-semibold">SIPPMas</h1>
        </div>
        <div class="relative">
            {{-- <button id="themeDropdownToggle"
                class="bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-300">
                🌗 Tema
            </button> --}}
            <div id="themeDropdown"
                class="absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded-lg shadow-lg hidden">
                <button class="block w-full px-4 py-2 text-left hover:bg-gray-100" data-theme="light">🌞 Light</button>
                <button class="block w-full px-4 py-2 text-left hover:bg-gray-100" data-theme="dark">🌙 Dark</button>
                <button class="block w-full px-4 py-2 text-left hover:bg-gray-100" data-theme="system">🖥️
                    System</button>
            </div>
        </div>
    </nav>

    <!-- Wrapper for Sidebar and Main Content -->
    <div class="flex transition-all duration-300">
        <!-- Sidebar -->
        <div id="sidebar"
            class="w-64 bg-gray-200 text-gray-800 fixed top-14 h-[calc(100vh-3.5rem)] z-40 shadow-lg -translate-x-64 transition-transform duration-300">
            <ul>
                <li class="p-2 mt-2 flex items-center hover:bg-gray-300 rounded cursor-pointer ms-4 me-4">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center w-full">
                        <span class="material-icons text-gray-600 mr-2">home</span>
                        Beranda
                    </a>
                </li>
                <li class="p-2 flex items-center hover:bg-gray-300 rounded cursor-pointer ms-4 me-4">
                    <a href="{{ route('roadmap.index') }}" class="flex items-center w-full">
                        <span class="material-icons text-gray-600 mr-2">storage</span>
                        Roadmap
                    </a>
                </li>
                <li class="p-2 flex items-center hover:bg-gray-300 rounded cursor-pointer ms-4 me-4">
                    <a href="{{ route('tingkat.index') }}" class="flex items-center w-full">
                        <span class="material-icons text-gray-600 mr-2">storage</span>
                        Pendanaan
                    </a>
                </li>
                <li class="p-2 flex items-center hover:bg-gray-300 rounded cursor-pointer ms-4 me-4">
                    <a href="{{ route('dosen.index') }}" class="flex items-center w-full">
                        <span class="material-icons text-gray-600 mr-2">people</span>
                        Dosen
                    </a>
                </li>
                <li class="p-2 flex items-center hover:bg-gray-300 rounded cursor-pointer ms-4 me-4">
                    <a href="{{ route('mahasiswa.index') }}" class="flex items-center w-full">
                        <span class="material-icons text-gray-600 mr-2">people</span>
                        Mahasiswa
                    </a>
                </li>
                <li class="p-2 flex items-center hover:bg-gray-300 rounded cursor-pointer ms-4 me-4">
                    <a href="{{ route('mitra.index') }}" class="flex items-center w-full">
                        <span class="material-icons text-gray-600 mr-2">people</span>
                        Mitra
                    </a>
                </li>
                <li class="p-2 flex items-center hover:bg-gray-300 rounded cursor-pointer ms-4 me-4">
                    <a href="{{ route('berita.index') }}" class="flex items-center w-full">
                        <span class="material-icons text-gray-600 mr-2">people</span>
                        Berita
                    </a>
                </li>
                <li class="p-2 flex items-center hover:bg-gray-300 rounded cursor-pointer ms-4 me-4">
                    <a href="{{ route('penelitian.index') }}" class="flex items-center w-full">
                        <span class="material-icons text-gray-600 mr-2">book</span>
                        Penelitian
                    </a>
                </li>
                <li class="p-2 flex items-center hover:bg-gray-300 rounded cursor-pointer ms-4 me-4">
                    {{-- <a href="{{ route('admin.pengabdian') }}" class="flex items-center w-full"> --}}
                    <span class="material-icons text-gray-600 mr-2">volunteer_activism</span>
                    Pengabdian
                    </a>
                </li>
                <li class="p-2 flex items-center hover:bg-gray-300 rounded cursor-pointer ms-4 me-4">
                    {{-- <a href="{{ route('admin.request') }}" class="flex items-center w-full"> --}}
                    <span class="material-icons text-gray-600 mr-2">request_quote</span>
                    Request
                    </a>
                </li>
                <li class="p-2 flex items-center hover:bg-gray-300 rounded cursor-pointer ms-4 me-4">
                    {{-- <a href="{{ route('admin.rekap') }}" class="flex items-center w-full"> --}}
                    <span class="material-icons text-gray-600 mr-2">pie_chart</span>
                    Rekap
                    </a>
                </li>
                <li class="p-2 flex items-center hover:bg-gray-300 rounded cursor-pointer ms-4 me-4">
                    <span class="material-icons text-gray-600 mr-2">logout</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-left w-full">Logout</button>
                    </form>
                </li>
            </ul>

        </div>

        <!-- Main Content -->
        <div id="mainContent" class="ml-0 w-full transition-all duration-300">
            <div class="p-8">
                @yield('breadcrumbs')

                @yield('content')
            </div>
        </div>
    </div>
    @yield('scripts')
    <!-- Script for Theme Dropdown -->
    <script>
        const toggleSidebar = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const themeDropdownToggle = document.getElementById('themeDropdownToggle');
        const themeDropdown = document.getElementById('themeDropdown');
        const themeButtons = themeDropdown.querySelectorAll('button[data-theme]');

        let isSidebarOpen = false;

        // Sidebar Toggle Logic
        toggleSidebar.addEventListener('click', () => {
            if (isSidebarOpen) {
                sidebar.classList.add('-translate-x-64');
                mainContent.style.marginLeft = '0';
            } else {
                sidebar.classList.remove('-translate-x-64');
                mainContent.style.marginLeft = '16rem'; // Width of the sidebar
            }
            isSidebarOpen = !isSidebarOpen;
        });

        // Dropdown Toggle Logic
        themeDropdownToggle.addEventListener('click', () => {
            themeDropdown.classList.toggle('hidden');
        });

        // Apply Theme Based on Selection or System Preference
        function applyTheme(theme) {
            const body = document.body;
            const html = document.documentElement;

            if (theme === 'dark') {
                body.classList.add('bg-gray-900', 'text-gray-200');
                body.classList.remove('bg-gray-100', 'text-gray-800');
            } else if (theme === 'light') {
                body.classList.add('bg-gray-100', 'text-gray-800');
                body.classList.remove('bg-gray-900', 'text-gray-200');
            } else if (theme === 'system') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                applyTheme(prefersDark ? 'dark' : 'light');
                return; // Prevent saving system mode itself
            }
            localStorage.setItem('theme', theme);
        }

        // Initialize Theme from LocalStorage or System Preference
        function initializeTheme() {
            const savedTheme = localStorage.getItem('theme') || 'light'; // Default to light
            applyTheme(savedTheme);
        }

        // Add Event Listeners for Theme Buttons
        themeButtons.forEach(button => {
            button.addEventListener('click', () => {
                const selectedTheme = button.getAttribute('data-theme');
                applyTheme(selectedTheme);
                themeDropdown.classList.add('hidden'); // Close dropdown after selection
            });
        });

        // Run on Page Load
        initializeTheme();

        const tanggalInput = document.getElementById('tanggal');

        // Inisialisasi date picker
        tanggalInput.addEventListener('focus', function() {
            const date = new Date();
            const day = ("0" + date.getDate()).slice(-2);
            const month = ("0" + (date.getMonth() + 1)).slice(-2);
            const year = date.getFullYear();

            // Format date menjadi dd/mm/yyyy dan set pada input
            tanggalInput.value = `${day}/${month}/${year}`;
        });

        // Mengubah format saat pengguna menginput atau memilih tanggal
        tanggalInput.addEventListener('input', function(event) {
            const dateParts = event.target.value.split('/');
            if (dateParts.length === 3) {
                const day = ("0" + dateParts[0]).slice(-2);
                const month = ("0" + dateParts[1]).slice(-2);
                const year = dateParts[2];

                // Periksa apakah format sudah valid
                if (!isNaN(Date.parse(`${year}-${month}-${day}`))) {
                    tanggalInput.value = `${day}/${month}/${year}`;
                } else {
                    tanggalInput.setCustomValidity('Format tanggal tidak valid.');
                }
            }
        });
    </script>
</body>

</html>
