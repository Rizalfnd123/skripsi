@extends('layout.mitra')

@section('content')
<div class="container mx-auto mt-6">
    <h2 class="text-2xl font-bold mb-4">Daftar Penelitian</h2>
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-300 px-4 py-2">Judul</th>
                <th class="border border-gray-300 px-4 py-2">Tanggal</th>
                <th class="border border-gray-300 px-4 py-2">Tingkat</th>
                <th class="border border-gray-300 px-4 py-2">Roadmap</th>
                <th class="border border-gray-300 px-4 py-2">Ketua</th>
                <th class="border border-gray-300 px-4 py-2">Dana</th>
                <th class="border border-gray-300 px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penelitians as $penelitian)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $penelitian->judul }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $penelitian->tanggal }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $penelitian->tingkat->jenis_tingkat ?? '-' }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $penelitian->roadmap->jenis_roadmap ?? '-' }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $penelitian->ketuaDosen->nama ?? '-' }}</td>
                    <td class="border border-gray-300 px-4 py-2">Rp {{ number_format($penelitian->dana, 0, ',', '.') }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">
                        <button onclick="openModal('{{ $penelitian->id }}', '{{ $penelitian->judul }}')"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Request
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Modal -->
    <div id="requestModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded shadow-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Request Penelitian</h2>
            <form action="{{ route('request.store') }}" method="POST">
                @csrf
                <input type="hidden" id="id_penelitian" name="id_penelitian">
                <input type="hidden" id="id_mitra" name="id_mitra" value="{{ auth('mitra')->check() ? auth('mitra')->user()->id : '' }}">
            
                <div class="mb-3">
                    <label class="block text-sm font-medium">Nama Mitra</label>
                    <input type="text" value="{{ auth('mitra')->check() ? auth('mitra')->user()->nama : '' }}" disabled
                        class="w-full px-3 py-2 border rounded bg-gray-100">
                </div>
            
                <div class="mb-3">
                    <label class="block text-sm font-medium">No HP</label>
                    <input type="text" value="{{ auth('mitra')->check() ? auth('mitra')->user()->no_hp : '' }}" disabled
                        class="w-full px-3 py-2 border rounded bg-gray-100">
                </div>
            
                <div class="mb-3">
                    <label class="block text-sm font-medium">Penelitian</label>
                    <input type="text" id="judul_penelitian" disabled
                        class="w-full px-3 py-2 border rounded bg-gray-100">
                </div>
            
                <div class="mb-3">
                    <label class="block text-sm font-medium">Keterangan</label>
                    <textarea name="keterangan" class="w-full px-3 py-2 border rounded" rows="3"></textarea>
                </div>
            
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 border rounded bg-gray-300 hover:bg-gray-400">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Kirim</button>
                </div>
            </form>
            
            
        </div>
    </div>
    
    <script>
        function openModal(id, judul) {
            document.getElementById('id_penelitian').value = id;
            document.getElementById('judul_penelitian').value = judul;
            document.getElementById('requestModal').classList.remove('hidden');
        }
    
        function closeModal() {
            document.getElementById('requestModal').classList.add('hidden');
        }
    </script>
      
</div>
@endsection
