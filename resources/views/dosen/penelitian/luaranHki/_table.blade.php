@if ($luarans->isEmpty())
    <p class="text-purple-400 italic">Tidak ada luaran.</p>
@else
    <div class="overflow-x-auto shadow-lg rounded-xl border border-purple-200">
        <table class="min-w-full text-sm bg-white">
            <thead>
                <tr class="bg-purple-100 text-purple-800 font-semibold text-left">
                    <th class="px-4 py-3 border-b border-purple-200">Judul Penelitian</th>
                    <th class="px-4 py-3 border-b border-purple-200">Nomor Permohonan</th>
                    <th class="px-4 py-3 border-b border-purple-200">Jenis</th>
                    <th class="px-4 py-3 border-b border-purple-200">Nama Karya</th>
                    <th class="px-4 py-3 border-b border-purple-200">Pemegang Paten</th>
                    <th class="px-4 py-3 border-b border-purple-200">Pencipta</th>
                    <th class="px-4 py-3 border-b border-purple-200">Tanggal Diterima</th>
                    <th class="px-4 py-3 border-b border-purple-200">Link</th>
                    <th class="px-4 py-3 border-b border-purple-200 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($luarans as $luaran)
                    <tr class="hover:bg-purple-50 transition">
                        <td class="px-4 py-2 border-b border-purple-100">{{ $luaran->luarable->judul }}</td>
                        <td class="px-4 py-2 border-b border-purple-100">{{ $luaran->nomor_pengajuan }}</td>
                        <td class="px-4 py-2 border-b border-purple-100">{{ $luaran->jenis }}</td>
                        <td class="px-4 py-2 border-b border-purple-100">{{ $luaran->nama_karya }}</td>
                        <td class="px-4 py-2 border-b border-purple-100">{{ $luaran->pencipta }}</td>
                        <td class="px-4 py-2 border-b border-purple-100">{{ $luaran->pemegang_hak_cipta }}</td>
                        <td class="px-4 py-2 border-b border-purple-100">{{ $luaran->tanggal_diterima }}</td>
                        <td class="px-4 py-2 border-b border-purple-100">
                            <a href="{{ $luaran->link }}" target="_blank" class="text-purple-500 hover:underline">
                                Lihat
                            </a>
                        </td>
                        <td class="px-4 py-2 border-b border-purple-100 text-center space-x-1">
                            <a href="{{ route('luaran.penelitian.hki.edit.dosen', $luaran->id) }}"
                               class="inline-flex items-center justify-center bg-purple-400 text-white w-20 h-8 rounded-md text-xs hover:bg-purple-500 transition">
                                Edit
                            </a>
                            <form action="{{ route('luaran.penelitian.hki.destroy.dosen', $luaran->id) }}"
                                method="POST" class="inline-block"
                                onsubmit="return confirm('Hapus luaran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center justify-center bg-pink-500 text-white w-20 h-8 rounded-md text-xs hover:bg-pink-600 transition mt-2">
                                    Hapus
                                </button>
                            </form>
                        </td>                                             
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
