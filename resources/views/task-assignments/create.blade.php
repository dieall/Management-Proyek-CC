@extends('layouts.app')

@section('title', isset($assignment) ? 'Edit' : 'Buat' . ' Penugasan')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ isset($assignment) ? 'Edit' : 'Buat Baru' }} Penugasan</h1>
</div>

<div class="card shadow">
    <div class="card-body">
        <form action="{{ isset($assignment) ? route('task-assignments.update', $assignment->id) : route('task-assignments.store') }}" method="POST">
            @csrf
            @if(isset($assignment)) @method('PUT') @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pengurus <span class="text-danger">*</span></label>
                    <select name="committee_id" class="form-select @error('committee_id') is-invalid @enderror" required>
                        <option value="">Pilih Pengurus</option>
                        @foreach($committees as $committee)
                            <option value="{{ $committee->id }}" {{ old('committee_id', $assignment->committee_id ?? '') == $committee->id ? 'selected' : '' }}>
                                {{ $committee->full_name }} @if($committee->position) - {{ $committee->position->name }} @endif
                            </option>
                        @endforeach
                    </select>
                    @error('committee_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tugas <span class="text-danger">*</span></label>
                    <select name="job_responsibility_id" class="form-select @error('job_responsibility_id') is-invalid @enderror" required>
                        <option value="">Pilih Tugas</option>
                        @foreach($jobResponsibilities as $resp)
                            <option value="{{ $resp->id }}" {{ old('job_responsibility_id', $assignment->job_responsibility_id ?? request('job_responsibility_id')) == $resp->id ? 'selected' : '' }}>
                                {{ $resp->task_name }} @if($resp->position) ({{ $resp->position->name }}) @endif
                            </option>
                        @endforeach
                    </select>
                    @error('job_responsibility_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Tanggal Penugasan <span class="text-danger">*</span></label>
                    <input type="date" name="assigned_date" class="form-control" required
                           value="{{ old('assigned_date', $assignment->assigned_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Deadline</label>
                    <input type="date" name="due_date" class="form-control"
                           value="{{ old('due_date', $assignment->due_date?->format('Y-m-d') ?? '') }}">
                    <small class="text-muted">Kosongkan = 7 hari dari penugasan</small>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="pending" {{ old('status', $assignment->status ?? 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status', $assignment->status ?? '') == 'in_progress' ? 'selected' : '' }}>Proses</option>
                        <option value="completed" {{ old('status', $assignment->status ?? '') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="col-md-8 mb-3">
                    <label class="form-label">Progress (%)</label>
                    <input type="range" class="form-range" name="progress_percentage"
                           min="0" max="100" step="5" value="{{ old('progress_percentage', $assignment->progress_percentage ?? 0) }}"
                           oninput="document.getElementById('progressValue').textContent = this.value + '%'">
                    <div class="d-flex justify-content-between">
                        <small>0%</small>
                        <span id="progressValue" class="fw-bold">{{ old('progress_percentage', $assignment->progress_percentage ?? 0) }}%</span>
                        <small>100%</small>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" class="form-control" rows="4">{{ old('notes', $assignment->notes ?? '') }}</textarea>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('task-assignments.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary float-end">
                    <i class="fas fa-save"></i> {{ isset($assignment) ? 'Update' : 'Simpan' }} Penugasan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
