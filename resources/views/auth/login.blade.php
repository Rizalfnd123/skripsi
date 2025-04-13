<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative flex items-center justify-center h-screen">

    <!-- Video Background -->
    <video class="absolute inset-0 w-full h-full object-cover" autoplay loop muted playsinline>
        <source src="{{ asset('videos/a.mp4') }}" type="video/mp4">
        Browser Anda tidak mendukung tag video.
    </video>

    <!-- Overlay Gelap -->
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>

    <!-- Form Login -->
    <div class="relative w-full max-w-md bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-center text-purple-800">SIPPMas</h1>

        @if (session('success'))
            <div class="mb-4 text-green-500">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 text-red-500">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}" class="mt-6 space-y-4">
            @csrf

            <div>
                <label for="login" class="block text-sm font-medium text-gray-700">Email atau Username</label>
                <input type="text" id="login" name="login"
                    class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-purple-400"
                    value="{{ old('login') }}" required autofocus>
                @error('login')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-purple-400"
                    required>
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit"
                    class="w-full py-2 px-4 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring focus:ring-purple-400">
                    Login
                </button>
            </div>

            <p class="text-sm text-gray-600 text-center">
                <a href="{{ route('password.request') }}" class="text-purple-500 hover:underline">Forgot your
                    password?</a>
            </p>

            <p class="text-sm text-gray-600 text-center">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-purple-500 hover:underline">Register here</a>.
            </p>
        </form>
    </div>

</body>

</html>
