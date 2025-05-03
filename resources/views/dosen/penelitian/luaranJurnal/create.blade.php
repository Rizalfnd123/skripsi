@extends('layout.dosen')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-purple-700 mb-6 text-center">Tambah Jurnal</h1>

        {{-- Form Create Jurnal --}}
        <form action="{{ route('luaran.penelitian.jurnal.store.dosen') }}" method="POST"
            class="bg-white p-6 shadow-md rounded-xl border border-purple-200">
            @csrf

            {{-- Pilih Roadmap --}}
            <div class="mb-4">
                <label for="id_roadmap" class="block text-sm font-semibold text-purple-700">Pilih Roadmap</label>
                <select id="id_roadmap" class="w-full px-4 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400 bg-purple-50" required>
                    <option value="">-- Pilih Roadmap --</option>
                    <option value="1">Pembelajaran Domain TIK</option>
                    <option value="2">Pembelajaran Berbantuan TIK</option>
                    <option value="3">Informatika Terapan</option>
                </select>
            </div>

            {{-- Pilih Penelitian --}}
            <div class="mb-4">
                <label for="penelitian_id" class="block text-sm font-semibold text-purple-700">Pilih Penelitian</label>
                <select name="penelitian_id" id="penelitian_id" class="w-full px-4 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400 bg-purple-50" required>
                    <option value="">-- Pilih Penelitian --</option>
                    @foreach ($penelitians as $penelitian)
                        <option value="{{ $penelitian->id }}" data-roadmap="{{ $penelitian->id_roadmap }}">
                            {{ $penelitian->judul }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Judul Jurnal --}}
            <div class="mb-4">
                <label for="judul" class="block text-sm font-semibold text-purple-700">Judul Jurnal</label>
                <input type="text" name="judul" id="judul" class="w-full px-4 py-2 border border-purple-300 rounded-lg bg-purple-50 focus:outline-none focus:ring-2 focus:ring-purple-400" required>
            </div>

            {{-- Tahun --}}
            <div class="mb-4">
                <label for="tahun" class="block text-sm font-semibold text-purple-700">Tahun</label>
                <input type="number" name="tahun" id="tahun" class="w-full px-4 py-2 border border-purple-300 rounded-lg bg-purple-50 focus:outline-none focus:ring-2 focus:ring-purple-400" required>
            </div>

            {{-- Penulis --}}
            <div class="mb-4">
                <label for="penulis" class="block text-sm font-semibold text-purple-700">Penulis</label>
                <input type="text" name="penulis" id="penulis" class="w-full px-4 py-2 border border-purple-300 rounded-lg bg-purple-50 focus:outline-none focus:ring-2 focus:ring-purple-400">
            </div>

            {{-- Nama Jurnal --}}
            <div class="mb-4">
                <label for="penerbit" class="block text-sm font-semibold text-purple-700">Nama Jurnal</label>
                <input type="text" name="penerbit" id="penerbit" class="w-full px-4 py-2 border border-purple-300 rounded-lg bg-purple-50 focus:outline-none focus:ring-2 focus:ring-purple-400">
            </div>

            {{-- Sinta --}}
            <div class="mb-4">
                <label for="sinta" class="block text-sm font-semibold text-purple-700">Sinta</label>
                <select name="sinta" id="sinta" class="w-full px-4 py-2 border border-purple-300 rounded-lg bg-purple-50 focus:outline-none focus:ring-2 focus:ring-purple-400" required>
                    <option value="">-- Pilih index --</option>
                    <option value="Nasional">Nasional</option>
                    <option value="Nasional Terakreditasi">Nasional Terakreditasi</option>
                    <option value="Internasional">Internasional</option>
                    <option value="Internasional Bereputasi">Internasional Bereputasi</option>
                </select>
            </div>

            {{-- Link --}}
            <div class="mb-6">
                <label for="link" class="block text-sm font-semibold text-purple-700">Link Jurnal</label>
                <input type="url" name="link" id="link" class="w-full px-4 py-2 border border-purple-300 rounded-lg bg-purple-50 focus:outline-none focus:ring-2 focus:ring-purple-400">
            </div>

            {{-- Tombol Simpan --}}
            <div class="text-center">
                <button type="submit"
                    class="bg-purple-500 text-white px-6 py-2 rounded-lg shadow hover:bg-purple-600 transition duration-200 ease-in-out">
                    Simpan Jurnal
                </button>
            </div>
        </form>
    </div>

    {{-- Script Filter Penelitian --}}
    <script>
        document.getElementById('id_roadmap').addEventListener('change', function () {
            const selectedRoadmap = this.value;
            const penelitianSelect = document.getElementById('penelitian_id');

            // Reset pilihan
            penelitianSelect.value = '';
            Array.from(penelitianSelect.options).forEach(option => {
                if (!option.value) return;
                const roadmap = option.getAttribute('data-roadmap');
                option.style.display = (roadmap === selectedRoadmap) ? 'block' : 'none';
            });
        });

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
