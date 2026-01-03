@extends('layouts.app')

@section('title', isset($responsibility) ? 'Edit' : 'Tambah' . ' Tugas')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ isset($responsibility) ? 'Edit' : 'Tambah Baru' }} Tugas</h1>
</div>

<div class="card shadow">
    <div class="card-body">
        <form action="{{ isset($responsibility) ? route('job-responsibilities.update', $responsibility->id) : route('job-responsibilities.store') }}" method="POST">
            @csrf
            @if(isset($responsibility)) @method('PUT') @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                    <select name="position_id" class="form-select @error('position_id') is-invalid @enderror" required>
                        <option value="">Pilih Jabatan</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}" {{ old('position_id', $responsibility->position_id ?? '') == $position->id ? 'selected' : '' }}>
                                {{ $position->name }} @if($position->level) ({{ ucfirst($position->level) }}) @endif
                            </option>
                        @endforeach
                    </select>
                    @error('position_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Tugas <span class="text-danger">*</span></label>
                    <input type="text" name="task_name" class="form-control @error('task_name') is-invalid @enderror"
                           value="{{ old('task_name', $responsibility->task_name ?? '') }}" required>
                    @error('task_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Deskripsi Tugas</label>
                    <textarea name="task_description" class="form-control" rows="4">{{ old('task_description', $responsibility->task_description ?? '') }}</textarea>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Prioritas <span class="text-danger">*</span></label>
                    <select name="priority" class="form-select @error('priority') is-invalid @enderror" required>
                        <option value="critical" {{ old('priority', $responsibility->priority ?? '') == 'critical' ? 'selected' : '' }}>Kritis</option>
                        <option value="high" {{ old('priority', $responsibility->priority ?? '') == 'high' ? 'selected' : '' }}>Tinggi</option>
                        <option value="medium" {{ old('priority', $responsibility->priority ?? '') == 'medium' ? 'selected' : '' }}>Sedang</option>
                        <option value="low" {{ old('priority', $responsibility->priority ?? '') == 'low' ? 'selected' : '' }}>Rendah</option>
                    </select>
                    @error('priority') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Frekuensi <span class="text-danger">*</span></label>
                    <select name="frequency" class="form-select @error('frequency') is-invalid @enderror" required>
                        <option value="daily" {{ old('frequency', $responsibility->frequency ?? '') == 'daily' ? 'selected' : '' }}>Harian</option>
                        <option value="weekly" {{ old('frequency', $responsibility->frequency ?? '') == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                        <option value="monthly" {{ old('frequency', $responsibility->frequency ?? '') == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                        <option value="yearly" {{ old('frequency', $responsibility->frequency ?? '') == 'yearly' ? 'selected' : '' }}>Tahunan</option>
                        <option value="as_needed" {{ old('frequency', $responsibility->frequency ?? '') == 'as_needed' ? 'selected' : '' }}>Sesuai Kebutuhan</option>
                    </select>
                    @error('frequency') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Estimasi Waktu (jam)</label>
                    <input type="number" name="estimated_hours" class="form-control"
                           value="{{ old('estimated_hours', $responsibility->estimated_hours ?? '') }}" min="0" max="100" step="0.5">
                </div>

                <div class="col-12 mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_core_responsibility" value="1"
                               id="is_core" {{ old('is_core_responsibility', $responsibility->is_core_responsibility ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_core">
                            Tugas Inti (Core Responsibility)
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('job-responsibilities.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary float-end">
                    <i class="fas fa-save"></i> {{ isset($responsibility) ? 'Update' : 'Simpan' }} Tugas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
