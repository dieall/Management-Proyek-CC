@extends('layouts.app')

@section('title', 'QR Aset')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">QR Aset</h1>
    <div>
        <a href="{{ route('aset.show', $aset->id) }}" class="btn btn-info">
            <i class="fas fa-eye"></i> Lihat Detail
        </a>
        <a href="{{ route('aset.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Aset</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="35%">Kode</th>
                        <td>: {{ $aset->kode_aset }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>: {{ $aset->nama_aset }}</td>
                    </tr>
                    <tr>
                        <th>Jenis</th>
                        <td>: {{ $aset->jenis_aset }}</td>
                    </tr>
                    <tr>
                        <th>Kondisi</th>
                        <td>: {{ ucfirst(str_replace('_', ' ', $aset->kondisi)) }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <td>: {{ $aset->lokasi ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4 h-100">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">QR Code</h6>
                <button class="btn btn-sm btn-outline-primary" onclick="window.print()">
                    <i class="fas fa-print"></i> Cetak
                </button>
            </div>
            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                {{-- Pastikan paket simple-qrcode sudah di-install --}}
                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(240)->margin(2)->generate($url) !!}
                <div class="mt-3 text-center small text-muted">
                    Scan untuk membuka detail aset<br>
                    <code>{{ $url }}</code>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



















