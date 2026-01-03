@extends('layouts.app')

@section('title', 'Jadwal Piket & Tugas')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Jadwal Piket & Tugas</h1>
    <div>
        <a href="{{ route('duty-schedules.create') }}" class="btn btn-primary shadow-sm mr-2">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Jadwal
        </a>
        <a href="{{ route('duty-schedules.today') }}" class="btn btn-info shadow-sm mr-2">
            <i class="fas fa-calendar-day fa-sm text-white-50"></i> Hari Ini
        </a>
        <a href="{{ route('duty-schedules.upcoming') }}" class="btn btn-warning shadow-sm">
            <i class="fas fa-calendar-week fa-sm text-white-50"></i> Mendatang
        </a>
    </div>
</div>

<!-- Filter Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter & Pencarian</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('duty-schedules.index') }}">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="date" class="form-control"
                           value="{{ request('date') }}">
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="date_from" class="form-control"
                           value="{{ request('date_from') }}">
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="date_to" class="form-control"
                           value="{{ request('date_to') }}">
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Cari</label>
                    <input type="text" name="search" class="form-control" placeholder="Lokasi, catatan, nama..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Pengurus</label>
                    <select name="committee_id" class="form-select">
                        <option value="">Semua Pengurus</option>
                        @foreach($committees as $committee)
                            <option value="{{ $committee->id }}"
                                {{ request('committee_id') == $committee->id ? 'selected' : '' }}>
                            <option value="{{ $committee->id }}" {{ request('committee_id') == $committee->id ? 'selected' : '' }}>
                                {{ $committee->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Jenis Tugas</label>
                    <select name="duty_type" class="form-select">
                        <option value="">Semua Jenis</option>
                        @foreach($dutyTypes as $type)
                            <option value="{{ $type }}"
                                {{ request('duty_type') == $type ? 'selected' : '' }}>
                            <option value="{{ $type }}" {{ request('duty_type') == $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Sedang Berjalan</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Lokasi</label>
                    <select name="location" class="form-select">
                        <option value="">Semua Lokasi</option>
                        @foreach($locations as $location)
                            <option value="{{ $location }}"
                                {{ request('location') == $location ? 'selected' : '' }}>
                            <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                                {{ $location }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Cari</label>
                    <input type="text" name="search" class="form-control"
                           placeholder="Cari lokasi, catatan, atau nama..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-12">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('duty-schedules.index') }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Terapkan Filter
                </button>
                <a href="{{ route('duty-schedules.index') }}" class="btn btn-outline-secondary ml-2">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Table Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Jadwal</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Pengurus</th>
                        <th>Lokasi</th>
                        <th>Jenis Tugas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $schedule)
                        <tr class="{{ $schedule->status == 'ongoing' ? 'table-warning' : '' }}">
                            <td>
                                <strong>{{ $schedule->duty_date->format('d/m/Y') }}</strong><br>
                                <small class="text-muted">{{ $schedule->duty_date->translatedFormat('l') }}</small>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                <strong>{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</strong>
                            </td>
                            <td>
                                <strong>{{ $schedule->committee->full_name }}</strong><br>
                                @if($schedule->committee->position)
                                    <small class="text-muted">{{ $schedule->committee->position->name }}</small>
                                @endif
                            </td>
                            <td>{{ $schedule->location }}</td>
                            <td>
                                <span class="badge badge-pill badge-{{ getDutyTypeColor($schedule->duty_type) }}">
                                    {{ ucfirst($schedule->duty_type) }}
                                </span>
                                @if($schedule->is_recurring)
                                    <br><small><i class="fas fa-redo"></i> Berulang</small>
                                @endif
                            </td>
                            <td>
                                @switch($schedule->status)
                                    @case('completed')
                                        <span class="badge badge-success">Selesai</span>
                                        @break
                                    @case('ongoing')
                                        <span class="badge badge-warning">Sedang Berjalan</span>
                                        @break
                                    @case('pending')
                                        <span class="badge badge-info">Pending</span>
                                        @break
                                    @default
                                        <span class="badge badge-secondary">Dibatalkan</span>
                                @endswitch
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('duty-schedules.show', $schedule->id) }}"
                                       class="btn btn-sm btn-info" title="Detail">
                                    <a href="{{ route('duty-schedules.show', $schedule->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('duty-schedules.edit', $schedule->id) }}"
                                       class="btn btn-sm btn-warning" title="Edit">
                                    <a href="{{ route('duty-schedules.edit', $schedule->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger"
                                            title="Hapus"
                                            onclick="confirmDelete({{ $schedule->id }}, '{{ $schedule->committee->full_name }} - {{ \Carbon\Carbon::parse($schedule->duty_date)->format('d/m/Y') }}')">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $schedule->id }}, '{{ addslashes($schedule->committee->full_name) }} - {{ $schedule->duty_date->format('d/m/Y') }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Tidak ada jadwal ditemukan</p>
                                <a href="{{ route('duty-schedules.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah Jadwal Baru
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($schedules->hasPages())
            <div class="d-flex justify-content-between mt-4">
                <div class="text-muted">
                    Menampilkan {{ $schedules->firstItem() }} - {{ $schedules->lastItem() }} dari {{ $schedules->total() }} jadwal
                </div>
                <div>
                    {{ $schedules->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus Jadwal</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus jadwal <strong id="deleteName"></strong>?</p>
                <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id, name) {
    document.getElementById('deleteName').textContent = name;
    document.getElementById('deleteForm').action = '/duty-schedules/' + id;
    $('#deleteModal').modal('show');
}
</script>
@endpush

@php
function getDutyTypeColor($type) {
    return ['piket'=>'primary','kebersihan'=>'success','keamanan'=>'dark','administrasi'=>'info','lainnya'=>'secondary'][$type] ?? 'secondary';
}
@endphp

