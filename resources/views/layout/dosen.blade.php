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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>    
    <title>@yield('title') - SIPPMas</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

        @keyframes spreadDark {
            0% {
                transform: scale(0);
                opacity: 0.5;
            }

            100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 transition-colors duration-300">

    <!-- Navbar -->
    <nav
        class="bg-purple-100 text-gray-800 px-4 py-3 flex justify-between items-center shadow-lg sticky top-0 w-full z-50">
        <div class="flex items-center">
            <button id="toggleSidebar" class="text-gray-800 focus:outline-none mr-4">
                ☰
            </button>
            <h1 class="text-xl font-semibold text-purple-900">SIPPMas</h1>
        </div>

        <!-- User Menu -->
        <div class="relative">
            <button id="userMenuButton" class="flex items-center space-x-2 focus:outline-none">
                <div
                    class="w-8 h-8 rounded-full overflow-hidden bg-purple-300 text-purple-900 flex items-center justify-center font-bold uppercase">
                    @if (Auth::user()->foto)
                    <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Foto Profil" class="w-8 h-8 rounded-full object-cover">
                @else
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                @endif                
                </div>
            </button>

            <!-- Dropdown -->
            <div id="userDropdown"
                class="hidden absolute right-0 mt-2 w-64 bg-white border border-purple-200 rounded-lg shadow-lg z-50">
                <div class="px-4 py-3 border-b border-purple-100">
                    <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                </div>
                <div class="px-4 py-2">
                    <a href="/dosen/edit-profile"
                        class="block w-full text-left text-purple-700 hover:bg-purple-50 px-2 py-2 rounded transition">
                        ✏️ Edit Profil
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Wrapper for Sidebar and Main Content -->
    <div class="flex transition-all duration-300">
        <!-- #sidebar -->
        <div id="sidebar"
    class="w-60 bg-purple-50 text-gray-800 fixed top-14 h-[calc(100vh-3.5rem)] z-45 shadow-xl -translate-x-64 transition-transform duration-300 border-r border-purple-200">
    <ul class="space-y-1 px-2 py-4">

        <li class="p-1.5 flex items-center hover:bg-purple-100 rounded cursor-pointer transition">
            <a href="{{ route('dosen.dashboard') }}" class="flex items-center w-full px-3 py-2 rounded">
                <span class="material-icons text-purple-600 mr-2">home</span>
                Beranda
            </a>
        </li>

        <!-- Dropdown Penelitian -->
        <li class="relative">
            <button type="button" onclick="toggleDropdown('penelitian-dosen-menu', event)"
                class="flex items-center w-full hover:bg-purple-100 rounded px-3 py-2 transition">
                <span class="material-icons text-purple-600 mr-2">science</span>
                Penelitian
                <span class="material-icons ml-auto">expand_more</span>
            </button>
            <ul id="penelitian-dosen-menu" class="hidden bg-white shadow-md rounded mt-1 w-full">
                <li class="p-1.5 hover:bg-purple-50">
                    <a href="{{ route('penelitian-dosen.index') }}" class="flex items-center w-full px-3 py-2">
                        <span class="material-icons text-purple-600 mr-2">description</span>
                        Judul Penelitian
                    </a>
                </li>
                <li class="p-1.5 hover:bg-purple-50">
                    <a href="{{ route('luaran.penelitian.jurnal.dosen') }}" class="flex items-center w-full px-3 py-2">
                        <span class="material-icons text-purple-600 mr-2">library_books</span>
                        Luaran Jurnal
                    </a>
                </li>
                <li class="p-1.5 hover:bg-purple-50">
                    <a href="{{ route('luaran.penelitian.hki.dosen') }}" class="flex items-center w-full px-3 py-2">
                        <span class="material-icons text-purple-600 mr-2">gavel</span>
                        Luaran HKI
                    </a>
                </li>
                <li class="p-1.5 hover:bg-purple-50">
                    <a href="{{ route('luaran.penelitian.prosiding.dosen') }}" class="flex items-center w-full px-3 py-2">
                        <span class="material-icons text-purple-600 mr-2">event_note</span>
                        Luaran Prosiding
                    </a>
                </li>
                <li class="p-1.5 hover:bg-purple-50">
                    <a href="{{ route('luaran.penelitian.buku.dosen') }}" class="flex items-center w-full px-3 py-2">
                        <span class="material-icons text-purple-600 mr-2">menu_book</span>
                        Luaran Buku ISBN
                    </a>
                </li>
            </ul>
        </li>

        <!-- Dropdown Pengabdian -->
        <li class="relative">
            <button type="button" onclick="toggleDropdown('pengabdian-dosen-menu', event)"
                class="flex items-center w-full hover:bg-purple-100 rounded px-3 py-2 transition">
                <span class="material-icons text-purple-600 mr-2">volunteer_activism</span>
                Pengabdian
                <span class="material-icons ml-auto">expand_more</span>
            </button>
            <ul id="pengabdian-dosen-menu" class="hidden bg-white shadow-md rounded mt-1 w-full">
                <li class="p-1.5 hover:bg-purple-50">
                    <a href="{{ route('pengabdian-dosen.index') }}" class="flex items-center w-full px-3 py-2">
                        <span class="material-icons text-purple-600 mr-2">description</span>
                        Judul Pengabdian
                    </a>
                </li>
                <li class="p-1.5 hover:bg-purple-50">
                    <a href="{{ route('luaran.pengabdian.jurnal.dosen') }}" class="flex items-center w-full px-3 py-2">
                        <span class="material-icons text-purple-600 mr-2">library_books</span>
                        Luaran Jurnal
                    </a>
                </li>
                <li class="p-1.5 hover:bg-purple-50">
                    <a href="{{ route('luaran.pengabdian.hki.dosen') }}" class="flex items-center w-full px-3 py-2">
                        <span class="material-icons text-purple-600 mr-2">gavel</span>
                        Luaran HKI
                    </a>
                </li>
                <li class="p-1.5 hover:bg-purple-50">
                    <a href="{{ route('luaran.pengabdian.prosiding.dosen') }}" class="flex items-center w-full px-3 py-2">
                        <span class="material-icons text-purple-600 mr-2">event_note</span>
                        Luaran Prosiding
                    </a>
                </li>
                <li class="p-1.5 hover:bg-purple-50">
                    <a href="{{ route('luaran.pengabdian.buku.dosen') }}" class="flex items-center w-full px-3 py-2">
                        <span class="material-icons text-purple-600 mr-2">menu_book</span>
                        Luaran Buku ISBN
                    </a>
                </li>
                <li class="p-1.5 hover:bg-purple-50">
                    <a href="{{ route('luaran.pengabdian.video.dosen') }}" class="flex items-center w-full px-3 py-2">
                        <span class="material-icons text-purple-600 mr-2">videocam</span>
                        Luaran Video
                    </a>
                </li>
            </ul>
        </li>

        <!-- Request -->
        <li class="p-1.5 flex items-center hover:bg-purple-100 rounded cursor-pointer transition">
            <a href="{{ route('requestdosen.index') }}" class="flex items-center w-full px-3 py-2 rounded">
                <span class="material-icons text-purple-600 mr-2">folder</span>
                Request
            </a>
        </li>

        <!-- Logout -->
        <li class="p-1.5 flex items-center hover:bg-purple-100 rounded cursor-pointer transition">
            <form method="POST" action="{{ route('logout') }}" class="flex items-center w-full px-3 py-2">
                @csrf
                <span class="material-icons text-purple-600 mr-2">logout</span>
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

        let isSidebarOpen = false;

        toggleSidebar.addEventListener('click', () => {
            if (isSidebarOpen) {
                sidebar.classList.add('-translate-x-64');
                mainContent.classList.remove('ml-64');
            } else {
                sidebar.classList.remove('-translate-x-64');
                mainContent.classList.add('ml-64');
            }
            isSidebarOpen = !isSidebarOpen;
        });
    </script>
    <script>
        // Toggle dropdown menu
        document.getElementById('userMenuButton').addEventListener('click', function() {
            document.getElementById('userDropdown').classList.toggle('hidden');
        });

        // Optional: hide dropdown if click outside
        window.addEventListener('click', function(e) {
            const button = document.getElementById('userMenuButton');
            const dropdown = document.getElementById('userDropdown');
            if (!button.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
    
<script>
    function toggleDropdown(id, event) {
        event.stopPropagation();
        const dropdown = document.getElementById(id);
        dropdown.classList.toggle('hidden');
    }

    // Optional: Close dropdown when clicking outside
    window.addEventListener('click', function () {
        document.querySelectorAll('ul[id$="-menu"]').forEach(ul => ul.classList.add('hidden'));
    });
</script>

</body>

</html>
