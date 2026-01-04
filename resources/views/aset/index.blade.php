@extends('layouts.app')

@section('title', 'Daftar Aset')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Aset</h1>
    @if($user->isAdmin())
    <a href="{{ route('aset.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Aset
    </a>
    @endif
</div>

<!-- Content Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Aset</h6>
    </div>
    <div class="card-body">
        <!-- Filter -->
        <div class="row mb-3">
            <div class="col-md-6">
                <form method="GET" action="{{ route('aset.index') }}" class="form-inline">
                    <div class="form-group mr-2">
                        <input type="text" name="search" class="form-control" placeholder="Cari aset..." value="{{ request('search') }}">
                    </div>
                    <div class="form-group mr-2">
                        <select name="status" class="form-control">
                            <option value="">Semua</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Di-Archive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Aset</th>
                        <th>Jenis</th>
                        <th>Kondisi</th>
                        <th>Lokasi</th>
                        @if($user->isAdmin())
                        <th>Harga/Nilai</th>
                        @endif
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aset as $item)
                    <tr>
                        <td>{{ $item->kode_aset }}</td>
                        <td>{{ $item->nama_aset }}</td>
                        <td>{{ $item->jenis_aset }}</td>
                        <td>
                            <span class="badge badge-{{ $item->kondisi === 'baik' ? 'success' : ($item->kondisi === 'rusak_ringan' ? 'warning' : 'danger') }}">
                                {{ ucfirst(str_replace('_', ' ', $item->kondisi)) }}
                            </span>
                        </td>
                        <td>{{ $item->lokasi ?? '-' }}</td>
                        @if($user->isAdmin())
                        <td>
                            @if($item->sumber_perolehan === 'pembelian' && $item->harga)
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            @elseif($item->sumber_perolehan === 'donasi' && $item->nilai_donasi)
                                Rp {{ number_format($item->nilai_donasi, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                        @endif
                        <td>
                            <a href="{{ route('aset.show', $item->id) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('aset.qr', $item->id) }}" class="btn btn-sm btn-secondary" title="QR Code">
                                <i class="fas fa-qrcode"></i>
                            </a>
                            @if($user->isAdmin())
                            <a href="{{ route('aset.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($item->is_archived)
                            <form action="{{ route('aset.restore', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Restore aset ini?')" title="Restore">
                                    <i class="fas fa-undo"></i>
                                </button>
                            </form>
                            @else
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#archiveModal{{ $item->id }}" title="Archive">
                                <i class="fas fa-archive"></i>
                            </button>
                            @endif
                            @endif
                        </td>
                    </tr>

                    <!-- Archive Modal -->
                    @if($user->isAdmin() && !$item->is_archived)
                    <div class="modal fade" id="archiveModal{{ $item->id }}" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="{{ route('aset.archive', $item->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Archive Aset</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin meng-archive aset <strong>{{ $item->nama_aset }}</strong>?</p>
                                        <div class="form-group">
                                            <label>Alasan Archive:</label>
                                            <textarea name="alasan_archive" class="form-control" rows="3" required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Archive</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                    @empty
                    <tr>
                        <td colspan="{{ $user->isAdmin() ? '7' : '6' }}" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $aset->links() }}
        </div>
    </div>
</div>
@endsection



