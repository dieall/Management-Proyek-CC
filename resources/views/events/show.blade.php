@extends('layouts.app')

@section('title', 'Detail Event')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Event</h1>
    <a href="{{ route('events.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<!-- Event Detail -->
<div class="card shadow mb-4">
    @if($event->poster)
    <img src="{{ asset('storage/' . $event->poster) }}" class="card-img-top" alt="{{ $event->nama_kegiatan }}" style="max-height: 400px; object-fit: cover;">
    @else
    <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center" style="height: 300px;">
        <i class="fas fa-calendar-alt fa-5x text-white opacity-25"></i>
    </div>
    @endif
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <h3>{{ $event->nama_kegiatan }}</h3>
            @if($event->status === 'published')
                <span class="badge badge-success badge-lg p-2">Published</span>
            @elseif($event->status === 'draft')
                <span class="badge badge-warning badge-lg p-2">Draft</span>
            @else
                <span class="badge badge-danger badge-lg p-2">Cancelled</span>
            @endif
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                @if($event->jenis_kegiatan)
                <p><strong><i class="fas fa-tag"></i> Jenis:</strong> {{ $event->jenis_kegiatan }}</p>
                @endif
                @if($event->lokasi)
                <p><strong><i class="fas fa-map-marker-alt"></i> Lokasi:</strong> {{ $event->lokasi }}</p>
                @endif
            </div>
            <div class="col-md-6">
                <p><strong><i class="fas fa-user"></i> Pembuat:</strong> {{ $event->creator->nama_lengkap ?? $event->creator->name ?? '-' }}</p>
                @if($event->kuota)
                <p><strong><i class="fas fa-users"></i> Kuota:</strong> {{ $event->peserta->count() }} / {{ $event->kuota }} peserta</p>
                @else
                <p><strong><i class="fas fa-users"></i> Peserta:</strong> {{ $event->peserta->count() }} orang</p>
                @endif
            </div>
        </div>
        
        <div class="mb-3">
            <p><strong><i class="fas fa-calendar"></i> Waktu Pelaksanaan:</strong></p>
            <p class="text-muted ml-4">
                <strong>Mulai:</strong> {{ $event->start_at ? $event->start_at->format('d F Y, H:i') : '-' }} WIB
                <br>
                <strong>Selesai:</strong> {{ $event->end_at ? $event->end_at->format('d F Y, H:i') : '-' }} WIB
            </p>
        </div>
        
        @if($event->description)
        <div class="mb-3">
            <h5><i class="fas fa-info-circle"></i> Deskripsi</h5>
            <p class="text-justify">{{ $event->description }}</p>
        </div>
        @endif
        
        @if($event->rule)
        <div class="mb-3">
            <h5><i class="fas fa-list-check"></i> Peraturan/Ketentuan</h5>
            <p class="text-justify">{{ $event->rule }}</p>
        </div>
        @endif
        
        <!-- Tombol Aksi -->
        <div class="mt-4">
            @if(auth()->user()->isJemaah() && $event->status === 'published')
                @if($isRegistered)
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> Anda sudah terdaftar di event ini.
                    </div>
                @else
                    @if($event->kuota && $event->peserta->count() >= $event->kuota)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Kuota event sudah penuh.
                        </div>
                    @else
                        <form action="{{ route('events.daftar', $event->event_id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i> Daftar Event
                            </button>
                        </form>
                    @endif
                @endif
            @endif

            @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin() || auth()->user()->isDkm() || (auth()->user()->isPanitia() && $event->created_by == auth()->id()))
                <a href="{{ route('events.peserta', $event->event_id) }}" class="btn btn-info">
                    <i class="fas fa-users"></i> Lihat Peserta ({{ $event->peserta->count() }})
                </a>
                <a href="{{ route('events.edit', $event->event_id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Event
                </a>
            @endif
            @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin() || auth()->user()->isDkm())
                <form action="{{ route('events.destroy', $event->event_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus event ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Hapus Event
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection

