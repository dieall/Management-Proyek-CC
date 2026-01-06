@extends('layouts.app')

@section('title', 'Detail Penyaluran')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Penyaluran</h1>
    <a href="{{ route('penyaluran.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <!-- Info Penyaluran -->
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Penyaluran</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="180"><strong>Tanggal Penyaluran</strong></td>
                        <td>: {{ $penyaluran->tgl_salur ? $penyaluran->tgl_salur->format('d F Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Dari Muzakki</strong></td>
                        <td>: {{ $penyaluran->zisMasuk->muzakki->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jenis ZIS</strong></td>
                        <td>: 
                            <span class="badge badge-{{ $penyaluran->zisMasuk->jenis_zis == 'zakat' ? 'primary' : ($penyaluran->zisMasuk->jenis_zis == 'infaq' ? 'success' : ($penyaluran->zisMasuk->jenis_zis == 'shadaqah' ? 'warning' : 'info')) }}">
                                {{ ucfirst($penyaluran->zisMasuk->jenis_zis ?? '-') }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Sub Jenis ZIS</strong></td>
                        <td>: {{ $penyaluran->zisMasuk->sub_jenis_zis ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total ZIS Masuk</strong></td>
                        <td>: Rp {{ number_format($penyaluran->zisMasuk->jumlah, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Info Penerima -->
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Informasi Penerima</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="180"><strong>Nama Mustahik</strong></td>
                        <td>: {{ $penyaluran->mustahik->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Kategori Mustahik</strong></td>
                        <td>: <span class="badge badge-info">{{ ucwords($penyaluran->mustahik->kategori_mustahik ?? '-') }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Alamat</strong></td>
                        <td>: {{ $penyaluran->mustahik->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>No HP</strong></td>
                        <td>: {{ $penyaluran->mustahik->no_hp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jumlah Diterima</strong></td>
                        <td>: <strong class="text-success">Rp {{ number_format($penyaluran->jumlah, 0, ',', '.') }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Detail Tambahan -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Keterangan</h6>
    </div>
    <div class="card-body">
        <p>{{ $penyaluran->keterangan ?? 'Tidak ada keterangan tambahan.' }}</p>
    </div>
</div>

<!-- Aksi -->
@if(auth()->user()->isAdmin())
<div class="card shadow mb-4">
    <div class="card-body text-center">
        <a href="{{ route('penyaluran.edit', $penyaluran->id_penyaluran) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit Penyaluran
        </a>
        <form action="{{ route('penyaluran.destroy', $penyaluran->id_penyaluran) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus penyaluran ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash"></i> Hapus Penyaluran
            </button>
        </form>
    </div>
</div>
@endif
@endsection









