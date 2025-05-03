@extends('layout.admin')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold text-gray-700 mb-6">📌 Daftar Request</h2>

        @if ($requests->isEmpty())
            <p class="text-gray-500 italic">Belum ada request.</p>
        @else
            @if (session('success'))
                <div class="bg-green-100 text-green-700 text-sm font-semibold px-4 py-3 rounded mb-4 border border-green-300">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                <table class="min-w-full border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="bg-gray-700 text-white">
                            <th class="py-3 px-4 text-left">No</th>
                            <th class="py-3 px-4 text-left">Tanggal</th>
                            <th class="py-3 px-4 text-left">Mitra</th>
                            <th class="py-3 px-4 text-left">No HP</th>
                            <th class="py-3 px-4 text-left">Masalah</th>
                            <th class="py-3 px-4 text-left">Harapan</th>
                            <th class="py-3 px-4 text-left">Domain</th>
                            <th class="py-3 px-4 text-left">Jenis Pengabdian</th>
                            <th class="py-3 px-4 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requests as $index => $request)
                            <tr class="border-b hover:bg-gray-100 transition">
                                <td class="py-3 px-4">{{ $index + 1 }}</td>
                                <td class="py-3 px-4">{{ \Carbon\Carbon::parse($request->created_at)->translatedFormat('l, d F Y') }}</td>
                                <td class="py-3 px-4">{{ $request->mitra->nama ?? 'Tidak Ada' }}</td>
                                <td class="py-3 px-4">{{ $request->mitra->no_hp }}</td>
                                <td class="py-3 px-4">{{ $request->masalah }}</td>
                                <td class="py-3 px-4">{{ $request->harapan ?? 'Tidak Ada' }}</td>
                                <td class="py-3 px-4">{{ $request->domain ?? 'Tidak Ada' }}</td>
                                <td class="py-3 px-4">{{ $request->jenis_pengabdian ?? 'Tidak Ada' }}</td>
                                <td class="py-3 px-4">
                                    <select
                                        class="status-dropdown bg-gray-200 text-gray-700 text-sm font-semibold px-3 py-2 rounded border border-gray-300 focus:ring focus:ring-green-300 transition"
                                        data-id="{{ $request->id }}">
                                        <option value="Diterima" {{ $request->status == 'Diterima' ? 'selected' : '' }}>✅ Diterima</option>
                                        <option value="Diajukan" {{ $request->status == 'Diajukan' ? 'selected' : '' }}>⏳ Diajukan</option>
                                        <option value="Ditolak" {{ $request->status == 'Ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <script>
        document.querySelectorAll('.status-dropdown').forEach(select => {
            select.addEventListener('change', function() {
                let requestId = this.getAttribute('data-id');
                let newStatus = this.value;

                fetch(`/update-status/${requestId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            status: newStatus
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
@endsection
