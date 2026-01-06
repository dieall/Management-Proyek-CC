@extends('layouts.app')

@section('title', 'Riwayat Kurban Saya')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Riwayat Kurban Saya</h1>
    <a href="{{ route('kurban.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<!-- Statistik -->
<div class="row mb-4">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Pembayaran
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalPembayaran, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
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
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Hewan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalHewan }} Ekor
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cow fa-2x text-gray-300"></i>
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
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Program Kurban
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $riwayatKurban->count() }} Program
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Riwayat -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Kurban yang Saya Daftarkan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Program Kurban</th>
                        <th>Tanggal Kurban</th>
                        <th>Jenis Hewan</th>
                        <th>Jenis Pembayaran</th>
                        <th>Jumlah Hewan</th>
                        <th>Jumlah Pembayaran</th>
                        <th>Status Pembayaran</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatKurban as $index => $riwayat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $riwayat->kurban->nama_kurban }}</td>
                        <td>{{ $riwayat->kurban->tanggal_kurban->format('d/m/Y') }}</td>
                        <td>{{ ucfirst($riwayat->kurban->jenis_hewan) }}</td>
                        <td>
                            @if($riwayat->jenis_pembayaran == 'transfer')
                                <span class="badge badge-primary">Transfer</span>
                            @elseif($riwayat->jenis_pembayaran == 'tunai')
                                <span class="badge badge-success">Tunai</span>
                            @else
                                <span class="badge badge-secondary">{{ ucfirst($riwayat->jenis_pembayaran) }}</span>
                            @endif
                        </td>
                        <td>{{ $riwayat->jumlah_hewan }} Ekor</td>
                        <td>Rp {{ number_format($riwayat->jumlah_pembayaran, 0, ',', '.') }}</td>
                        <td>
                            @if($riwayat->status_pembayaran == 'lunas')
                                <span class="badge badge-success">Lunas</span>
                            @elseif($riwayat->status_pembayaran == 'verifikasi')
                                <span class="badge badge-warning">Verifikasi</span>
                            @else
                                <span class="badge badge-danger">Belum Lunas</span>
                            @endif
                        </td>
                        <td>{{ $riwayat->tanggal_pembayaran->format('d/m/Y') }}</td>
                        <td>{{ $riwayat->keterangan ?? '-' }}</td>
                    </tr>
                    <!-- Row untuk dokumentasi foto -->
                    @if($riwayat->dokumentasi->count() > 0)
                    <tr class="bg-light">
                        <td colspan="10">
                            <div class="p-3">
                                <h6 class="mb-3"><i class="fas fa-images"></i> Dokumentasi Kurban</h6>
                                <div class="row">
                                    <!-- Foto Penyembelihan -->
                                    <div class="col-md-6">
                                        <h6 class="text-primary"><i class="fas fa-cut"></i> Foto Penyembelihan</h6>
                                        <div class="row">
                                            @forelse($riwayat->dokumentasi->where('jenis_dokumentasi', 'penyembelihan') as $foto)
                                            <div class="col-md-6 mb-3">
                                                <div class="card">
                                                    <img src="{{ asset('storage/' . $foto->foto) }}" class="card-img-top" alt="Penyembelihan" style="height: 200px; object-fit: cover;" data-toggle="modal" data-target="#fotoModal{{ $foto->id_dokumentasi }}" style="cursor: pointer;">
                                                    <div class="card-body p-2">
                                                        <p class="card-text small mb-0">{{ $foto->keterangan ?? 'Foto penyembelihan' }}</p>
                                                        <small class="text-muted">{{ $foto->created_at->format('d/m/Y H:i') }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal untuk preview foto -->
                                            <div class="modal fade" id="fotoModal{{ $foto->id_dokumentasi }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Foto Penyembelihan</h5>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img src="{{ asset('storage/' . $foto->foto) }}" class="img-fluid" alt="Penyembelihan">
                                                            @if($foto->keterangan)
                                                            <p class="mt-3">{{ $foto->keterangan }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            <div class="col-12">
                                                <p class="text-muted small">Belum ada foto penyembelihan</p>
                                            </div>
                                            @endforelse
                                        </div>
                                    </div>

                                    <!-- Foto Pembagian Daging -->
                                    <div class="col-md-6">
                                        <h6 class="text-success"><i class="fas fa-gift"></i> Foto Pembagian Daging</h6>
                                        <div class="row">
                                            @forelse($riwayat->dokumentasi->where('jenis_dokumentasi', 'pembagian_daging') as $foto)
                                            <div class="col-md-6 mb-3">
                                                <div class="card">
                                                    <img src="{{ asset('storage/' . $foto->foto) }}" class="card-img-top" alt="Pembagian Daging" style="height: 200px; object-fit: cover; cursor: pointer;" data-toggle="modal" data-target="#fotoModal{{ $foto->id_dokumentasi }}">
                                                    <div class="card-body p-2">
                                                        <p class="card-text small mb-0">{{ $foto->keterangan ?? 'Foto pembagian daging' }}</p>
                                                        <small class="text-muted">{{ $foto->created_at->format('d/m/Y H:i') }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal untuk preview foto -->
                                            <div class="modal fade" id="fotoModal{{ $foto->id_dokumentasi }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Foto Pembagian Daging</h5>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img src="{{ asset('storage/' . $foto->foto) }}" class="img-fluid" alt="Pembagian Daging">
                                                            @if($foto->keterangan)
                                                            <p class="mt-3">{{ $foto->keterangan }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            <div class="col-12">
                                                <p class="text-muted small">Belum ada foto pembagian daging</p>
                                            </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">Anda belum mendaftar di program kurban manapun.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

