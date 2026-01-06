@extends('layouts.app')

@section('title', 'ZIS Masuk')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">ZIS Masuk (Zakat, Infaq, Shadaqah, Wakaf)</h1>
    <a href="{{ route('zis-masuk.create') }}" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Input ZIS</span>
    </a>
</div>

<!-- Statistik -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total ZIS</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalZIS, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hand-holding-usd fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Zakat</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalZakat, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-mosque fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Infaq</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalInfaq, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hand-holding-heart fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Shadaqah + Wakaf</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalShadaqah + $totalWakaf, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-donate fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar ZIS Masuk</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Muzakki</th>
                        <th>Jenis ZIS</th>
                        <th>Sub Jenis</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($zisMasuk as $index => $zis)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $zis->tgl_masuk ? $zis->tgl_masuk->format('d/m/Y') : '-' }}</td>
                        <td>{{ $zis->muzakki->nama ?? '-' }}</td>
                        <td>
                            <span class="badge badge-{{ $zis->jenis_zis == 'zakat' ? 'primary' : ($zis->jenis_zis == 'infaq' ? 'success' : ($zis->jenis_zis == 'shadaqah' ? 'warning' : 'info')) }}">
                                {{ ucfirst($zis->jenis_zis) }}
                            </span>
                        </td>
                        <td>{{ $zis->sub_jenis_zis ?? '-' }}</td>
                        <td>Rp {{ number_format($zis->jumlah, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('zis-masuk.show', $zis->id_zis) }}" class="btn btn-info btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('zis-masuk.edit', $zis->id_zis) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('zis-masuk.destroy', $zis->id_zis) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data ZIS masuk</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection







