@extends('layouts.app')

@section('title', 'Tugas & Tanggung Jawab')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tugas & Tanggung Jawab</h1>
    <a href="{{ route('job-responsibilities.create') }}" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Tambah Tugas</span>
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Tugas & Tanggung Jawab</h6>
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <form method="GET" action="{{ route('job-responsibilities.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari tugas..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="position_id" class="form-control">
                        <option value="">Semua Posisi</option>
                        @foreach($positions as $pos)
                            <option value="{{ $pos->id }}" {{ request('position_id') == $pos->id ? 'selected' : '' }}>{{ $pos->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="priority" class="form-control">
                        <option value="">Semua Prioritas</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                        <option value="critical" {{ request('priority') == 'critical' ? 'selected' : '' }}>Kritis</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('job-responsibilities.index') }}" class="btn btn-secondary btn-block">Reset</a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Tugas</th>
                        <th>Posisi</th>
                        <th>Prioritas</th>
                        <th>Frekuensi</th>
                        <th>Core</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobResponsibilities as $job)
                    <tr>
                        <td>{{ ($jobResponsibilities->currentPage() - 1) * $jobResponsibilities->perPage() + $loop->iteration }}</td>
                        <td>{{ $job->task_name }}</td>
                        <td>{{ $job->position->name }}</td>
                        <td>
                            @if($job->priority == 'critical')
                                <span class="badge badge-danger">Kritis</span>
                            @elseif($job->priority == 'high')
                                <span class="badge badge-warning">Tinggi</span>
                            @elseif($job->priority == 'medium')
                                <span class="badge badge-info">Sedang</span>
                            @else
                                <span class="badge badge-secondary">Rendah</span>
                            @endif
                        </td>
                        <td>{{ ucfirst($job->frequency) }}</td>
                        <td>
                            @if($job->is_core_responsibility)
                                <span class="badge badge-primary">Ya</span>
                            @else
                                <span class="badge badge-secondary">Tidak</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('job-responsibilities.show', $job->id) }}" class="btn btn-info btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('job-responsibilities.edit', $job->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('job-responsibilities.destroy', $job->id) }}" method="POST" style="display:inline;">
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
                        <td colspan="7" class="text-center">Tidak ada data tugas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $jobResponsibilities->links() }}
        </div>
    </div>
</div>
@endsection

