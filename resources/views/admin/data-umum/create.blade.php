@extends('layout.admin')

@section('title', 'Tambah Roadmap')

@section('breadcrumbs')
<div class="w-full px-2">
    <h2 class="text-2xl font-bold">Tambah Roadmap</h2>
</div>
@endsection

@section('content')
<form action="{{ route('roadmap.store') }}" method="POST">
    @csrf
    <div class="mb-4">
        <label for="jenis_roadmap" class="block font-bold">Jenis Roadmap</label>
        <input type="text" id="jenis_roadmap" name="jenis_roadmap" class="border rounded w-full px-2 py-1" required>
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
</form>
@endsection
