<!-- resources/views/pengabdian/luaran/create.blade.php -->

@extends('layout.dosen')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Tambah Video</h1>

        {{-- Form Create Jurnal --}}
        <form action="{{ route('luaran.pengabdian.video.store.dosen') }}" method="POST" class="bg-white p-6 shadow rounded-lg">
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

            {{-- Pilih pengabdian --}}
            <div class="mb-4">
                <label for="pengabdian_id" class="block text-sm font-semibold text-gray-700">Pilih pengabdian</label>
                <select name="pengabdian_id" id="pengabdian_id" class="w-full px-4 py-2 border rounded-lg" required>
                    <option value="">-- Pilih Pengabdian --</option>
                    @foreach ($pengabdians as $pengabdian)
                        <option value="{{ $pengabdian->id }}" data-roadmap="{{ $pengabdian->id_roadmap }}">
                            {{ $pengabdian->judul }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- Judul Jurnal --}}
            <div class="mb-4">
                <label for="tempat_konferensi" class="block text-sm font-semibold text-gray-700">Tempat</label>
                <input type="text" name="tempat_konferensi" id="tempat_konferensi" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            {{-- Tahun --}}
            <div class="mb-4">
                <label for="tahun" class="block text-sm font-semibold text-gray-700">Tahun</label>
                <input type="number" name="tahun" id="tahun" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            {{-- Link --}}
            <div class="mb-4">
                <label for="link" class="block text-sm font-semibold text-gray-700">Link Video</label>
                <input type="url" name="link" id="link" class="w-full px-4 py-2 border rounded-lg">
            </div>

            {{-- Tombol Simpan --}}
            <div class="mb-4">
                <button type="submit"
                    class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                    Simpan Video
                </button>
            </div>
        </form>
    </div>
    <script>
        document.getElementById('id_roadmap').addEventListener('change', function () {
            const selectedRoadmap = this.value;
            const pengabdianSelect = document.getElementById('pengabdian_id');
    
            // Reset pilihan
            pengabdianSelect.value = '';
            Array.from(pengabdianSelect.options).forEach(option => {
                if (!option.value) return; // skip placeholder
                const roadmap = option.getAttribute('data-roadmap');
                option.style.display = (roadmap === selectedRoadmap) ? 'block' : 'none';
            });
        });
    
        // Inisialisasi: sembunyikan semua dulu
        window.addEventListener('DOMContentLoaded', () => {
            const pengabdianSelect = document.getElementById('pengabdian_id');
            Array.from(pengabdianSelect.options).forEach(option => {
                if (option.value) {
                    option.style.display = 'none';
                }
            });
        });
    </script>    
@endsection
