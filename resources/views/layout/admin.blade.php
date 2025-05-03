<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
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
            background-image: url('{{ asset('../images/bg.jpg') }}');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class=" text-gray-800 transition-colors duration-300">

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
                <div class="w-8 h-8 rounded-full overflow-hidden bg-purple-300 text-purple-900 flex items-center justify-center font-bold uppercase">
                    @if(Auth::user()->photo)
                    <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Foto" class="w-24 h-24 rounded object-contain">
                @else
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                @endif                
                </div>                
                {{-- <span class="font-medium">Username</span> --}}
            </button>

            <!-- Dropdown -->
            <div id="userDropdown"
                class="hidden absolute right-0 mt-2 w-64 bg-white border border-purple-200 rounded-lg shadow-lg z-50">
                <div class="px-4 py-3 border-b border-purple-100">
                    <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                </div>
                <div class="px-4 py-2">
                    <a href="/edit-profile"
                        class="block w-full text-left text-purple-700 hover:bg-purple-50 px-2 py-2 rounded transition">
                        ✏️ Edit Profil
                    </a>
                </div>
            </div>
        </div>
    </nav>


    <!-- Wrapper for Sidebar and Main Content -->
    <div class="flex transition-all duration-300">
        <!-- Sidebar -->
        <div id="sidebar"
            class="w-60 bg-purple-50 text-gray-800 fixed top-14 h-[calc(100vh-3.5rem)] z-45 shadow-xl -translate-x-64 transition-transform duration-300 border-r border-purple-200">
            <ul class="space-y-1 px-2 py-4">
                <li class="p-1.5 flex items-center hover:bg-purple-100 rounded cursor-pointer transition">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center w-full px-3 py-2 rounded">
                        <span class="material-icons text-purple-600 mr-2">home</span>
                        Beranda
                    </a>
                </li>

                <!-- User Dropdown -->
                <li class="relative">
                    <button type="button" onclick="toggleDropdown('user-menu', event)"
                        class="flex items-center w-full hover:bg-purple-100 rounded px-3 py-2 transition">
                        <span class="material-icons text-purple-600 mr-2">people</span>
                        Pengguna
                        <span class="material-icons ml-auto">expand_more</span>
                    </button>
                    <ul id="user-menu" class="hidden bg-white shadow-lg rounded mt-1 w-full">
                        <li class="p-1.5 hover:bg-purple-50">
                            <a href="{{ route('dosen.index') }}" class="flex items-center w-full px-3 py-2">
                                <span class="material-icons text-purple-600 mr-2">people</span>
                                Dosen
                            </a>
                        </li>
                        <li class="p-1.5 hover:bg-purple-50">
                            <a href="{{ route('mahasiswa.index') }}" class="flex items-center w-full px-3 py-2">
                                <span class="material-icons text-purple-600 mr-2">people</span>
                                Mahasiswa
                            </a>
                        </li>
                        <li class="p-1.5 hover:bg-purple-50">
                            <a href="{{ route('mitra.index') }}" class="flex items-center w-full px-3 py-2">
                                <span class="material-icons text-purple-600 mr-2">people</span>
                                Mitra
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Data Umum Dropdown -->
                <li class="relative">
                    <button type="button" onclick="toggleDropdown('data-umum', event)"
                        class="flex items-center w-full hover:bg-purple-100 rounded px-3 py-2 transition">
                        <span class="material-icons text-purple-600 mr-2">storage</span>
                        Data Umum
                        <span class="material-icons ml-auto">expand_more</span>
                    </button>
                    <ul id="data-umum" class="hidden bg-white shadow-lg rounded mt-1 w-full">
                        <li class="p-1.5 hover:bg-purple-50">
                            <a href="{{ route('roadmap.index') }}" class="flex items-center w-full px-3 py-2">
                                <span class="material-icons text-purple-600 mr-2">storage</span>
                                Grup Riset
                            </a>
                        </li>
                        <li class="p-1.5 hover:bg-purple-50">
                            <a href="{{ route('tingkat.index') }}" class="flex items-center w-full px-3 py-2">
                                <span class="material-icons text-purple-600 mr-2">storage</span>
                                Pendanaan
                            </a>
                        </li>
                        <li class="p-1.5 hover:bg-purple-50">
                            <a href="{{ route('semester.index') }}" class="flex items-center w-full px-3 py-2">
                                <span class="material-icons text-purple-600 mr-2">storage</span>
                                Semester
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Penelitian Dropdown -->
                <li class="relative">
                    <button type="button" onclick="toggleDropdown('penelitian-menu', event)"
                        class="flex items-center w-full hover:bg-purple-100 rounded px-3 py-2 transition">
                        <span class="material-icons text-purple-600 mr-2">science</span>
                        Penelitian
                        <span class="material-icons ml-auto">expand_more</span>
                    </button>
                    <ul id="penelitian-menu" class="hidden bg-white shadow-lg rounded mt-1 w-full">
                        <li class="p-1.5 hover:bg-purple-50">
                            <a href="{{ route('penelitian.index') }}" class="flex items-center w-full px-3 py-2">
                                <span class="material-icons text-purple-600 mr-2">description</span>
                                Judul Penelitian
                            </a>
                        </li>
                        <li class="p-1.5 hover:bg-purple-50">
                            <a href="{{ route('luaran.penelitian.jurnal') }}"
                                class="flex items-center w-full px-3 py-2">
                                <span class="material-icons text-purple-600 mr-2">library_books</span>
                                Luaran Jurnal
                            </a>
                        </li>
                        <li class="p-1.5 hover:bg-purple-50">
                            <a href="{{ route('luaran.penelitian.hki') }}" class="flex items-center w-full px-3 py-2">
                                <span class="material-icons text-purple-600 mr-2">gavel</span>
                                Luaran HKI
                            </a>
                        </li>
                        <li class="p-1.5 hover:bg-purple-50">
                            <a href="{{ route('luaran.penelitian.prosiding') }}"
                                class="flex items-center w-full px-3 py-2">
                                <span class="material-icons text-purple-600 mr-2">event_note</span>
                                Luaran Prosiding
                            </a>
                        </li>
                        <li class="p-1.5 hover:bg-purple-50">
                            <a href="{{ route('luaran.penelitian.buku') }}"
                                class="flex items-center w-full px-3 py-2">
                                <span class="material-icons text-purple-600 mr-2">menu_book</span>
                                Luaran Buku ISBN
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="relative">
                    <button type="button" onclick="toggleDropdown('pengabdian-menu', event)"
                        class="flex items-center w-full hover:bg-purple-400/20 rounded px-3 py-2 transition">
                        <span class="material-icons text-purple-600 mr-2">volunteer_activism</span>
                        Pengabdian
                        <span class="material-icons ml-auto">expand_more</span>
                    </button>
                    <ul id="pengabdian-menu" class="hidden bg-white shadow-md rounded mt-1 w-full">
                        <li class="p-1.5 hover:bg-purple-50">
                            <a href="{{ route('pengabdian.index') }}" class="flex items-center w-full px-3 py-2">
                                <span class="material-icons text-purple-600 mr-2 ms-2">description</span>
                                Judul Pengabdian
                            </a>
                        </li>
                        <li class="p-1.5 hover:bg-purple-50">
                            <a href="{{ route('luaran.pengabdian.jurnal') }}" class="flex items-center w-full px-3 py-2">
                                <span class="material-icons text-purple-600 mr-2">library_books</span>
                                Luaran Jurnal
                            </a>
                        </li>
                        <li class="p-1.5 hover:bg-purple-50">
                            <a href="{{ route('luaran.pengabdian.hki') }}" class="flex items-center w-full px-3 py-2">
                                <span class="material-icons text-purple-600 mr-2">gavel</span>
                                Luaran HKI
                            </a>
                        </li>
                        <li class="p-1.5 hover:bg-purple-50">
                            <a href="{{ route('luaran.pengabdian.prosiding') }}" class="flex items-center w-full px-3 py-2">
                                <span class="material-icons text-purple-600 mr-2">event_note</span>
                                Luaran Prosiding
                            </a>
                        </li>
                        <li class="p-1.5 hover:bg-purple-50">
                            <a href="{{ route('luaran.pengabdian.buku') }}" class="flex items-center w-full px-3 py-2">
                                <span class="material-icons text-purple-600 mr-2">menu_book</span>
                                Luaran Buku ISBN
                            </a>
                        </li>
                        <li class="p-1.5 hover:bg-purple-50">
                            <a href="{{ route('luaran.pengabdian.video') }}" class="flex items-center w-full px-3 py-2">
                                <span class="material-icons text-purple-600 mr-2">videocam</span>
                                Luaran Video
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="p-1.5 flex items-center hover:bg-purple-400/20 rounded cursor-pointer transition">
                    <a href="{{ route('berita.index') }}" class="flex items-center w-full px-3 py-2 rounded">
                        <span class="material-icons text-purple-600 mr-2">people</span>
                        Berita
                    </a>
                </li>
                
                <li class="p-1.5 flex items-center hover:bg-purple-400/20 rounded cursor-pointer transition">
                    <a href="{{ route('requestadmin.index') }}" class="flex items-center w-full px-3 py-2 rounded">
                        <span class="material-icons text-purple-600 mr-2 ">folder</span>
                        Request
                    </a>
                </li>
                
                <li class="p-1.5 flex items-center hover:bg-purple-400/20 rounded cursor-pointer transition">
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
        // Toggle Dropdown (Pengguna, Data Umum, dst)
        function toggleDropdown(id, event) {
            event.stopPropagation(); // Hindari close langsung saat klik dropdown
            document.getElementById(id).classList.toggle("hidden");
        }

        // Tutup dropdown saat klik di luar
        // document.addEventListener("click", function () {
        //     document.querySelectorAll("ul[id^='user-menu'], ul[id^='data-umum'], ul[id^='penelitian-menu'], ul[id^='pengabdian-menu']").forEach(menu => {
        //         menu.classList.add("hidden");
        //     });
        // });

        // Sidebar Toggle
        const toggleSidebar = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        let isSidebarOpen = false;

        toggleSidebar.addEventListener('click', () => {
            if (isSidebarOpen) {
                sidebar.classList.add('-translate-x-64');
                mainContent.style.marginLeft = '0';
            } else {
                sidebar.classList.remove('-translate-x-64');
                mainContent.style.marginLeft = '16rem';
            }
            isSidebarOpen = !isSidebarOpen;
        });

        // Tanggal Picker
        const tanggalInput = document.getElementById('tanggal');
        if (tanggalInput) {
            tanggalInput.addEventListener('focus', function() {
                const date = new Date();
                const day = ("0" + date.getDate()).slice(-2);
                const month = ("0" + (date.getMonth() + 1)).slice(-2);
                const year = date.getFullYear();
                tanggalInput.value = `${day}/${month}/${year}`;
            });

            tanggalInput.addEventListener('input', function(event) {
                const dateParts = event.target.value.split('/');
                if (dateParts.length === 3) {
                    const [day, month, year] = dateParts;
                    if (!isNaN(Date.parse(`${year}-${month}-${day}`))) {
                        tanggalInput.value = `${day}/${month}/${year}`;
                    } else {
                        tanggalInput.setCustomValidity('Format tanggal tidak valid.');
                    }
                }
            });
        }

        // User Dropdown
        const userMenuButton = document.getElementById('userMenuButton');
        const userDropdown = document.getElementById('userDropdown');

        if (userMenuButton && userDropdown) {
            userMenuButton.addEventListener('click', () => {
                userDropdown.classList.toggle('hidden');
            });

            window.addEventListener('click', (e) => {
                if (!userMenuButton.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.add('hidden');
                }
            });
        }
    </script>

</body>

</html>
