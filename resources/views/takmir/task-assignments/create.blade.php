@extends('layouts.app')

@section('title', 'Tambah Penugasan Tugas')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Penugasan Tugas Baru</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Penugasan Tugas</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('task-assignments.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="committee_id">Pengurus <span class="text-danger">*</span></label>
                <select class="form-control @error('committee_id') is-invalid @enderror" id="committee_id" name="committee_id" required>
                    <option value="">- Pilih Pengurus -</option>
                    @foreach($committees as $comm)
                        <option value="{{ $comm->id }}" {{ old('committee_id') == $comm->id ? 'selected' : '' }}>
                            {{ $comm->full_name }} - {{ $comm->position->name ?? '-' }}
                        </option>
                    @endforeach
                </select>
                @error('committee_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="job_responsibility_id">Tugas <span class="text-danger">*</span></label>
                <select class="form-control @error('job_responsibility_id') is-invalid @enderror" id="job_responsibility_id" name="job_responsibility_id" required>
                    <option value="">- Pilih Tugas -</option>
                    @foreach($jobResponsibilities as $job)
                        <option value="{{ $job->id }}" {{ old('job_responsibility_id') == $job->id ? 'selected' : '' }}>
                            {{ $job->task_name }} ({{ $job->position->name }})
                        </option>
                    @endforeach
                </select>
                @error('job_responsibility_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="assigned_date">Tanggal Mulai</label>
                        <input type="date" class="form-control @error('assigned_date') is-invalid @enderror" 
                               id="assigned_date" name="assigned_date" value="{{ old('assigned_date', date('Y-m-d')) }}">
                        @error('assigned_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="due_date">Tanggal Selesai <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                               id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                        @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>Berjalan</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            <option value="overdue" {{ old('status') == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="progress_percentage">Progress (%) <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('progress_percentage') is-invalid @enderror" 
                       id="progress_percentage" name="progress_percentage" value="{{ old('progress_percentage', 0) }}" min="0" max="100" required>
                @error('progress_percentage')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="notes">Catatan</label>
                <textarea class="form-control @error('notes') is-invalid @enderror" 
                          id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <a href="{{ route('task-assignments.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection








