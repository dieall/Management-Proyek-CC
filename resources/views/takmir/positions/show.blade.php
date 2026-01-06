@extends('layouts.app')

@section('title', 'Detail Posisi')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Posisi/Jabatan</h1>
    <div>
        <a href="{{ route('positions.edit', $position->id) }}" class="btn btn-warning btn-icon-split">
            <span class="icon text-white-50"><i class="fas fa-edit"></i></span>
            <span class="text">Edit</span>
        </a>
        <a href="{{ route('positions.index') }}" class="btn btn-secondary btn-icon-split">
            <span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
            <span class="text">Kembali</span>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Posisi</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Nama Posisi</th>
                        <td>: {{ $position->name }}</td>
                    </tr>
                    <tr>
                        <th>Slug</th>
                        <td>: {{ $position->slug }}</td>
                    </tr>
                    <tr>
                        <th>Level</th>
                        <td>: 
                            @if($position->level == 'leadership')
                                <span class="badge badge-danger">Pimpinan</span>
                            @elseif($position->level == 'member')
                                <span class="badge badge-info">Anggota</span>
                            @else
                                <span class="badge badge-secondary">Staf</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Parent Posisi</th>
                        <td>: {{ $position->parent->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>: 
                            @if($position->status == 'active')
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Order</th>
                        <td>: {{ $position->order }}</td>
                    </tr>
                    @if($position->description)
                    <tr>
                        <th>Deskripsi</th>
                        <td>: {{ $position->description }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>

@if($position->committees->count() > 0)
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Pengurus dengan Posisi Ini ({{ $position->committees->count() }})</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($position->committees as $committee)
                    <tr>
                        <td><a href="{{ route('committees.show', $committee->id) }}">{{ $committee->full_name }}</a></td>
                        <td>{{ $committee->email ?? '-' }}</td>
                        <td>{{ $committee->phone_number ?? '-' }}</td>
                        <td>
                            @if($committee->active_status == 'active')
                                <span class="badge badge-success">Aktif</span>
                            @elseif($committee->active_status == 'inactive')
                                <span class="badge badge-secondary">Tidak Aktif</span>
                            @else
                                <span class="badge badge-danger">Mengundurkan Diri</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

@if($position->jobResponsibilities->count() > 0)
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tugas dan Tanggung Jawab ({{ $position->jobResponsibilities->count() }})</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Tugas</th>
                        <th>Prioritas</th>
                        <th>Frekuensi</th>
                        <th>Core Responsibility</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($position->jobResponsibilities as $job)
                    <tr>
                        <td>{{ $job->task_name }}</td>
                        <td>
                            @if($job->priority == 'critical')
                                <span class="badge badge-danger">Kritis</span>
                            @elseif($job->priority == 'high')
                                <span class="badge badge-warning">Tinggi</span>
                            @elseif($job->priority == 'medium')
                                <span class="badge badge-info">Sedang</span>
                            @else
                                <span class="badge badge-secondary">Rendah</span>
                            @endif
                        </td>
                        <td>{{ ucfirst($job->frequency) }}</td>
                        <td>
                            @if($job->is_core_responsibility)
                                <span class="badge badge-primary">Ya</span>
                            @else
                                <span class="badge badge-secondary">Tidak</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection







