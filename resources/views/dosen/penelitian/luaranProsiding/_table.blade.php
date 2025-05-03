@if ($luarans->isEmpty())
    <p class="text-purple-400 italic">Tidak ada luaran.</p>
@else
    <div class="overflow-x-auto shadow-lg rounded-xl border border-purple-200">
        <table class="min-w-full text-sm bg-white">
            <thead>
                <tr class="bg-purple-100 text-left text-purple-800 font-semibold">
                    <th class="px-4 py-3 border-b border-purple-200">Nama Konferensi</th>
                    <th class="px-4 py-3 border-b border-purple-200">Penyelenggara</th>
                    <th class="px-4 py-3 border-b border-purple-200">Judul Penelitian</th>
                    <th class="px-4 py-3 border-b border-purple-200">Judul Jurnal</th>
                    <th class="px-4 py-3 border-b border-purple-200">Tahun</th>
                    <th class="px-4 py-3 border-b border-purple-200">Penulis</th>
                    <th class="px-4 py-3 border-b border-purple-200">Link</th>
                    <th class="px-4 py-3 border-b border-purple-200 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($luarans as $luaran)
                    <tr class="hover:bg-purple-50 transition">
                        <td class="px-4 py-2 border-b border-purple-100">{{ $luaran->nama_konferensi }}</td>
                        <td class="px-4 py-2 border-b border-purple-100">{{ $luaran->penyelenggara }}</td>
                        <td class="px-4 py-2 border-b border-purple-100">{{ $luaran->luarable->judul }}</td>
                        <td class="px-4 py-2 border-b border-purple-100">{{ $luaran->judul }}</td>
                        <td class="px-4 py-2 border-b border-purple-100">{{ $luaran->tahun }}</td>
                        <td class="px-4 py-2 border-b border-purple-100">{{ $luaran->penulis }}</td>
                        <td class="px-4 py-2 border-b border-purple-100">
                            <a href="{{ $luaran->link }}" target="_blank" class="text-purple-500 hover:underline">
                                Lihat
                            </a>
                        </td>
                        <td class="px-4 py-2 border-b border-purple-100 text-center space-x-1">
                            <a href="{{ route('luaran.penelitian.prosiding.edit.dosen', $luaran->id) }}"
                               class="inline-block bg-yellow-400 text-white px-3 py-1 rounded text-xs hover:bg-yellow-500 transition">
                                Edit
                            </a>
                            <form action="{{ route('luaran.penelitian.prosiding.destroy.dosen', $luaran->id) }}"
                                  method="POST" class="inline-block"
                                  onsubmit="return confirm('Hapus luaran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600 transition mt-2">
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
