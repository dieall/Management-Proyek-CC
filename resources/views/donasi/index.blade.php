@extends('layouts.app')

@section('title', 'Program Donasi')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Program Donasi</h1>
    @if(auth()->user()->isAdmin() || auth()->user()->isDkm())
    <a href="{{ route('donasi.create') }}" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Tambah Program Donasi</span>
    </a>
    @endif
</div>

<div class="row">
    @forelse($donasis as $donasi)
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            {{ $donasi->nama_donasi }}
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($donasi->total_terkumpul, 0, ',', '.') }}
                        </div>
                        <div class="text-xs text-gray-600 mt-2">
                            <i class="fas fa-calendar"></i> {{ $donasi->tanggal_mulai->format('d/m/Y') }}
                            @if($donasi->tanggal_selesai)
                            - {{ $donasi->tanggal_selesai->format('d/m/Y') }}
                            @endif
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hand-holding-heart fa-2x text-gray-300"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('donasi.show', $donasi->id_donasi) }}" class="btn btn-info btn-sm btn-block">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                    @if(auth()->user()->isAdmin() || auth()->user()->isDkm())
                    <div class="btn-group w-100 mt-2">
                        <a href="{{ route('donasi.edit', $donasi->id_donasi) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('donasi.destroy', $donasi->id_donasi) }}" method="POST" style="display:inline;" class="flex-fill">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Yakin ingin menghapus?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Belum ada program donasi yang tersedia.
        </div>
    </div>
    @endforelse
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Donasi Saya</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('donasi.my-donations') }}" class="btn btn-primary">
                    <i class="fas fa-history"></i> Lihat Riwayat Donasi Saya
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

