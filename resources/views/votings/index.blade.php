@extends('layouts.app')

@section('title', 'Voting Jabatan')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Voting Jabatan</h1>
    <a href="{{ route('votings.create') }}" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Buat Voting Baru
    </a>
</div>

<!-- Voting List -->
<div class="card shadow">
    <div class="card-body">
        @if($votings->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul Voting</th>
                            <th>Jabatan</th>
                            <th>Kandidat</th>
                            <th>Status</th>
                            <th>Total Suara</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($votings as $voting)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $voting->title }}</strong>
                                @if($voting->description)
                                    <br><small class="text-muted">{{ Str::limit($voting->description, 60) }}</small>
                                @endif
                            </td>
                            <td>
                                @if($voting->position)
                                    <span class="badge badge-info">{{ $voting->position->name }}</span>
                                @else
                                    <span class="text-muted">Semua Jabatan</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-primary">{{ $voting->candidates->count() }}</span>
                            </td>
                            <td>
                                @if($voting->is_closed)
                                    <span class="badge badge-secondary">Ditutup</span>
                                @elseif($voting->ends_at && $voting->ends_at->isPast())
                                    <span class="badge badge-danger">Berakhir</span>
                                @else
                                    <span class="badge badge-success">Berlangsung</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge badge-warning">
                                    <i class="fas fa-vote-yea"></i> {{ $voting->votes_count }}
                                </span>
                            </td>
                            <td>{{ $voting->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('votings.show', $voting->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(!$voting->is_closed && auth()->user()->can('close-voting'))
                                        <form action="{{ route('votings.close', $voting->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tutup voting ini?')">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-vote-yea fa-4x text-muted mb-4"></i>
                <h5>Belum ada voting</h5>
                <p class="text-muted">Mulai buat voting untuk pemilihan jabatan pengurus.</p>
                <a href="{{ route('votings.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Buat Voting Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
