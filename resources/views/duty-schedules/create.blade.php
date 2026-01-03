@extends('layouts.app')

@section('title', isset($schedule) ? 'Edit' : 'Tambah' . ' Jadwal')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ isset($schedule) ? 'Edit' : 'Tambah Baru' }} Jadwal</h1>
</div>

<div class="card shadow">
    <div class="card-body">
        <form action="{{ isset($schedule) ? route('duty-schedules.update', $schedule->id) : route('duty-schedules.store') }}" method="POST">
            @csrf
            @if(isset($schedule)) @method('PUT') @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pengurus <span class="text-danger">*</span></label>
                    <select name="committee_id" class="form-select @error('committee_id') is-invalid @enderror" required>
                        <option value="">Pilih Pengurus</option>
                        @foreach($committees as $committee)
                            <option value="{{ $committee->id }}" {{ old('committee_id', $schedule->committee_id ?? '') == $committee->id ? 'selected' : '' }}>
                                {{ $committee->full_name }} @if($committee->position) - {{ $committee->position->name }} @endif
                            </option>
                        @endforeach
                    </select>
                    @error('committee_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Tugas <span class="text-danger">*</span></label>
                    <select name="duty_type" class="form-select @error('duty_type') is-invalid @enderror" required>
                        <option value="">Pilih Jenis</option>
                        <option value="piket" {{ old('duty_type', $schedule->duty_type ?? '') == 'piket' ? 'selected' : '' }}>Piket</option>
                        <option value="kebersihan" {{ old('duty_type', $schedule->duty_type ?? '') == 'kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                        <option value="keamanan" {{ old('duty_type', $schedule->duty_type ?? '') == 'keamanan' ? 'selected' : '' }}>Keamanan</option>
                        <option value="administrasi" {{ old('duty_type', $schedule->duty_type ?? '') == 'administrasi' ? 'selected' : '' }}>Administrasi</option>
                        <option value="lainnya" {{ old('duty_type', $schedule->duty_type ?? '') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('duty_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="duty_date" class="form-control @error('duty_date') is-invalid @enderror"
                           value="{{ old('duty_date', $schedule->duty_date?->format('Y-m-d') ?? $defaultDate ?? now()->format('Y-m-d')) }}" required>
                    @error('duty_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Waktu Mulai <span class="text-danger">*</span></label>
                    <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror"
                           value="{{ old('start_time', $schedule->start_time?->format('H:i') ?? $defaultStartTime ?? '08:00') }}" required>
                    @error('start_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Waktu Selesai <span class="text-danger">*</span></label>
                    <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror"
                           value="{{ old('end_time', $schedule->end_time?->format('H:i') ?? $defaultEndTime ?? '12:00') }}" required>
                    @error('end_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                    <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                           value="{{ old('location', $schedule->location ?? '') }}" required>
                    @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="pending" {{ old('status', $schedule->status ?? 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="ongoing" {{ old('status', $schedule->status ?? '') == 'ongoing' ? 'selected' : '' }}>Sedang Berjalan</option>
                        <option value="completed" {{ old('status', $schedule->status ?? '') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ old('status', $schedule->status ?? '') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_recurring" name="is_recurring" value="1"
                               {{ old('is_recurring', $schedule->is_recurring ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_recurring">Jadwal Berulang</label>
                    </div>
                </div>

                <div id="recurringOptions" style="{{ old('is_recurring', $schedule->is_recurring ?? false) ? '' : 'display:none;' }}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Pengulangan</label>
                            <select name="recurring_type" class="form-select">
                                <option value="">Pilih</option>
                                <option value="daily" {{ old('recurring_type', $schedule->recurring_type ?? '') == 'daily' ? 'selected' : '' }}>Harian</option>
                                <option value="weekly" {{ old('recurring_type', $schedule->recurring_type ?? '') == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                                <option value="monthly" {{ old('recurring_type', $schedule->recurring_type ?? '') == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Berakhir Pada</label>
                            <input type="date" name="recurring_end_date" class="form-control"
                                   value="{{ old('recurring_end_date', $schedule->recurring_end_date?->format('Y-m-d') ?? '') }}">
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="remarks" class="form-control" rows="4">{{ old('remarks', $schedule->remarks ?? '') }}</textarea>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('duty-schedules.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary float-end">
                    <i class="fas fa-save"></i> {{ isset($schedule) ? 'Update' : 'Simpan' }} Jadwal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('is_recurring')?.addEventListener('change', function() {
    document.getElementById('recurringOptions').style.display = this.checked ? 'block' : 'none';
});
</script>
@endpush
