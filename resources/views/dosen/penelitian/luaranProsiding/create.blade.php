<!-- resources/views/penelitian/luaran/create.blade.php -->

@extends('layout.dosen')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Tambah Prosiding</h1>

        {{-- Form Create Jurnal --}}
        <form action="{{ route('luaran.penelitian.prosiding.store.dosen') }}" method="POST" class="bg-white p-6 shadow rounded-lg">
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

            <div class="mb-4">
                <label for="nama_konferensi" class="block text-sm font-semibold text-gray-700">Nama Konferensi</label>
                <input type="text" name="nama_konferensi" id="nama_konferensi" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="tempat_konferensi" class="block text-sm font-semibold text-gray-700">Tempat Konferensi</label>
                <input type="text" name="tempat_konferensi" id="tempat_konferensi" class="w-full px-4 py-2 border rounded-lg" required>
            </div>
            
            <div class="mb-4">
                <label for="tgl_konferensi" class="block text-sm font-semibold text-gray-700">Tanggal Konferensi</label>
                <input type="date" name="tgl_konferensi" id="tgl_konferensi" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="penyelenggara" class="block text-sm font-semibold text-gray-700">Nama Penyelenggara</label>
                <input type="text" name="penyelenggara" id="penyelenggara" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            {{-- Judul Jurnal --}}
            <div class="mb-4">
                <label for="judul" class="block text-sm font-semibold text-gray-700">Judul Jurnal</label>
                <input type="text" name="judul" id="judul" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            {{-- Tahun --}}
            <div class="mb-4">
                <label for="tahun" class="block text-sm font-semibold text-gray-700">Tahun</label>
                <input type="number" name="tahun" id="tahun" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            {{-- Sinta --}}
            <div class="mb-4">
                <label for="penulis" class="block text-sm font-semibold text-gray-700">Penulis</label>
                <input type="text" name="penulis" id="penulis" class="w-full px-4 py-2 border rounded-lg">
            </div>

            {{-- Sinta --}}
            <div class="mb-4">
                <label for="penerbit" class="block text-sm font-semibold text-gray-700">Nama Jurnal</label>
                <input type="text" name="penerbit" id="penerbit" class="w-full px-4 py-2 border rounded-lg">
            </div>

            {{-- Sinta --}}
            <div class="mb-4">
                <label for="sinta" class="block text-sm font-semibold text-gray-700">Sinta</label>
                <input type="text" name="sinta" id="sinta" class="w-full px-4 py-2 border rounded-lg">
            </div>

            {{-- Link --}}
            <div class="mb-4">
                <label for="link" class="block text-sm font-semibold text-gray-700">Link Jurnal</label>
                <input type="url" name="link" id="link" class="w-full px-4 py-2 border rounded-lg">
            </div>

            {{-- Tombol Simpan --}}
            <div class="mb-4">
                <button type="submit"
                    class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                    Simpan Prosiding
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
