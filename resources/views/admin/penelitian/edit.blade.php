@extends('layout.admin')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold text-gray-700">Edit Penelitian</h1>
                <a href="{{ route('penelitian.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
            </div>
            <form action="{{ route('penelitian.update', $penelitian->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="judul" class="block font-medium">Judul</label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul', $penelitian->judul) }}"
                        class="w-full border rounded px-4 py-2 focus:ring focus:ring-blue-300" required>
                </div>
                <div>
                    <label for="tanggal" class="block font-medium">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $penelitian->tanggal) }}"
                        class="w-full border rounded px-4 py-2 focus:ring focus:ring-blue-300" required>
                </div>
                <div>
                    <label for="id_tingkat" class="block font-medium">Tingkat</label>
                    <select id="id_tingkat" name="id_tingkat"
                        class="w-full border rounded px-4 py-2 focus:ring focus:ring-blue-300">
                        @foreach ($tingkat as $item)
                            <option value="{{ $item->id }}"
                                {{ $item->id == $penelitian->id_tingkat ? 'selected' : '' }}>
                                {{ $item->jenis_tingkat }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="id_roadmap" class="block font-medium">Roadmap</label>
                    <select id="id_roadmap" name="id_roadmap"
                        class="w-full border rounded px-4 py-2 focus:ring focus:ring-blue-300">
                        @foreach ($roadmap as $item)
                            <option value="{{ $item->id }}"
                                {{ $item->id == $penelitian->id_roadmap ? 'selected' : '' }}>
                                {{ $item->jenis_roadmap }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="ketua" class="block font-medium">Ketua</label>
                    <select id="ketua" name="ketua"
                        class="w-full border rounded px-4 py-2 focus:ring focus:ring-blue-300">
                        @foreach ($dosens as $item)
                            <option value="{{ $item->id }}" {{ $item->id == $penelitian->ketua ? 'selected' : '' }}>
                                {{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="anggota_dosen" class="block font-medium">Anggota Dosen</label>
                    <select id="anggota_dosen" name="anggota_dosen[]" class="w-full border rounded px-4 py-2"
                        multiple="multiple">
                        @foreach ($dosens as $dosen)
                            <option value="{{ $dosen->id }}"
                                {{ in_array($dosen->id, $anggotaDosenIds) ? 'selected' : '' }}>
                                {{ $dosen->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
    
                <div>
                    <label for="anggota_mahasiswa" class="block font-medium">Anggota Mahasiswa</label>
                    <select id="anggota_mahasiswa" name="anggota_mahasiswa[]" class="w-full border rounded px-4 py-2"
                        multiple="multiple">
                        @foreach ($mahasiswa as $mhs)
                            <option value="{{ $mhs->id_mahasiswa }}"
                                {{ in_array($mhs->id_mahasiswa, $anggotaMahasiswaIds) ? 'selected' : '' }}>
                                {{ $mhs->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="dokumen" class="block font-medium">Dokumen</label>
                    <input type="file" id="dokumen" name="dokumen" class="w-full border rounded px-4 py-2">
                    @if ($penelitian->dokumen)
                        <p class="mt-2 text-sm text-gray-500">Dokumen Saat Ini: <a
                                href="{{ asset('storage/' . $penelitian->dokumen) }}" target="_blank"
                                class="text-blue-500 underline">Lihat Dokumen</a></p>
                    @endif
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
            </form>
            <!-- Form Tambah Luaran -->
            {{-- <div class="bg-white shadow-md rounded-lg p-6 mt-8">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">Tambah Luaran</h2>
                <form action="{{ route('penelitian.luaran.store', $penelitian->id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-gray-600 font-medium">Jenis Luaran</label>
                        <select name="tipe" class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200">
                            <option value="jurnal">Jurnal</option>
                            <option value="HKI">HKI</option>
                            <option value="produk">Produk</option>
                            <option value="sertifikat">Sertifikat</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-600 font-medium">Unggah Dokumen</label>
                        <input type="file" name="dokumen"
                            class="w-full border rounded-lg px-4 py-2 bg-gray-50 focus:ring focus:ring-blue-200">
                    </div>
                    <button type="submit"
                        class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold shadow-md transition">
                        Simpan
                    </button>
                </form>
            </div> --}}
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#anggota_dosen').select2({
                placeholder: "Pilih Anggota Dosen",
                allowClear: true
            });

            $('#anggota_mahasiswa').select2({
                placeholder: "Pilih Anggota Mahasiswa",
                allowClear: true
            });
        });
    </script>
@endsection
