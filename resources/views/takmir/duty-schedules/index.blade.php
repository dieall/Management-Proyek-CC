@extends('layouts.app')

@section('title', 'Jadwal Piket')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Jadwal Piket/Tugas</h1>
    <a href="{{ route('duty-schedules.create') }}" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Tambah Jadwal</span>
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Jadwal Piket</h6>
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <form method="GET" action="{{ route('duty-schedules.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-2">
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" placeholder="Dari Tanggal">
                </div>
                <div class="col-md-2">
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" placeholder="Sampai Tanggal">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                        <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Berjalan</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="duty_type" class="form-control">
                        <option value="">Semua Tipe</option>
                        <option value="piket" {{ request('duty_type') == 'piket' ? 'selected' : '' }}>Piket</option>
                        <option value="kebersihan" {{ request('duty_type') == 'kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                        <option value="keamanan" {{ request('duty_type') == 'keamanan' ? 'selected' : '' }}>Keamanan</option>
                        <option value="acara" {{ request('duty_type') == 'acara' ? 'selected' : '' }}>Acara</option>
                        <option value="lainnya" {{ request('duty_type') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="committee_id" class="form-control">
                        <option value="">Semua Pengurus</option>
                        @foreach($committees as $comm)
                            <option value="{{ $comm->id }}" {{ request('committee_id') == $comm->id ? 'selected' : '' }}>{{ $comm->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                </div>
                <div class="col-md-1">
                    <a href="{{ route('duty-schedules.index') }}" class="btn btn-secondary btn-block">Reset</a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Pengurus</th>
                        <th>Lokasi</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dutySchedules as $schedule)
                    <tr>
                        <td>{{ ($dutySchedules->currentPage() - 1) * $dutySchedules->perPage() + $loop->iteration }}</td>
                        <td>{{ $schedule->duty_date->format('d/m/Y') }}</td>
                        <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                        <td>{{ $schedule->committee->full_name }}</td>
                        <td>{{ $schedule->location }}</td>
                        <td>{{ ucfirst($schedule->duty_type) }}</td>
                        <td>
                            @if($schedule->status == 'completed')
                                <span class="badge badge-success">Selesai</span>
                            @elseif($schedule->status == 'ongoing')
                                <span class="badge badge-info">Berjalan</span>
                            @elseif($schedule->status == 'cancelled')
                                <span class="badge badge-danger">Dibatalkan</span>
                            @else
                                <span class="badge badge-warning">Terjadwal</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('duty-schedules.show', $schedule->id) }}" class="btn btn-info btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('duty-schedules.edit', $schedule->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('duty-schedules.destroy', $schedule->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data jadwal piket</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $dutySchedules->links() }}
        </div>
    </div>
</div>
@endsection








