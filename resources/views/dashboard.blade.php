<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-blue-600 p-4">
        <div class="flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="text-white text-lg font-bold">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-white bg-red-500 px-4 py-2 rounded-md hover:bg-red-600">Logout</button>
            </form>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <div class="container mx-auto p-6 mt-10 bg-white shadow-lg rounded-lg">
        <h1 class="text-2xl font-semibold text-gray-800">Welcome, {{ Auth::user()->name }}!</h1>
        <p class="mt-2 text-gray-600">You are logged in as {{ Auth::user()->role ?? 'User' }}.</p>

        <div class="mt-6">
            <h3 class="text-xl font-medium text-gray-800">Dashboard Overview</h3>
            <!-- Add more content relevant to the dashboard -->
            <p class="mt-2 text-gray-600">Here you can manage your data and settings.</p>
        </div>
    </div>

</body>
</html>
