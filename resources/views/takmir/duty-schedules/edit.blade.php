@extends('layouts.app')

@section('title', 'Edit Jadwal Piket')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Jadwal Piket/Tugas</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Jadwal Piket/Tugas</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('duty-schedules.update', $dutySchedule->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="committee_id">Pengurus <span class="text-danger">*</span></label>
                <select class="form-control @error('committee_id') is-invalid @enderror" id="committee_id" name="committee_id" required>
                    <option value="">- Pilih Pengurus -</option>
                    @foreach($committees as $comm)
                        <option value="{{ $comm->id }}" {{ old('committee_id', $dutySchedule->committee_id) == $comm->id ? 'selected' : '' }}>
                            {{ $comm->full_name }} - {{ $comm->position->name ?? '-' }}
                        </option>
                    @endforeach
                </select>
                @error('committee_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="duty_date">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('duty_date') is-invalid @enderror" 
                               id="duty_date" name="duty_date" value="{{ old('duty_date', $dutySchedule->duty_date->format('Y-m-d')) }}" required>
                        @error('duty_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="start_time">Waktu Mulai <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('start_time') is-invalid @enderror" 
                               id="start_time" name="start_time" value="{{ old('start_time', $dutySchedule->start_time) }}" required>
                        @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="end_time">Waktu Selesai <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('end_time') is-invalid @enderror" 
                               id="end_time" name="end_time" value="{{ old('end_time', $dutySchedule->end_time) }}" required>
                        @error('end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="location">Lokasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" 
                               id="location" name="location" value="{{ old('location', $dutySchedule->location) }}" required>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="duty_type">Tipe Tugas <span class="text-danger">*</span></label>
                        <select class="form-control @error('duty_type') is-invalid @enderror" id="duty_type" name="duty_type" required>
                            <option value="piket" {{ old('duty_type', $dutySchedule->duty_type) == 'piket' ? 'selected' : '' }}>Piket</option>
                            <option value="kebersihan" {{ old('duty_type', $dutySchedule->duty_type) == 'kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                            <option value="keamanan" {{ old('duty_type', $dutySchedule->duty_type) == 'keamanan' ? 'selected' : '' }}>Keamanan</option>
                            <option value="acara" {{ old('duty_type', $dutySchedule->duty_type) == 'acara' ? 'selected' : '' }}>Acara</option>
                            <option value="lainnya" {{ old('duty_type', $dutySchedule->duty_type) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('duty_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="status">Status <span class="text-danger">*</span></label>
                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="scheduled" {{ old('status', $dutySchedule->status) == 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                    <option value="ongoing" {{ old('status', $dutySchedule->status) == 'ongoing' ? 'selected' : '' }}>Berjalan</option>
                    <option value="completed" {{ old('status', $dutySchedule->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ old('status', $dutySchedule->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="remarks">Keterangan</label>
                <textarea class="form-control @error('remarks') is-invalid @enderror" 
                          id="remarks" name="remarks" rows="3">{{ old('remarks', $dutySchedule->remarks) }}</textarea>
                @error('remarks')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_recurring" name="is_recurring" value="1" {{ old('is_recurring', $dutySchedule->is_recurring) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_recurring">
                        Jadwal Berulang
                    </label>
                </div>
            </div>

            <div id="recurring_fields" style="display: {{ old('is_recurring', $dutySchedule->is_recurring) ? 'block' : 'none' }};">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="recurring_type">Tipe Pengulangan</label>
                            <select class="form-control" id="recurring_type" name="recurring_type">
                                <option value="daily" {{ old('recurring_type', $dutySchedule->recurring_type) == 'daily' ? 'selected' : '' }}>Harian</option>
                                <option value="weekly" {{ old('recurring_type', $dutySchedule->recurring_type) == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                                <option value="monthly" {{ old('recurring_type', $dutySchedule->recurring_type) == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                                <option value="yearly" {{ old('recurring_type', $dutySchedule->recurring_type) == 'yearly' ? 'selected' : '' }}>Tahunan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="recurring_end_date">Tanggal Berakhir</label>
                            <input type="date" class="form-control" id="recurring_end_date" name="recurring_end_date" value="{{ old('recurring_end_date', $dutySchedule->recurring_end_date ? $dutySchedule->recurring_end_date->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <a href="{{ route('duty-schedules.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('is_recurring').addEventListener('change', function() {
        document.getElementById('recurring_fields').style.display = this.checked ? 'block' : 'none';
    });
</script>
@endpush
@endsection







