@extends('layouts.app')

@section('title', 'Penyaluran ZIS')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Penyaluran ZIS kepada Mustahik</h1>
    <a href="{{ route('penyaluran.create') }}" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Salurkan Dana</span>
    </a>
</div>

<!-- Statistik -->
<div class="row mb-4">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Disalurkan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalDisalurkan, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hand-holding-usd fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Penyaluran</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $jumlahPenyaluran }} kali
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Mustahik Terbantu</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $jumlahMustahik }} orang
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Penyaluran</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Dari Muzakki</th>
                        <th>Jenis ZIS</th>
                        <th>Kepada Mustahik</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penyaluran as $index => $data)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $data->tgl_salur ? $data->tgl_salur->format('d/m/Y') : '-' }}</td>
                        <td>{{ $data->zisMasuk->muzakki->nama ?? '-' }}</td>
                        <td>
                            <span class="badge badge-{{ $data->zisMasuk->jenis_zis == 'zakat' ? 'primary' : ($data->zisMasuk->jenis_zis == 'infaq' ? 'success' : ($data->zisMasuk->jenis_zis == 'shadaqah' ? 'warning' : 'info')) }}">
                                {{ ucfirst($data->zisMasuk->jenis_zis ?? '-') }}
                            </span>
                        </td>
                        <td>{{ $data->mustahik->nama ?? '-' }}</td>
                        <td>Rp {{ number_format($data->jumlah, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('penyaluran.show', $data->id_penyaluran) }}" class="btn btn-info btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('penyaluran.edit', $data->id_penyaluran) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('penyaluran.destroy', $data->id_penyaluran) }}" method="POST" style="display:inline;">
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
                        <td colspan="7" class="text-center">Belum ada data penyaluran</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection










