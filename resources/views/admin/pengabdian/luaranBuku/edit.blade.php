@extends('layout.admin')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Edit Buku</h1>

        <form action="{{ route('luaran.pengabdian.buku.update', $luaran->id) }}" method="POST" class="bg-white p-6 shadow rounded-lg">
            @csrf
            @method('PUT')

            {{-- Pilih pengabdian --}}
            <div class="mb-4">
                <label for="pengabdian_id" class="block text-sm font-semibold text-gray-700">Judul Pengabdian</label>
                <input type="text" name="pengabdian_id" id="pengabdian_id" value="{{ $luaran->luarable->judul }}" class="w-full px-4 py-2 border rounded-lg" disabled>
            </div>

            {{-- Judul --}}
            <div class="mb-4">
                <label for="judul" class="block text-sm font-semibold text-gray-700">Judul Buku</label>
                <input type="text" name="judul" id="judul" value="{{ $luaran->judul }}" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            {{-- isbn --}}
            <div class="mb-4">
                <label for="isbn" class="block text-sm font-semibold text-gray-700">Nomor ISBN</label>
                <input type="text" name="isbn" id="isbn" value="{{ $luaran->isbn }}" class="w-full px-4 py-2 border rounded-lg">
            </div>

            {{-- Tahun --}}
            <div class="mb-4">
                <label for="tahun" class="block text-sm font-semibold text-gray-700">Tahun</label>
                <input type="number" name="tahun" id="tahun" value="{{ $luaran->tahun }}" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            {{-- penulis --}}
            <div class="mb-4">
                <label for="penulis" class="block text-sm font-semibold text-gray-700">Penulis</label>
                <input type="text" name="penulis" id="penulis" value="{{ $luaran->penulis }}" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            {{-- Nama Jurnal --}}
            <div class="mb-4">
                <label for="penerbit" class="block text-sm font-semibold text-gray-700">Nama Jurnal</label>
                <input type="text" name="penerbit" id="penerbit" value="{{ $luaran->penerbit }}" class="w-full px-4 py-2 border rounded-lg">
            </div>

            {{-- Link --}}
            <div class="mb-4">
                <label for="link" class="block text-sm font-semibold text-gray-700">Link Jurnal</label>
                <input type="url" name="link" id="link" value="{{ $luaran->link }}" class="w-full px-4 py-2 border rounded-lg">
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
