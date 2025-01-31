@extends('layout.admin')

@section('title', 'Dashboard Admin')

@section('breadcrumbs')
<div class="w-full px-2">
    <h2 class="text-2xl font-bold">Welcome, {{ Auth::user()->name }}</h2>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 px-4 py-6">
    <!-- Card for Total Users -->
    <div class="bg-white shadow-md rounded-lg p-4">
        <h3 class="text-xl font-semibold text-gray-700">Total Users</h3>
        {{-- <p class="text-3xl font-bold text-blue-600">{{ $totalUsers }}</p> --}}
    </div>

    <!-- Card for Total Jurnals -->
    <div class="bg-white shadow-md rounded-lg p-4">
        <h3 class="text-xl font-semibold text-gray-700">Total Jurnals</h3>
        {{-- <p class="text-3xl font-bold text-green-600">{{ $totalJurnals }}</p> --}}
    </div>

    <!-- Card for Today's Activities -->
    <div class="bg-white shadow-md rounded-lg p-4">
        <h3 class="text-xl font-semibold text-gray-700">Today's Activities</h3>
        {{-- <p class="text-3xl font-bold text-red-600">{{ $todaysActivities }}</p> --}}
    </div>
</div>

<!-- Data Table -->
<div class="overflow-x-auto mt-6">
    <table class="min-w-full bg-white border border-gray-200 rounded-lg">
        <thead>
            <tr class="bg-gray-200">
                <th class="text-left px-4 py-2">No</th>
                <th class="text-left px-4 py-2">Nama Guru</th>
                <th class="text-left px-4 py-2">Mata Pelajaran</th>
                <th class="text-left px-4 py-2">Kelas</th>
                <th class="text-left px-4 py-2">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach($jurnals as $index => $jurnal)
            <tr class="border-t border-gray-200">
                <td class="px-4 py-2">{{ $index + 1 }}</td>
                <td class="px-4 py-2">{{ $jurnal->guru->nama }}</td>
                <td class="px-4 py-2">{{ $jurnal->mapel->nama }}</td>
                <td class="px-4 py-2">{{ $jurnal->kelas->nama }}</td>
                <td class="px-4 py-2">{{ $jurnal->tanggal }}</td>
            </tr>
            @endforeach --}}
        </tbody>
    </table>
</div>
@endsection
