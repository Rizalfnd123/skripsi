@if ($luarans->isEmpty())
    <p class="text-gray-500 italic">Tidak ada luaran.</p>
@else
    <div class="overflow-x-auto shadow rounded-lg">
        <table class="min-w-full bg-white border border-gray-300 text-sm">
            <thead>
                <tr class="bg-gray-100 text-left text-gray-700 font-semibold">
                    <th class="px-4 py-3 border-b">Judul Buku</th>
                    <th class="px-4 py-3 border-b">Judul Penelitian</th>
                    <th class="px-4 py-3 border-b">Nomor ISBN</th>
                    <th class="px-4 py-3 border-b">Tahun</th>
                    <th class="px-4 py-3 border-b">Penulis</th>
                    <th class="px-4 py-3 border-b">Nama Jurnal</th>
                    <th class="px-4 py-3 border-b">Link</th>
                    <th class="px-4 py-3 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($luarans as $luaran)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2 border-b">{{ $luaran->judul }}</td>
                        <td class="px-4 py-2 border-b">{{ $luaran->luarable->judul }}</td>
                        <td class="px-4 py-2 border-b">{{ $luaran->isbn }}</td>
                        <td class="px-4 py-2 border-b">{{ $luaran->tahun }}</td>
                        <td class="px-4 py-2 border-b">{{ $luaran->penulis }}</td>
                        <td class="px-4 py-2 border-b">{{ $luaran->penerbit }}</td>
                        <td class="px-4 py-2 border-b">
                            <a href="{{ $luaran->link }}" target="_blank" class="text-blue-500 hover:underline">
                                Lihat
                            </a>
                        </td>
                        <td class="px-4 py-2 border-b text-center">
                            <a href="{{ route('luaran.penelitian.buku.edit', $luaran->id) }}"
                                class="inline-block bg-yellow-400 text-white px-3 py-1 rounded text-xs hover:bg-yellow-500 mr-2 transition">
                                Edit
                            </a>
                            <form action="{{ route('luaran.penelitian.buku.destroy', $luaran->id) }}" method="POST" class="inline-block"
                                onsubmit="return confirm('Hapus luaran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600 transition">
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
