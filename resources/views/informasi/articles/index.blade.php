@extends('layouts.app')

@section('title', 'Artikel & Pengumuman')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">📰 Artikel & Pengumuman</h1>
    @if(auth()->user()->isAdmin() || auth()->user()->isDkm())
        <a href="{{ route('articles.create') }}" class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Artikel</span>
        </a>
    @endif
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Artikel & Pengumuman</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Urutan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($articles as $index => $article)
                    <tr>
                        <td>{{ $articles->firstItem() + $index }}</td>
                        <td><strong>{{ $article->title }}</strong></td>
                        <td>{{ Str::limit($article->description, 100) }}</td>
                        <td>
                            <span class="badge badge-info">{{ $article->order }}</span>
                        </td>
                        <td>
                            @if($article->is_active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">Non-Aktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('articles.show', $article->id) }}" class="btn btn-info btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(auth()->user()->isAdmin() || auth()->user()->isDkm())
                                <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus artikel ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada artikel atau pengumuman</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $articles->links() }}
        </div>
    </div>
</div>
@endsection



