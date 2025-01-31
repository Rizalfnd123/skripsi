@extends('layout.admin')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Tambah Penelitian</h1>
        <form action="{{ route('penelitian.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label for="judul" class="block font-medium">Judul</label>
                <input type="text" id="judul" name="judul" class="w-full border rounded px-4 py-2" required>
            </div>
            <div>
                <label for="tanggal" class="block font-medium">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" class="w-full border rounded px-4 py-2" required>
            </div>
            <div>
                <label for="id_tingkat" class="block font-medium">Tingkat</label>
                <select id="id_tingkat" name="id_tingkat" class="w-full border rounded px-4 py-2">
                    @foreach ($tingkat as $item)
                        <option value="{{ $item->id }}">{{ $item->jenis_tingkat }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="id_roadmap" class="block font-medium">Roadmap</label>
                <select id="id_roadmap" name="id_roadmap" class="w-full border rounded px-4 py-2">
                    @foreach ($roadmap as $item)
                        <option value="{{ $item->id }}">{{ $item->jenis_roadmap }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="ketua" class="block font-medium">Ketua</label>
                <select id="ketua" name="ketua" class="w-full border rounded px-4 py-2">
                    @foreach ($dosens as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="anggota_dosen" class="block font-medium">Anggota Dosen</label>
                <select id="anggota_dosen" name="anggota_dosen[]" class="w-full border rounded px-4 py-2"
                    multiple="multiple">
                    @foreach ($dosens as $dosen)
                        <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                    @endforeach
                </select>
                {{-- <button type="button" id="addDosen" class="text-blue-500">+ Tambah Anggota Dosen</button> --}}
            </div>
            <div>
                <label for="anggota_mahasiswa" class="block font-medium">Anggota Mahasiswa</label>
                <select id="anggota_mahasiswa" name="anggota_mahasiswa[]" class="w-full border rounded px-4 py-2"
                    multiple="multiple">
                    @foreach ($mahasiswa as $mhs)
                        <option value="{{ $mhs->id_mahasiswa }}">{{ $mhs->nama }}</option>
                    @endforeach
                </select>
                {{-- <button type="button" id="addDosen" class="text-blue-500">+ Tambah Anggota Dosen</button> --}}
            </div>
            <div>
                <label for="dokumen" class="block font-medium">Dokumen</label>
                <input type="file" id="dokumen" name="dokumen" class="w-full border rounded px-4 py-2">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('#anggota_dosen').select2({
                placeholder: "Pilih Dosen",
                allowClear: true
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            $('#anggota_mahasiswa').select2({
                placeholder: "Pilih Mahasiswa",
                allowClear: true
            });
        });
    </script>
@endsection
