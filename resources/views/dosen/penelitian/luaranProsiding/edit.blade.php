@extends('layout.dosen')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Edit Prosiding</h1>

        <form action="{{ route('luaran.penelitian.prosiding.update.dosen', $luaran->id) }}" method="POST" class="bg-white p-6 shadow rounded-lg">
            @csrf
            @method('PUT')

            {{-- Pilih Penelitian --}}
            <div class="mb-4">
                <label for="penelitian_id" class="block text-sm font-semibold text-gray-700">Pilih Penelitian</label>
                <select name="penelitian_id" id="penelitian_id" class="w-full px-4 py-2 border rounded-lg" required disabled>
                    @foreach($penelitians as $penelitian)
                        <option value="{{ $penelitian->id }}" {{ $penelitian->id == $luaran->penelitian_id ? 'selected' : '' }}>
                            {{ $penelitian->judul }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="nama_konferensi" class="block text-sm font-semibold text-gray-700">Nama Konferensi</label>
                <input type="text" name="nama_konferensi" id="nama_konferensi" value="{{ $luaran->nama_konferensi }}" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="tempat_konferensi" class="block text-sm font-semibold text-gray-700">Tempat Konferensi</label>
                <input type="text" name="tempat_konferensi" id="tempat_konferensi" value="{{ $luaran->tempat_konferensi }}" class="w-full px-4 py-2 border rounded-lg" required>
            </div>
            
            <div class="mb-4">
                <label for="tgl_konferensi" class="block text-sm font-semibold text-gray-700">Tanggal Konferensi</label>
                <input type="date" name="tgl_konferensi" id="tgl_konferensi" value="{{ $luaran->tgl_konferensi }}" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="penyelenggara" class="block text-sm font-semibold text-gray-700">Nama Penyelenggara</label>
                <input type="text" name="penyelenggara" id="penyelenggara" value="{{ $luaran->penyelenggara }}" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            {{-- Judul --}}
            <div class="mb-4">
                <label for="judul" class="block text-sm font-semibold text-gray-700">Judul Jurnal</label>
                <input type="text" name="judul" id="judul" value="{{ $luaran->judul }}" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            {{-- Tahun --}}
            <div class="mb-4">
                <label for="tahun" class="block text-sm font-semibold text-gray-700">Tahun</label>
                <input type="number" name="tahun" id="tahun" value="{{ $luaran->tahun }}" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            {{-- penulis --}}
            <div class="mb-4">
                <label for="penulis" class="block text-sm font-semibold text-gray-700">Penulis</label>
                <input type="text" name="penulis" id="penulis" value="{{ $luaran->penulis }}" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            {{-- Nama Jurnal --}}
            <div class="mb-4">
                <label for="penerbit" class="block text-sm font-semibold text-gray-700">Nama Jurnal</label>
                <input type="text" name="penerbit" id="penerbit" value="{{ $luaran->penerbit }}" class="w-full px-4 py-2 border rounded-lg">
            </div>

            {{-- Sinta --}}
            <div class="mb-4">
                <label for="sinta" class="block text-sm font-semibold text-gray-700">Sinta</label>
                <input type="text" name="sinta" id="sinta" value="{{ $luaran->sinta }}" class="w-full px-4 py-2 border rounded-lg">
            </div>

            {{-- Link --}}
            <div class="mb-4">
                <label for="link" class="block text-sm font-semibold text-gray-700">Link Jurnal</label>
                <input type="url" name="link" id="link" value="{{ $luaran->link }}" class="w-full px-4 py-2 border rounded-lg">
            </div>

            {{-- Tombol Submit --}}
            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                    Update Prosiding
                </button>
            </div>
        </form>
    </div>
@endsection
