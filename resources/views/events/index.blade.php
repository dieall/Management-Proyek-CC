@extends('layouts.app')

@section('title', 'Daftar Event')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Event</h1>
    @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin() || auth()->user()->isDkm() || auth()->user()->isPanitia())
    <a href="{{ route('events.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Event
    </a>
    @endif
</div>

<!-- Event Cards -->
<div class="row">
    @forelse($events as $event)
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="card shadow h-100">
            @if($event->poster)
            <img src="{{ asset('storage/' . $event->poster) }}" class="card-img-top" alt="{{ $event->nama_kegiatan }}" style="height: 200px; object-fit: cover;">
            @else
            <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center" style="height: 200px;">
                <i class="fas fa-calendar-alt fa-5x text-white opacity-25"></i>
            </div>
            @endif
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title">{{ $event->nama_kegiatan }}</h5>
                    @if($event->status === 'published')
                        <span class="badge badge-success">Published</span>
                    @elseif($event->status === 'draft')
                        <span class="badge badge-warning">Draft</span>
                    @else
                        <span class="badge badge-danger">Cancelled</span>
                    @endif
                </div>
                
                @if($event->jenis_kegiatan)
                <p class="text-muted mb-1"><i class="fas fa-tag"></i> {{ $event->jenis_kegiatan }}</p>
                @endif
                
                @if($event->lokasi)
                <p class="text-muted mb-1"><i class="fas fa-map-marker-alt"></i> {{ $event->lokasi }}</p>
                @endif
                
                <p class="text-muted mb-2">
                    <i class="fas fa-calendar"></i> 
                    {{ $event->start_at ? $event->start_at->format('d M Y H:i') : '-' }} - 
                    {{ $event->end_at ? $event->end_at->format('d M Y H:i') : '-' }}
                </p>
                
                @if($event->kuota)
                <p class="text-muted mb-2">
                    <i class="fas fa-users"></i> 
                    {{ $event->peserta->count() }} / {{ $event->kuota }} peserta
                </p>
                @else
                <p class="text-muted mb-2">
                    <i class="fas fa-users"></i> 
                    {{ $event->peserta->count() }} peserta
                </p>
                @endif
                
                <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Oleh: {{ $event->creator->nama_lengkap ?? $event->creator->name ?? '-' }}</small>
                    <div>
                        <a href="{{ route('events.show', $event->event_id) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin() || auth()->user()->isDkm() || (auth()->user()->isPanitia() && $event->created_by == auth()->id()))
                        <a href="{{ route('events.edit', $event->event_id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endif
                        @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin() || auth()->user()->isDkm())
                        <form action="{{ route('events.destroy', $event->event_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus event ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info" role="alert">
            <i class="fas fa-info-circle"></i> Belum ada event yang tersedia.
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center">
    {{ $events->links() }}
</div>
@endsection

