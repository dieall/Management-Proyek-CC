@extends('layouts.app')

@section('title', 'Voting: ' . $voting->title)

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">{{ $voting->title }}</h1>
        <small class="text-muted">Dibuat pada {{ $voting->created_at->format('d F Y') }}</small>
    </div>
    <a href="{{ route('votings.index') }}" class="btn btn-secondary shadow-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Voting Status -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 {{ $voting->is_closed || ($voting->ends_at && $voting->ends_at->isPast()) ? 'bg-secondary' : 'bg-success' }} text-white">
                <h6 class="m-0 font-weight-bold">
                    @if($voting->is_closed)
                        Voting Ditutup
                    @elseif($voting->ends_at && $voting->ends_at->isPast())
                        Voting Berakhir
                    @else
                        Voting Berlangsung
                    @endif
                </h6>
            </div>
            <div class="card-body">
                @if($voting->description)
                    <p class="mb-4">{{ $voting->description }}</p>
                @endif

                <div class="row text-center mb-4">
                    <div class="col-4">
                        <h4 class="text-primary">{{ $voting->candidates->count() }}</h4>
                        <small>Kandidat</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-warning">{{ $voting->votes_count }}</h4>
                        <small>Total Suara</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-info">{{ $voting->unique_voters_count ?? 0 }}</h4>
                        <small>Pemilih Unik</small>
                    </div>
                </div>

                <!-- Voting Form (if active and user hasn't voted) -->
                @if(!$voting->is_closed && !($voting->ends_at && $voting->ends_at->isPast()) && !$voting->hasUserVoted(auth()->user()))
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                        <h6 class="m-0">Pilih Kandidat Anda</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('votings.vote', $voting->id) }}" method="POST">
                            @csrf
                            <div class="list-group">
                                @foreach($voting->candidates as $candidate)
                                <label class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $candidate->committee->full_name }}</strong>
                                        @if($candidate->committee->position)
                                            <br><small class="text-muted">{{ $candidate->committee->position->name }}</small>
                                        @endif
                                    </div>
                                    <input class="form-check-input me-1" type="radio" name="candidate_id" value="{{ $candidate->id }}" required>
                                </label>
                                @endforeach
                            </div>
                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-vote-yea"></i> Kirim Suara
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @elseif($voting->hasUserVoted(auth()->user()))
                    <div class="alert alert-info text-center">
                        <i class="fas fa-check-circle fa-3x mb-3"></i>
                        <h5>Anda sudah memberikan suara</h5>
                        <p>Terima kasih atas partisipasinya!</p>
                    </div>
                @else
                    <div class="alert alert-secondary text-center">
                        <i class="fas fa-lock fa-3x mb-3"></i>
                        <h5>Voting telah ditutup</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right: Results -->
    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Hasil Sementara</h6>
            </div>
            <div class="card-body">
                @if($voting->votes_count == 0)
                    <p class="text-center text-muted">Belum ada suara</p>
                @else
                    @foreach($voting->candidates->sortByDesc(function($c) { return $c->votes->count(); }) as $candidate)
                        @php $percentage = $voting->votes_count ? round(($candidate->votes->count() / $voting->votes_count) * 100, 1) : 0; @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $candidate->committee->full_name }}</strong>
                                <span>{{ $candidate->votes->count() }} suara ({{ $percentage }}%)</span>
                            </div>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar {{ $loop->first ? 'bg-success' : 'bg-info' }}"
                                     style="width: {{ $percentage }}%">
                                    <strong class="text-white">{{ $percentage }}%</strong>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                @if($voting->is_closed || ($voting->ends_at && $voting->ends_at->isPast()))
                    <div class="text-center mt-4">
                        <h5 class="text-success">
                            @if($voting->winner)
                                Pemenang: <strong>{{ $voting->winner->committee->full_name }}</strong>
                            @else
                                Belum ada pemenang
                            @endif
                        </h5>
                    </div>
                @endif
            </div>
        </div>

        @if(auth()->user()->can('close-voting') && !$voting->is_closed)
        <div class="card shadow mt-4 border-danger">
            <div class="card-body text-center">
                <form action="{{ route('votings.close', $voting->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tutup voting ini sekarang?')">
                        <i class="fas fa-lock"></i> Tutup Voting Sekarang
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
