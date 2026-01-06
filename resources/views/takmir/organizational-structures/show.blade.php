@extends('layouts.app')

@section('title', 'Detail Struktur Organisasi')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Struktur Organisasi</h1>
    <div>
        <a href="{{ route('organizational-structures.edit', $organizationalStructure->id) }}" class="btn btn-warning btn-icon-split">
            <span class="icon text-white-50"><i class="fas fa-edit"></i></span>
            <span class="text">Edit</span>
        </a>
        <a href="{{ route('organizational-structures.index') }}" class="btn btn-secondary btn-icon-split">
            <span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
            <span class="text">Kembali</span>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Struktur</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    @if($organizationalStructure->is_division)
                        <tr>
                            <th width="200">Tipe</th>
                            <td>: Divisi/Bagian</td>
                        </tr>
                        <tr>
                            <th>Nama Divisi</th>
                            <td>: {{ $organizationalStructure->division_name }}</td>
                        </tr>
                        @if($organizationalStructure->division_description)
                        <tr>
                            <th>Deskripsi</th>
                            <td>: {{ $organizationalStructure->division_description }}</td>
                        </tr>
                        @endif
                    @else
                        <tr>
                            <th width="200">Tipe</th>
                            <td>: Posisi/Jabatan</td>
                        </tr>
                        @if($organizationalStructure->position)
                        <tr>
                            <th>Posisi</th>
                            <td>: {{ $organizationalStructure->position->name }}</td>
                        </tr>
                        @if($organizationalStructure->position->description)
                        <tr>
                            <th>Deskripsi Posisi</th>
                            <td>: {{ $organizationalStructure->position->description }}</td>
                        </tr>
                        @endif
                        @endif
                    @endif
                    <tr>
                        <th>Parent/Atasan</th>
                        <td>: {{ $organizationalStructure->parent ? ($organizationalStructure->parent->is_division ? $organizationalStructure->parent->division_name : ($organizationalStructure->parent->position->name ?? '-')) : 'Root (Tidak ada)' }}</td>
                    </tr>
                    <tr>
                        <th>Depth/Level</th>
                        <td>: {{ $organizationalStructure->depth }}</td>
                    </tr>
                    <tr>
                        <th>Order/Urutan</th>
                        <td>: {{ $organizationalStructure->order }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@if($organizationalStructure->children->count() > 0)
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Struktur Anak ({{ $organizationalStructure->children->count() }})</h6>
    </div>
    <div class="card-body">
        @foreach($organizationalStructure->children as $child)
            <div class="mb-2 p-2 border rounded">
                @if($child->is_division)
                    <strong>{{ $child->division_name }}</strong>
                @elseif($child->position)
                    <strong>{{ $child->position->name }}</strong>
                @endif
                <a href="{{ route('organizational-structures.show', $child->id) }}" class="btn btn-sm btn-info ml-2">Detail</a>
            </div>
        @endforeach
    </div>
</div>
@endif
@endsection







