@extends('layout.admin')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Edit Jurnal</h1>

        <form action="{{ route('luaran.pengabdian.hki.update', $luaran->id) }}" method="POST" class="bg-white p-6 shadow rounded-lg">
            @csrf
            @method('PUT')

            {{-- Pilih pengabdian --}}
            <div class="mb-4">
                <label for="pengabdian_id" class="block text-sm font-semibold text-gray-700">Judul Pengabdian</label>
                <input type="text" name="pengabdian_id" id="pengabdian_id" value="{{ $luaran->luarable->judul }}" class="w-full px-4 py-2 border rounded-lg" disabled>
            </div>

            {{-- Judul --}}
            <div class="mb-4">
                <label for="nama_karya" class="block text-sm font-semibold text-gray-700">Nama Karya</label>
                <input type="text" name="nama_karya" id="nama_karya" value="{{ $luaran->nama_karya }}" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            {{-- Tahun --}}
            <div class="mb-4">
                <label for="jenis" class="block text-sm font-semibold text-gray-700">Jenis</label>
                <input type="text" name="jenis" id="jenis" value="{{ $luaran->jenis }}" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            {{-- penulis --}}
            <div class="mb-4">
                <label for="pencipta" class="block text-sm font-semibold text-gray-700">Pencipta</label>
                <input type="text" name="pencipta" id="pencipta" value="{{ $luaran->pencipta }}" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            {{-- Nama Jurnal --}}
            <div class="mb-4">
                <label for="pemegang_hak_cipta" class="block text-sm font-semibold text-gray-700">Pemegang Hak Cipta</label>
                <input type="text" name="pemegang_hak_cipta" id="pemegang_hak_cipta" value="{{ $luaran->pemegang_hak_cipta }}" class="w-full px-4 py-2 border rounded-lg">
            </div>

            {{-- Sinta --}}
            <div class="mb-4">
                <label for="nomor_pengajuan" class="block text-sm font-semibold text-gray-700">Nomor Pengajuan</label>
                <input type="text" name="nomor_pengajuan" id="nomor_pengajuan" value="{{ $luaran->nomor_pengajuan }}" class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div class="mb-4">
                <label for="tanggal_diterima" class="block text-sm font-semibold text-gray-700">Tanggal Diterima</label>
                <input type="text" name="tanggal_diterima" id="tanggal_diterima" value="{{ $luaran->tanggal_diterima }}" class="w-full px-4 py-2 border rounded-lg">
            </div>

            {{-- Link --}}
            <div class="mb-4">
                <label for="link" class="block text-sm font-semibold text-gray-700">Link HKI</label>
                <input type="url" name="link" id="link" value="{{ $luaran->link }}" class="w-full px-4 py-2 border rounded-lg">
            </div>

            {{-- Tombol Submit --}}
            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                    Update HKI
                </button>
            </div>
        </form>
    </div>
@endsection
