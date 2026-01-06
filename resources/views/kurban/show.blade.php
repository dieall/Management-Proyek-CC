@extends('layouts.app')

@section('title', 'Detail Program Kurban')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Program Kurban</h1>
    <a href="{{ route('kurban.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <!-- Info Program Kurban -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Program Kurban</h6>
            </div>
            <div class="card-body">
                <h3 class="mb-3">{{ $kurban->nama_kurban }}</h3>
                <table class="table table-borderless">
                    <tr>
                        <td width="200"><strong>Tanggal Kurban</strong></td>
                        <td>: {{ $kurban->tanggal_kurban->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jenis Hewan</strong></td>
                        <td>: {{ ucfirst($kurban->jenis_hewan) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Target Hewan</strong></td>
                        <td>: {{ $kurban->target_hewan }} Ekor</td>
                    </tr>
                    <tr>
                        <td><strong>Harga per Hewan</strong></td>
                        <td>: Rp {{ number_format($kurban->harga_per_hewan, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>: 
                            @if($kurban->status == 'aktif')
                                <span class="badge badge-success">{{ ucfirst($kurban->status) }}</span>
                            @elseif($kurban->status == 'selesai')
                                <span class="badge badge-info">{{ ucfirst($kurban->status) }}</span>
                            @else
                                <span class="badge badge-danger">{{ ucfirst($kurban->status) }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Deskripsi</strong></td>
                        <td>: {{ $kurban->deskripsi ?? '-' }}</td>
                    </tr>
                </table>

                <!-- Form Submit Pendaftaran Kurban -->
                @if($kurban->status == 'aktif' && $sisaHewan > 0)
                <div class="card border-left-warning mt-4">
                    <div class="card-body">
                        <h6 class="font-weight-bold text-warning mb-3">
                            <i class="fas fa-drumstick-bite"></i> Daftar Kurban Sekarang
                        </h6>
                        <form action="{{ route('kurban.submit', $kurban->id_kurban) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jenis_pembayaran">Jenis Pembayaran <span class="text-danger">*</span></label>
                                        <select class="form-control @error('jenis_pembayaran') is-invalid @enderror" 
                                                id="jenis_pembayaran" name="jenis_pembayaran" required>
                                            <option value="transfer" {{ old('jenis_pembayaran') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                            <option value="tunai" {{ old('jenis_pembayaran') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                                        </select>
                                        @error('jenis_pembayaran')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jumlah_hewan">Jumlah Hewan <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('jumlah_hewan') is-invalid @enderror" 
                                               id="jumlah_hewan" name="jumlah_hewan" value="{{ old('jumlah_hewan', 1) }}" min="1" max="{{ $sisaHewan }}" required>
                                        @error('jumlah_hewan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Sisa hewan tersedia: {{ $sisaHewan }} ekor</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jumlah_pembayaran">Jumlah Pembayaran (Rp) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('jumlah_pembayaran') is-invalid @enderror" 
                                               id="jumlah_pembayaran" name="jumlah_pembayaran" value="{{ old('jumlah_pembayaran') }}" min="0" step="1000" required>
                                        @error('jumlah_pembayaran')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_pembayaran">Tanggal Pembayaran <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('tanggal_pembayaran') is-invalid @enderror" 
                                               id="tanggal_pembayaran" name="tanggal_pembayaran" value="{{ old('tanggal_pembayaran', date('Y-m-d')) }}" required>
                                        @error('tanggal_pembayaran')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin() || auth()->user()->isDkm())
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status_pembayaran">Status Pembayaran</label>
                                        <select class="form-control @error('status_pembayaran') is-invalid @enderror" 
                                                id="status_pembayaran" name="status_pembayaran">
                                            <option value="lunas" {{ old('status_pembayaran') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                            <option value="verifikasi" {{ old('status_pembayaran') == 'verifikasi' ? 'selected' : '' }}>Verifikasi</option>
                                            <option value="belum_lunas" {{ old('status_pembayaran', 'belum_lunas') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                        </select>
                                        @error('status_pembayaran')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <input type="text" class="form-control @error('keterangan') is-invalid @enderror" 
                                               id="keterangan" name="keterangan" value="{{ old('keterangan') }}">
                                        @error('keterangan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-check"></i> Daftar Kurban
                            </button>
                        </form>
                    </div>
                </div>
                @elseif($kurban->status != 'aktif')
                <div class="alert alert-info mt-4">
                    <i class="fas fa-info-circle"></i> Program kurban ini sudah {{ $kurban->status }}. Pendaftaran tidak dapat dilakukan.
                </div>
                @else
                <div class="alert alert-warning mt-4">
                    <i class="fas fa-exclamation-triangle"></i> Program kurban sudah penuh. Tidak ada sisa hewan yang tersedia.
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistik Kurban -->
    <div class="col-lg-4">
        <div class="card shadow mb-4 border-left-warning">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">Statistik Kurban</h6>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <small class="text-muted">Total Pembayaran</small>
                    <h3 class="text-warning">Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</h3>
                </div>
                <hr>
                <div class="mb-2">
                    <i class="fas fa-cow text-primary"></i>
                    <strong>{{ $totalHewanTerdaftar }}/{{ $kurban->target_hewan }}</strong> Hewan Terdaftar
                </div>
                <div class="mb-2">
                    <i class="fas fa-users text-primary"></i>
                    <strong>{{ $jumlahPeserta }}</strong> Peserta
                </div>
                <div class="mb-2">
                    <i class="fas fa-exclamation-circle text-info"></i>
                    <strong>{{ $sisaHewan }}</strong> Sisa Hewan
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Pendaftaran Kurban -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Riwayat Pendaftaran Kurban</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>Jenis Pembayaran</th>
                        <th>Jumlah Hewan</th>
                        <th>Jumlah Pembayaran</th>
                        <th>Status Pembayaran</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Keterangan</th>
                        @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin() || auth()->user()->isDkm())
                        <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatKurban as $index => $riwayat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $riwayat->jamaah->nama_lengkap ?? $riwayat->jamaah->name ?? '-' }}</td>
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
                        <td>{{ \Carbon\Carbon::parse($riwayat->tanggal_pembayaran)->format('d/m/Y') }}</td>
                        <td>{{ $riwayat->keterangan ?? '-' }}</td>
                        @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin() || auth()->user()->isDkm())
                        <td>
                            <form action="{{ route('kurban.update-status', $riwayat->id_riwayat_kurban) }}" method="POST" class="d-inline" id="form-status-{{ $riwayat->id_riwayat_kurban }}">
                                @csrf
                                @method('PATCH')
                                <select name="status_pembayaran" class="form-control form-control-sm" onchange="if(confirm('Yakin ingin mengubah status pembayaran?')) { this.form.submit(); }">
                                    <option value="verifikasi" {{ $riwayat->status_pembayaran == 'verifikasi' ? 'selected' : '' }}>Verifikasi</option>
                                    <option value="lunas" {{ $riwayat->status_pembayaran == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                    <option value="belum_lunas" {{ $riwayat->status_pembayaran == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                </select>
                            </form>
                        </td>
                        @endif
                    </tr>
                    <!-- Row untuk dokumentasi (expandable) -->
                    @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin() || auth()->user()->isDkm())
                    <tr class="bg-light">
                        <td colspan="{{ auth()->user()->isAdmin() || auth()->user()->isSuperAdmin() || auth()->user()->isDkm() ? '9' : '8' }}">
                            <div class="p-3">
                                <h6 class="mb-3"><i class="fas fa-images"></i> Dokumentasi Kurban - {{ $riwayat->jamaah->nama_lengkap ?? $riwayat->jamaah->name ?? '-' }}</h6>
                                
                                <!-- Form Upload Dokumentasi -->
                                <form action="{{ route('kurban.upload-dokumentasi') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                                    @csrf
                                    <input type="hidden" name="id_riwayat_kurban" value="{{ $riwayat->id_riwayat_kurban }}">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Jenis Dokumentasi</label>
                                                <select name="jenis_dokumentasi" class="form-control form-control-sm" required>
                                                    <option value="penyembelihan">Penyembelihan</option>
                                                    <option value="pembagian_daging">Pembagian Daging</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Upload Foto</label>
                                                <input type="file" name="foto" class="form-control form-control-sm" accept="image/*" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Keterangan</label>
                                                <input type="text" name="keterangan" class="form-control form-control-sm" placeholder="Opsional">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <button type="submit" class="btn btn-sm btn-primary btn-block">
                                                    <i class="fas fa-upload"></i> Upload
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- Tampilkan Foto Dokumentasi -->
                                <div class="row">
                                    <!-- Foto Penyembelihan -->
                                    <div class="col-md-6">
                                        <h6 class="text-primary"><i class="fas fa-cut"></i> Foto Penyembelihan</h6>
                                        <div class="row">
                                            @forelse($riwayat->dokumentasi->where('jenis_dokumentasi', 'penyembelihan') as $foto)
                                            <div class="col-md-6 mb-3">
                                                <div class="card">
                                                    <img src="{{ asset('storage/' . $foto->foto) }}" class="card-img-top" alt="Penyembelihan" style="height: 200px; object-fit: cover;">
                                                    <div class="card-body p-2">
                                                        <p class="card-text small mb-1">{{ $foto->keterangan ?? '-' }}</p>
                                                        <form action="{{ route('kurban.delete-dokumentasi', $foto->id_dokumentasi) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus foto ini?')">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        </form>
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
                                                    <img src="{{ asset('storage/' . $foto->foto) }}" class="card-img-top" alt="Pembagian Daging" style="height: 200px; object-fit: cover;">
                                                    <div class="card-body p-2">
                                                        <p class="card-text small mb-1">{{ $foto->keterangan ?? '-' }}</p>
                                                        <form action="{{ route('kurban.delete-dokumentasi', $foto->id_dokumentasi) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus foto ini?')">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        </form>
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
                        <td colspan="{{ auth()->user()->isAdmin() || auth()->user()->isSuperAdmin() || auth()->user()->isDkm() ? '9' : '8' }}" class="text-center">Belum ada pendaftaran kurban</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

