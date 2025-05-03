@extends('layout.dosen')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Edit Video</h1>

        <form action="{{ route('luaran.penelitian.buku.update.dosen', $luaran->id) }}" method="POST" class="bg-white p-6 shadow rounded-lg">
            @csrf
            @method('PUT')

            {{-- Pilih Penelitian --}}
            <div class="mb-4">
                <label for="pengabdian_id" class="block text-sm font-semibold text-gray-700">Judul Pengabdian</label>
                <input type="text" name="pengabdian_id" id="pengabdian_id" value="{{ $luaran->luarable->judul }}" class="w-full px-4 py-2 border rounded-lg" disabled>
            </div>

            {{-- Judul Jurnal --}}
            <div class="mb-4">
                <label for="tempat_konferensi" class="block text-sm font-semibold text-gray-700">Tempat</label>
                <input type="text" name="tempat_konferensi" id="tempat_konferensi" value="{{ $luaran->tempat_konferensi }}" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            {{-- Tahun --}}
            <div class="mb-4">
                <label for="tahun" class="block text-sm font-semibold text-gray-700">Tahun</label>
                <input type="number" name="tahun" id="tahun" value="{{ $luaran->tahun }}"class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            {{-- Link --}}
            <div class="mb-4">
                <label for="link" class="block text-sm font-semibold text-gray-700">Link Video</label>
                <input type="url" name="link" id="link" value="{{ $luaran->link }}"class="w-full px-4 py-2 border rounded-lg">
            </div>

            {{-- Tombol Submit --}}
            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                    Update Buku
                </button>
            </div>
        </form>
    </div>
@endsection
