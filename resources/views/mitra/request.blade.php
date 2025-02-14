@extends('layout.mitra')

@section('content')
    <div class="container mx-auto">
        <h2 class="text-xl font-bold mb-4">Daftar Request</h2>

        @if($requests->isEmpty())
            <p class="text-gray-500">Belum ada request.</p>
        @else
            <table class="min-w-full bg-white shadow-md rounded">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-2 px-4">ID</th>
                        <th class="py-2 px-4">Keterangan</th>
                        <th class="py-2 px-4">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $request->id }}</td>
                            <td class="py-2 px-4">{{ $request->keterangan }}</td>
                            <td class="py-2 px-4">{{ $request->created_at->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
