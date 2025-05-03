@extends('layout.dosen')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Edit Jurnal</h1>

        <form action="{{ route('luaran.pengabdian.jurnal.update.dosen', $luaran->id) }}" method="POST" class="bg-white p-6 shadow rounded-lg">
            @csrf
            @method('PUT')


            <div class="mb-4">
                <label for="pengabdian_id" class="block text-sm font-semibold text-gray-700">Judul Pengabdian</label>
                <input type="text" name="pengabdian_id" id="pengabdian_id" value="{{ $luaran->luarable->judul }}" class="w-full px-4 py-2 border rounded-lg" disabled>
            </div>

            {{-- Judul --}}
            <div class="mb-4">
                <label for="judul" class="block text-sm font-semibold text-gray-700">Judul Jurnal</label>
                <input type="text" name="judul" id="judul" value="{{ $luaran->judul }}" class="w-full px-4 py-2 border rounded-lg" required>
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

            {{-- Sinta --}}
            <div class="mb-4">
                <label for="sinta" class="block text-sm font-semibold text-gray-700">Index</label>
                <select name="sinta" id="sinta" class="w-full px-4 py-2 border rounded-lg" required>
                    <option value="">-- Pilih index --</option>
                    <option value="Nasional" {{ $luaran->sinta == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                    <option value="Nasional Terakreditasi" {{ $luaran->sinta == 'Nasional Terakreditasi' ? 'selected' : '' }}>Nasional Terakreditasi</option>
                    <option value="Internasional" {{ $luaran->sinta == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                    <option value="Internasional Bereputasi" {{ $luaran->sinta == 'Internasional Bereputasi' ? 'selected' : '' }}>Internasional Bereputasi</option>
                </select>
            </div>

            {{-- Link --}}
            <div class="mb-4">
                <label for="link" class="block text-sm font-semibold text-gray-700">Link Jurnal</label>
                <input type="url" name="link" id="link" value="{{ $luaran->link }}" class="w-full px-4 py-2 border rounded-lg">
            </div>

            {{-- Tombol Submit --}}
            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                    Update Jurnal
                </button>
            </div>
        </form>
    </div>
@endsection
