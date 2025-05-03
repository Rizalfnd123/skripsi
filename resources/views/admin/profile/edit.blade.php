@extends('layout.admin')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold text-purple-700 mb-4">Edit Profil</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                class="w-full border border-purple-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                class="w-full border border-purple-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Password (biarkan kosong jika tidak diubah)</label>
            <input type="password" name="password"
                class="w-full border border-purple-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                class="w-full border border-purple-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Foto Profil</label>
            <input type="file" name="photo" class="w-full mt-1 text-sm text-gray-700">

            @if($user->photo)
                <div class="mt-3">
                    <p class="text-sm text-gray-600">Foto saat ini:</p>
                    <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Foto" class="w-24 h-24 rounded object-contain">
                </div>
            @endif
        </div>

        <div>
            <button type="submit"
                class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
