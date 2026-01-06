@extends('layouts.app')

@section('title', 'Edit Jadwal Sholat')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Jadwal Sholat - {{ $prayerSchedule->prayer_name }}</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Jadwal</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('prayer-schedules.update', $prayerSchedule->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="prayer_name">Waktu Sholat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('prayer_name') is-invalid @enderror" 
                       id="prayer_name" name="prayer_name" value="{{ old('prayer_name', $prayerSchedule->prayer_name) }}" readonly>
                @error('prayer_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr>
            <h5>Waktu per Hari</h5>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="monday">Senin <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('monday') is-invalid @enderror" 
                               id="monday" name="monday" value="{{ old('monday', $prayerSchedule->monday) }}" required>
                        @error('monday')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tuesday">Selasa <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('tuesday') is-invalid @enderror" 
                               id="tuesday" name="tuesday" value="{{ old('tuesday', $prayerSchedule->tuesday) }}" required>
                        @error('tuesday')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="wednesday">Rabu <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('wednesday') is-invalid @enderror" 
                               id="wednesday" name="wednesday" value="{{ old('wednesday', $prayerSchedule->wednesday) }}" required>
                        @error('wednesday')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="thursday">Kamis <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('thursday') is-invalid @enderror" 
                               id="thursday" name="thursday" value="{{ old('thursday', $prayerSchedule->thursday) }}" required>
                        @error('thursday')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="friday">Jumat <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('friday') is-invalid @enderror" 
                               id="friday" name="friday" value="{{ old('friday', $prayerSchedule->friday) }}" required>
                        @error('friday')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="saturday">Sabtu <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('saturday') is-invalid @enderror" 
                               id="saturday" name="saturday" value="{{ old('saturday', $prayerSchedule->saturday) }}" required>
                        @error('saturday')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="sunday">Minggu <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('sunday') is-invalid @enderror" 
                               id="sunday" name="sunday" value="{{ old('sunday', $prayerSchedule->sunday) }}" required>
                        @error('sunday')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <a href="{{ route('prayer-schedules.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update Jadwal</button>
            </div>
        </form>
    </div>
</div>
@endsection










