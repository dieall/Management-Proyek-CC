@extends('layouts.app')

@section('title', 'Detail Artikel')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Artikel</h1>
    <a href="{{ route('articles.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">{{ $article->title }}</h6>
        <span class="badge badge-{{ $article->is_active ? 'success' : 'secondary' }}">
            {{ $article->is_active ? 'Aktif' : 'Non-Aktif' }}
        </span>
    </div>
    <div class="card-body">
        @if($article->image_url)
            <div class="mb-3">
                <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="img-fluid rounded" style="max-height: 400px;">
            </div>
        @endif

        <div class="mb-3">
            <strong>Deskripsi:</strong>
            <p>{{ $article->description }}</p>
        </div>

        @if($article->content)
            <div class="mb-3">
                <strong>Konten Lengkap:</strong>
                <div class="p-3 bg-light rounded">
                    {!! nl2br(e($article->content)) !!}
                </div>
            </div>
        @endif

        @if($article->link_url)
            <div class="mb-3">
                <strong>Link Eksternal:</strong><br>
                <a href="{{ $article->link_url }}" target="_blank" class="btn btn-sm btn-info">
                    <i class="fas fa-external-link-alt"></i> Buka Link
                </a>
            </div>
        @endif

        <hr>

        <div class="row">
            <div class="col-md-6">
                <small class="text-muted">
                    <i class="fas fa-calendar"></i> Dibuat: {{ $article->created_at->format('d F Y, H:i') }}
                </small>
            </div>
            <div class="col-md-6 text-right">
                <small class="text-muted">
                    <i class="fas fa-sort"></i> Urutan: {{ $article->order }}
                </small>
            </div>
        </div>
    </div>
</div>
@endsection













