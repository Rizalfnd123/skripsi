@extends('layout.dosen')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6 relative">
    <a href="{{ route('pengabdian-dosen.index') }}" 
        class="absolute top-5 right-5 bg-gray-500 text-white px-3 py-2 rounded-lg hover:bg-gray-600 transition duration-300 text-sm">
        ← Kembali
    </a>

    <h1 class="text-3xl font-bold text-gray-700 mb-6 text-center">Tambah Pengabdian</h1>
    <form action="{{ route('pengabdian-dosen.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <div>
            <label for="judul" class="block text-gray-700 font-semibold">Judul</label>
            <input type="text" id="judul" name="judul" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-300" required>
        </div>

        <div>
            <label for="tanggal" class="block text-gray-700 font-semibold">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-300" required>
        </div>

        <div>
            <label for="id_tingkat" class="block text-gray-700 font-semibold">Tingkat</label>
            <select id="id_tingkat" name="id_tingkat" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-300">
                @foreach ($tingkat as $item)
                    <option value="{{ $item->id }}">{{ $item->jenis_tingkat }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="id_roadmap" class="block text-gray-700 font-semibold">Roadmap</label>
            <select id="id_roadmap" name="id_roadmap" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-300">
                @foreach ($roadmap as $item)
                    <option value="{{ $item->id }}">{{ $item->jenis_roadmap }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="ketua" class="block text-gray-700 font-semibold">Ketua</label>
            <select id="ketua" name="ketua" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-300">
                @foreach ($dosens as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="anggota_dosen" class="block text-gray-700 font-semibold">Anggota Dosen</label>
            <select id="anggota_dosen" name="anggota_dosen[]" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-300" multiple="multiple">
                @foreach ($dosens as $dosen)
                    <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="anggota_mahasiswa" class="block text-gray-700 font-semibold">Anggota Mahasiswa</label>
            <select id="anggota_mahasiswa" name="anggota_mahasiswa[]" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-300" multiple="multiple">
                @foreach ($mahasiswa as $mhs)
                    <option value="{{ $mhs->id_mahasiswa }}">{{ $mhs->nama }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="dokumen" class="block text-gray-700 font-semibold">Dokumen</label>
            <input type="file" id="dokumen" name="dokumen" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-300">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">
            Simpan
        </button>
    </form>
</div>

{{-- Select2 Init --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('#anggota_dosen').select2({
            placeholder: "Pilih Dosen",
            allowClear: true
        });
        $('#anggota_mahasiswa').select2({
            placeholder: "Pilih Mahasiswa",
            allowClear: true
        });
    });
</script>
@endsection
