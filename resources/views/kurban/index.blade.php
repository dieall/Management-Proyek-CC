@extends('layouts.app')

@section('title', 'Program Kurban')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Program Kurban</h1>
    @if(auth()->user()->isAdmin() || auth()->user()->isDkm())
    <a href="{{ route('kurban.create') }}" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Tambah Program Kurban</span>
    </a>
    @endif
</div>

<div class="row">
    @forelse($kurbans as $kurban)
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            {{ $kurban->nama_kurban }}
                        </div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            {{ ucfirst($kurban->jenis_hewan) }}
                        </div>
                        <div class="text-xs text-gray-600 mt-2">
                            <i class="fas fa-calendar"></i> {{ $kurban->tanggal_kurban->format('d/m/Y') }}
                        </div>
                        <div class="text-xs text-gray-600">
                            <i class="fas fa-cow"></i> {{ $kurban->total_hewan_terdaftar }}/{{ $kurban->target_hewan }} Hewan
                        </div>
                        <div class="text-xs text-gray-600">
                            <i class="fas fa-users"></i> {{ $kurban->jumlah_peserta }} Peserta
                        </div>
                        <div class="text-xs text-gray-600">
                            <i class="fas fa-money-bill-wave"></i> Rp {{ number_format($kurban->total_pembayaran, 0, ',', '.') }}
                        </div>
                        <div class="mt-2">
                            @if($kurban->status == 'aktif')
                                <span class="badge badge-success">{{ ucfirst($kurban->status) }}</span>
                            @elseif($kurban->status == 'selesai')
                                <span class="badge badge-info">{{ ucfirst($kurban->status) }}</span>
                            @else
                                <span class="badge badge-danger">{{ ucfirst($kurban->status) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-drumstick-bite fa-2x text-gray-300"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('kurban.show', $kurban->id_kurban) }}" class="btn btn-info btn-sm btn-block">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                    @if(auth()->user()->isAdmin() || auth()->user()->isDkm())
                    <div class="btn-group w-100 mt-2">
                        <a href="{{ route('kurban.edit', $kurban->id_kurban) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('kurban.destroy', $kurban->id_kurban) }}" method="POST" style="display:inline;" class="flex-fill">
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
            <i class="fas fa-info-circle"></i> Belum ada program kurban yang tersedia.
        </div>
    </div>
    @endforelse
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Kurban Saya</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('kurban.my-kurban') }}" class="btn btn-primary">
                    <i class="fas fa-history"></i> Lihat Riwayat Kurban Saya
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

