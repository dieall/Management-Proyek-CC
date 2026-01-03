@extends('layouts.app')

@section('title', 'Struktur Organisasi')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Struktur Organisasi</h1>
    <div>
        <a href="{{ route('positions.index') }}" class="btn btn-secondary shadow-sm mr-2">
            <i class="fas fa-list"></i> Tampilan Daftar
        </a>
        <a href="{{ route('positions.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus"></i> Tambah Jabatan
        </a>
    </div>
</div>

<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Diagram Hierarki Jabatan</h6>
    </div>
    <div class="card-body">
        <div class="org-chart">
            @foreach($positions as $root)
                <div class="org-node root-node text-center mb-5">
                    <div class="position-card shadow">
                        <div class="card-header bg-gradient-primary text-white">
                            <h5 class="mb-1">{{ $root->name }}</h5>
                            <small><i class="fas fa-users"></i> {{ $root->committees_count }} Pengurus</small>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                @switch($root->level)
                                    @case('leadership') <span class="badge badge-danger">Kepemimpinan</span> @break
                                    @case('division_head') <span class="badge badge-warning">Kepala Divisi</span> @break
                                    @case('staff') <span class="badge badge-primary">Staf</span> @break
                                    @default <span class="badge badge-secondary">Relawan</span>
                                @endswitch
                                <br>
                                <span class="badge badge-{{ $root->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ $root->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('positions.show', $root->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('positions.edit', $root->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                            </div>
                        </div>
                    </div>

                    @if($root->children->count() > 0)
                        <div class="children mt-4">
                            <div class="connector-line"></div>
                            <div class="row justify-content-center">
                                @foreach($root->children as $child)
                                    <div class="col-md-{{ 12 / max(1, $root->children->count()) }} mb-4">
                                        <div class="position-card shadow-sm">
                                            <div class="card-header bg-info text-white">
                                                <h6 class="mb-1">{{ $child->name }}</h6>
                                                <small><i class="fas fa-users"></i> {{ $child->committees_count }}</small>
                                            </div>
                                            <div class="card-body py-2">
                                                <div class="btn-group btn-group-sm w-100">
                                                    <a href="{{ route('positions.show', $child->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                                    <a href="{{ route('positions.edit', $child->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                        @if($child->children->count() > 0)
                                            <div class="grandchildren mt-3">
                                                <div class="connector-line small"></div>
                                                <div class="d-flex flex-wrap justify-content-center gap-2">
                                                    @foreach($child->children as $grandchild)
                                                        <div class="position-mini">
                                                            <div class="text-center p-2 border rounded bg-light">
                                                                <strong class="small d-block">{{ $grandchild->name }}</strong>
                                                                <small class="text-muted">{{ $grandchild->committees_count }} pengurus</small>
                                                                <div class="mt-1">
                                                                    <a href="{{ route('positions.show', $grandchild->id) }}" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                @if(!$loop->last)<hr class="my-5"> @endif
            @endforeach
        </div>

        <!-- Legend -->
        <div class="mt-5 pt-4 border-top">
            <h6 class="font-weight-bold text-primary mb-3">Keterangan Level</h6>
            <div class="row">
                <div class="col-md-3"><span class="badge badge-danger">Kepemimpinan</span> <small>- Pimpinan tertinggi</small></div>
                <div class="col-md-3"><span class="badge badge-warning">Kepala Divisi</span> <small>- Pengelola divisi</small></div>
                <div class="col-md-3"><span class="badge badge-primary">Staf</span> <small>- Anggota tetap</small></div>
                <div class="col-md-3"><span class="badge badge-secondary">Relawan</span> <small>- Sukarelawan</small></div>
            </div>
        </div>
    </div>
</div>

<style>
.org-chart { position: relative; }
.position-card { transition: all 0.3s; max-width: 280px; margin: 0 auto; }
.position-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important; }
.connector-line { height: 40px; width: 2px; background: #dee2e6; margin: 0 auto; }
.connector-line.small { height: 20px; }
.position-mini { min-width: 140px; }
</style>
@endsection
