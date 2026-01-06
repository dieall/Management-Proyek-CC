@extends('layouts.app')

@section('title', 'Edit Penugasan Tugas')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Penugasan Tugas</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Penugasan Tugas</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('task-assignments.update', $taskAssignment->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="committee_id">Pengurus <span class="text-danger">*</span></label>
                <select class="form-control @error('committee_id') is-invalid @enderror" id="committee_id" name="committee_id" required>
                    <option value="">- Pilih Pengurus -</option>
                    @foreach($committees as $comm)
                        <option value="{{ $comm->id }}" {{ old('committee_id', $taskAssignment->committee_id) == $comm->id ? 'selected' : '' }}>
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
                        <option value="{{ $job->id }}" {{ old('job_responsibility_id', $taskAssignment->job_responsibility_id) == $job->id ? 'selected' : '' }}>
                            {{ $job->task_name }} ({{ $job->position->name }})
                        </option>
                    @endforeach
                </select>
                @error('job_responsibility_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="assigned_date">Tanggal Mulai</label>
                        <input type="date" class="form-control @error('assigned_date') is-invalid @enderror" 
                               id="assigned_date" name="assigned_date" value="{{ old('assigned_date', $taskAssignment->assigned_date->format('Y-m-d')) }}">
                        @error('assigned_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="due_date">Tanggal Selesai <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                               id="due_date" name="due_date" value="{{ old('due_date', $taskAssignment->due_date->format('Y-m-d')) }}" required>
                        @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="completed_date">Tanggal Selesai (Actual)</label>
                        <input type="date" class="form-control @error('completed_date') is-invalid @enderror" 
                               id="completed_date" name="completed_date" value="{{ old('completed_date', $taskAssignment->completed_date ? $taskAssignment->completed_date->format('Y-m-d') : '') }}">
                        @error('completed_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="pending" {{ old('status', $taskAssignment->status) == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="in_progress" {{ old('status', $taskAssignment->status) == 'in_progress' ? 'selected' : '' }}>Berjalan</option>
                            <option value="completed" {{ old('status', $taskAssignment->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ old('status', $taskAssignment->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            <option value="overdue" {{ old('status', $taskAssignment->status) == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="progress_percentage">Progress (%) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('progress_percentage') is-invalid @enderror" 
                               id="progress_percentage" name="progress_percentage" value="{{ old('progress_percentage', $taskAssignment->progress_percentage) }}" min="0" max="100" required>
                        @error('progress_percentage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="approved_by">Disetujui Oleh</label>
                        <select class="form-control @error('approved_by') is-invalid @enderror" id="approved_by" name="approved_by">
                            <option value="">- Pilih Pengurus -</option>
                            @foreach($approvers as $approver)
                                <option value="{{ $approver->id }}" {{ old('approved_by', $taskAssignment->approved_by) == $approver->id ? 'selected' : '' }}>
                                    {{ $approver->full_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('approved_by')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="notes">Catatan</label>
                <textarea class="form-control @error('notes') is-invalid @enderror" 
                          id="notes" name="notes" rows="3">{{ old('notes', $taskAssignment->notes) }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <a href="{{ route('task-assignments.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection








