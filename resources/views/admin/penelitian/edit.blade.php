@extends('layout.admin')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Edit Penelitian</h1>
        <form action="{{ route('penelitian.update', $penelitian->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="judul" class="block font-medium">Judul</label>
                <input type="text" id="judul" name="judul" value="{{ old('judul', $penelitian->judul) }}"
                    class="w-full border rounded px-4 py-2" required>
            </div>
            <div>
                <label for="tanggal" class="block font-medium">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $penelitian->tanggal) }}"
                    class="w-full border rounded px-4 py-2" required>
            </div>
            <div>
                <label for="id_tingkat" class="block font-medium">Tingkat</label>
                <select id="id_tingkat" name="id_tingkat" class="w-full border rounded px-4 py-2">
                    @foreach ($tingkat as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $penelitian->id_tingkat ? 'selected' : '' }}>
                            {{ $item->jenis_tingkat }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="id_roadmap" class="block font-medium">Roadmap</label>
                <select id="id_roadmap" name="id_roadmap" class="w-full border rounded px-4 py-2">
                    @foreach ($roadmap as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $penelitian->id_roadmap ? 'selected' : '' }}>
                            {{ $item->jenis_roadmap }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="ketua" class="block font-medium">Ketua</label>
                <select id="ketua" name="ketua" class="w-full border rounded px-4 py-2">
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
                            href="{{ asset('storage/' . $penelitian->dokumen) }}" target="_blank" class="text-blue-500">Lihat
                            Dokumen</a></p>
                @endif
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
        </form>
        <!-- Form Tambah Luaran -->
        <h2 class="text-xl font-semibold mt-8">Tambah Luaran</h2>
        <form action="{{ route('penelitian.luaran.store', $penelitian->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <select name="tipe" class="border rounded px-4 py-2">
                <option value="jurnal">Jurnal</option>
                <option value="HKI">HKI</option>
                <option value="produk">Produk</option>
                <option value="sertifikat">Sertifikat</option>
            </select>
            <input type="file" name="dokumen" class="border rounded px-4 py-2">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
        </form>
        @if (!$penelitian->luarans->isEmpty())
        <h3 class="text-lg font-semibold mt-6">Daftar Luaran</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="py-2 px-4 border-b">Jenis</th>
                        <th class="py-2 px-4 border-b">Preview</th>
                        <th class="py-2 px-4 border-b">Nama File</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penelitian->luarans as $luaran)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4">{{ ucfirst($luaran->tipe) }}</td>
                            <td class="py-2 px-4">
                                @if (in_array(pathinfo($luaran->dokumen, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'pdf']))
                                    <a href="{{ asset('storage/' . $luaran->dokumen) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $luaran->dokumen) }}" alt="Preview" class="h-12 w-12 object-cover rounded">
                                    </a>
                                @else
                                    <span class="text-gray-500">Tidak tersedia</span>
                                @endif
                            </td>
                            <td class="py-2 px-4">
                                <a href="{{ asset('storage/' . $luaran->dokumen) }}" target="_blank" class="text-blue-500 underline">
                                    {{ basename($luaran->dokumen) }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    
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
