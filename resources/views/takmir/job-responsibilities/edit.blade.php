@extends('layouts.app')

@section('title', 'Edit Tugas & Tanggung Jawab')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Tugas & Tanggung Jawab</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Tugas & Tanggung Jawab</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('job-responsibilities.update', $jobResponsibility->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="position_id">Posisi/Jabatan <span class="text-danger">*</span></label>
                <select class="form-control @error('position_id') is-invalid @enderror" id="position_id" name="position_id" required>
                    <option value="">- Pilih Posisi -</option>
                    @foreach($positions as $pos)
                        <option value="{{ $pos->id }}" {{ old('position_id', $jobResponsibility->position_id) == $pos->id ? 'selected' : '' }}>{{ $pos->name }}</option>
                    @endforeach
                </select>
                @error('position_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="task_name">Nama Tugas <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('task_name') is-invalid @enderror" 
                       id="task_name" name="task_name" value="{{ old('task_name', $jobResponsibility->task_name) }}" required>
                @error('task_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="task_description">Deskripsi Tugas</label>
                <textarea class="form-control @error('task_description') is-invalid @enderror" 
                          id="task_description" name="task_description" rows="4">{{ old('task_description', $jobResponsibility->task_description) }}</textarea>
                @error('task_description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="priority">Prioritas <span class="text-danger">*</span></label>
                        <select class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                            <option value="low" {{ old('priority', $jobResponsibility->priority) == 'low' ? 'selected' : '' }}>Rendah</option>
                            <option value="medium" {{ old('priority', $jobResponsibility->priority) == 'medium' ? 'selected' : '' }}>Sedang</option>
                            <option value="high" {{ old('priority', $jobResponsibility->priority) == 'high' ? 'selected' : '' }}>Tinggi</option>
                            <option value="critical" {{ old('priority', $jobResponsibility->priority) == 'critical' ? 'selected' : '' }}>Kritis</option>
                        </select>
                        @error('priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="frequency">Frekuensi <span class="text-danger">*</span></label>
                        <select class="form-control @error('frequency') is-invalid @enderror" id="frequency" name="frequency" required>
                            <option value="daily" {{ old('frequency', $jobResponsibility->frequency) == 'daily' ? 'selected' : '' }}>Harian</option>
                            <option value="weekly" {{ old('frequency', $jobResponsibility->frequency) == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                            <option value="monthly" {{ old('frequency', $jobResponsibility->frequency) == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                            <option value="quarterly" {{ old('frequency', $jobResponsibility->frequency) == 'quarterly' ? 'selected' : '' }}>Triwulan</option>
                            <option value="yearly" {{ old('frequency', $jobResponsibility->frequency) == 'yearly' ? 'selected' : '' }}>Tahunan</option>
                            <option value="on_demand" {{ old('frequency', $jobResponsibility->frequency) == 'on_demand' ? 'selected' : '' }}>Sesuai Kebutuhan</option>
                        </select>
                        @error('frequency')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="estimated_hours">Estimasi Jam</label>
                        <input type="number" class="form-control @error('estimated_hours') is-invalid @enderror" 
                               id="estimated_hours" name="estimated_hours" value="{{ old('estimated_hours', $jobResponsibility->estimated_hours) }}" min="0">
                        @error('estimated_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_core_responsibility" name="is_core_responsibility" value="1" {{ old('is_core_responsibility', $jobResponsibility->is_core_responsibility) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_core_responsibility">
                        Core Responsibility (Tugas Inti)
                    </label>
                </div>
            </div>

            <div class="form-group">
                <a href="{{ route('job-responsibilities.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection







