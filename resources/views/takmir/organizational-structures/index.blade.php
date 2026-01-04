@extends('layouts.app')

@section('title', 'Struktur Organisasi')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Struktur Organisasi</h1>
    <a href="{{ route('organizational-structures.create') }}" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Tambah Struktur</span>
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Struktur Organisasi Masjid</h6>
    </div>
    <div class="card-body">
        @if($structures->count() > 0)
            @foreach($structures as $structure)
                @include('takmir.organizational-structures.partials.structure-item', ['structure' => $structure, 'level' => 0])
            @endforeach
        @else
            <p class="text-center">Belum ada struktur organisasi. Silakan tambah struktur baru.</p>
        @endif
    </div>
</div>
@endsection

