@extends('layouts.app')

@section('title', 'Tambah Jadwal Piket')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Jadwal Piket/Tugas Baru</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Jadwal Piket/Tugas</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('duty-schedules.store') }}" method="POST">
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

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="duty_date">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('duty_date') is-invalid @enderror" 
                               id="duty_date" name="duty_date" value="{{ old('duty_date') }}" required>
                        @error('duty_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="start_time">Waktu Mulai <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('start_time') is-invalid @enderror" 
                               id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                        @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="end_time">Waktu Selesai <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('end_time') is-invalid @enderror" 
                               id="end_time" name="end_time" value="{{ old('end_time') }}" required>
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
                               id="location" name="location" value="{{ old('location') }}" required>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="duty_type">Tipe Tugas <span class="text-danger">*</span></label>
                        <select class="form-control @error('duty_type') is-invalid @enderror" id="duty_type" name="duty_type" required>
                            <option value="piket" {{ old('duty_type', 'piket') == 'piket' ? 'selected' : '' }}>Piket</option>
                            <option value="kebersihan" {{ old('duty_type') == 'kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                            <option value="keamanan" {{ old('duty_type') == 'keamanan' ? 'selected' : '' }}>Keamanan</option>
                            <option value="acara" {{ old('duty_type') == 'acara' ? 'selected' : '' }}>Acara</option>
                            <option value="lainnya" {{ old('duty_type') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                    <option value="scheduled" {{ old('status', 'scheduled') == 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                    <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Berjalan</option>
                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="remarks">Keterangan</label>
                <textarea class="form-control @error('remarks') is-invalid @enderror" 
                          id="remarks" name="remarks" rows="3">{{ old('remarks') }}</textarea>
                @error('remarks')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_recurring" name="is_recurring" value="1" {{ old('is_recurring') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_recurring">
                        Jadwal Berulang
                    </label>
                </div>
            </div>

            <div id="recurring_fields" style="display: none;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="recurring_type">Tipe Pengulangan</label>
                            <select class="form-control" id="recurring_type" name="recurring_type">
                                <option value="daily" {{ old('recurring_type') == 'daily' ? 'selected' : '' }}>Harian</option>
                                <option value="weekly" {{ old('recurring_type') == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                                <option value="monthly" {{ old('recurring_type') == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                                <option value="yearly" {{ old('recurring_type') == 'yearly' ? 'selected' : '' }}>Tahunan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="recurring_end_date">Tanggal Berakhir</label>
                            <input type="date" class="form-control" id="recurring_end_date" name="recurring_end_date" value="{{ old('recurring_end_date') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <a href="{{ route('duty-schedules.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
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








