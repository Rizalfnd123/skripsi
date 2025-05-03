@extends('layout.dosen')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold text-purple-600 mb-6 text-center">Edit Jurnal</h1>

    <form action="{{ route('luaran.penelitian.jurnal.update.dosen', $luaran->id) }}" method="POST" class="bg-white p-6 shadow-lg rounded-lg">
        @csrf
        @method('PUT')

        {{-- Pilih Roadmap --}}
        <div class="mb-4">
            <label for="id_roadmap" class="block text-sm font-semibold text-purple-700">Pilih Roadmap</label>
            <select id="id_roadmap" class="w-full px-4 py-2 border rounded-lg text-purple-800" required>
                <option value="">-- Pilih Roadmap --</option>
                <option value="1">Pembelajaran Domain TIK</option>
                <option value="2">Pembelajaran Berbantuan TIK</option>
                <option value="3">Informatika Terapan</option>
            </select>
        </div>

        {{-- Pilih Penelitian --}}
        <div class="mb-4">
            <label for="penelitian_id" class="block text-sm font-semibold text-purple-700">Pilih Penelitian</label>
            <select name="penelitian_id" id="penelitian_id" class="w-full px-4 py-2 border rounded-lg text-purple-800" required>
                @foreach($penelitians as $penelitian)
                    <option value="{{ $penelitian->id }}"
                        data-roadmap="{{ $penelitian->id_roadmap }}"
                        {{ $penelitian->id == $luaran->penelitian_id ? 'selected' : '' }}>
                        {{ $penelitian->judul }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Judul --}}
        <div class="mb-4">
            <label for="judul" class="block text-sm font-semibold text-purple-700">Judul Jurnal</label>
            <input type="text" name="judul" id="judul" value="{{ $luaran->judul }}" class="w-full px-4 py-2 border rounded-lg text-purple-800" required>
        </div>

        {{-- Tahun --}}
        <div class="mb-4">
            <label for="tahun" class="block text-sm font-semibold text-purple-700">Tahun</label>
            <input type="number" name="tahun" id="tahun" value="{{ $luaran->tahun }}" class="w-full px-4 py-2 border rounded-lg text-purple-800" required>
        </div>

        {{-- Penulis --}}
        <div class="mb-4">
            <label for="penulis" class="block text-sm font-semibold text-purple-700">Penulis</label>
            <input type="text" name="penulis" id="penulis" value="{{ $luaran->penulis }}" class="w-full px-4 py-2 border rounded-lg text-purple-800" required>
        </div>

        {{-- Nama Jurnal --}}
        <div class="mb-4">
            <label for="penerbit" class="block text-sm font-semibold text-purple-700">Nama Jurnal</label>
            <input type="text" name="penerbit" id="penerbit" value="{{ $luaran->penerbit }}" class="w-full px-4 py-2 border rounded-lg text-purple-800">
        </div>

        {{-- Sinta --}}
        <div class="mb-4">
            <label for="sinta" class="block text-sm font-semibold text-purple-700">Index</label>
            <select name="sinta" id="sinta" class="w-full px-4 py-2 border rounded-lg text-purple-800" required>
                <option value="">-- Pilih index --</option>
                <option value="Nasional" {{ $luaran->sinta == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                <option value="Nasional Terakreditasi" {{ $luaran->sinta == 'Nasional Terakreditasi' ? 'selected' : '' }}>Nasional Terakreditasi</option>
                <option value="Internasional" {{ $luaran->sinta == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                <option value="Internasional Bereputasi" {{ $luaran->sinta == 'Internasional Bereputasi' ? 'selected' : '' }}>Internasional Bereputasi</option>
            </select>
        </div>

        {{-- Link --}}
        <div class="mb-4">
            <label for="link" class="block text-sm font-semibold text-purple-700">Link Jurnal</label>
            <input type="url" name="link" id="link" value="{{ $luaran->link }}" class="w-full px-4 py-2 border rounded-lg text-purple-800">
        </div>

        {{-- Tombol Submit --}}
        <div class="mb-4">
            <button type="submit" class="bg-purple-500 text-white px-6 py-2 rounded-lg shadow hover:bg-purple-600 transition">
                Update Jurnal
            </button>
        </div>
    </form>
</div>

{{-- Script filter roadmap --}}
<script>
    document.getElementById('id_roadmap').addEventListener('change', function() {
        const selectedRoadmap = this.value;
        const penelitianSelect = document.getElementById('penelitian_id');

        Array.from(penelitianSelect.options).forEach(option => {
            if (!option.value) return;
            const roadmap = option.getAttribute('data-roadmap');
            option.style.display = (roadmap === selectedRoadmap) ? 'block' : 'none';
        });

        penelitianSelect.value = '';
    });

    // Inisialisasi: sembunyikan opsi yang tidak sesuai roadmap dari penelitian yang sedang dipilih
    window.addEventListener('DOMContentLoaded', () => {
        const penelitianSelect = document.getElementById('penelitian_id');
        const selectedOption = penelitianSelect.querySelector('option:checked');
        const selectedRoadmap = selectedOption ? selectedOption.getAttribute('data-roadmap') : '';
        const roadmapSelect = document.getElementById('id_roadmap');
        roadmapSelect.value = selectedRoadmap;

        Array.from(penelitianSelect.options).forEach(option => {
            if (option.value) {
                option.style.display = (option.getAttribute('data-roadmap') === selectedRoadmap) ? 'block' : 'none';
            }
        });
    });
</script>
@endsection
