<!-- resources/views/penelitian/luaran/create.blade.php -->

@extends('layout.admin')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Tambah HKI</h1>

        {{-- Form Create Jurnal --}}
        <form action="{{ route('luaran.penelitian.hki.store') }}" method="POST" class="bg-white p-6 shadow rounded-lg">
            @csrf

            {{-- Pilih Roadmap --}}
            <div class="mb-4">
                <label for="id_roadmap" class="block text-sm font-semibold text-gray-700">Pilih Roadmap</label>
                <select id="id_roadmap" class="w-full px-4 py-2 border rounded-lg" required>
                    <option value="">-- Pilih Roadmap --</option>
                    <option value="1">Pembelajaran Domain TIK</option>
                    <option value="2">Pembelajaran Berbantuan TIK</option>
                    <option value="3">Informatika Terapan</option>
                </select>
            </div>

            {{-- Pilih Penelitian --}}
            <div class="mb-4">
                <label for="penelitian_id" class="block text-sm font-semibold text-gray-700">Pilih Penelitian</label>
                <select name="penelitian_id" id="penelitian_id" class="w-full px-4 py-2 border rounded-lg" required>
                    <option value="">-- Pilih Penelitian --</option>
                    @foreach ($penelitians as $penelitian)
                        <option value="{{ $penelitian->id }}" data-roadmap="{{ $penelitian->id_roadmap }}">
                            {{ $penelitian->judul }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- nama_karya --}}
            <div class="mb-4">
                <label for="nama_karya" class="block text-sm font-semibold text-gray-700">Nama Karya</label>
                <input type="text" name="nama_karya" id="nama_karya" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            {{-- jenis --}}
            <div class="mb-4">
                <label for="jenis" class="block text-sm font-semibold text-gray-700">Jenis</label>
                <input type="text" name="jenis" id="jenis" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            {{-- Sinta --}}
            <div class="mb-4">
                <label for="pencipta" class="block text-sm font-semibold text-gray-700">Pencipta</label>
                <input type="text" name="pencipta" id="pencipta" class="w-full px-4 py-2 border rounded-lg">
            </div>

            {{-- Sinta --}}
            <div class="mb-4">
                <label for="pemegang_hak_cipta" class="block text-sm font-semibold text-gray-700">Pemegang Hak Cipta</label>
                <input type="text" name="pemegang_hak_cipta" id="pemegang_hak_cipta" class="w-full px-4 py-2 border rounded-lg">
            </div>

            {{-- Sinta --}}
            <div class="mb-4">
                <label for="nomor_pengajuan" class="block text-sm font-semibold text-gray-700">Nomor Pengajuan</label>
                <input type="text" name="nomor_pengajuan" id="nomor_pengajuan" class="w-full px-4 py-2 border rounded-lg">
            </div>

            {{-- Sinta --}}
            <div class="mb-4">
                <label for="tanggal_diterima" class="block text-sm font-semibold text-gray-700">Tanggal Diterima</label>
                <input type="date" name="tanggal_diterima" id="tanggal_diterima" class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div class="mb-4">
                <label for="link" class="block text-sm font-semibold text-gray-700">Link</label>
                <input type="text" name="link" id="link" class="w-full px-4 py-2 border rounded-lg">
            </div>

            {{-- Tombol Simpan --}}
            <div class="mb-4">
                <button type="submit"
                    class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                    Simpan HKI
                </button>
            </div>
        </form>
    </div>
    <script>
        document.getElementById('id_roadmap').addEventListener('change', function () {
            const selectedRoadmap = this.value;
            const penelitianSelect = document.getElementById('penelitian_id');
    
            // Reset pilihan
            penelitianSelect.value = '';
            Array.from(penelitianSelect.options).forEach(option => {
                if (!option.value) return; // skip placeholder
                const roadmap = option.getAttribute('data-roadmap');
                option.style.display = (roadmap === selectedRoadmap) ? 'block' : 'none';
            });
        });
    
        // Inisialisasi: sembunyikan semua dulu
        window.addEventListener('DOMContentLoaded', () => {
            const penelitianSelect = document.getElementById('penelitian_id');
            Array.from(penelitianSelect.options).forEach(option => {
                if (option.value) {
                    option.style.display = 'none';
                }
            });
        });
    </script>    
@endsection
