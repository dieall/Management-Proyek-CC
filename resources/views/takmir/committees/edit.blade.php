@extends('layouts.app')

@section('title', 'Edit Pengurus')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Data Pengurus</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Pengurus</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('committees.update', $committee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="full_name">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                       id="full_name" name="full_name" value="{{ old('full_name', $committee->full_name) }}" required>
                @error('full_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $committee->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone_number">No HP</label>
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" 
                               id="phone_number" name="phone_number" value="{{ old('phone_number', $committee->phone_number) }}">
                        @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="gender">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                            <option value="male" {{ old('gender', $committee->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ old('gender', $committee->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="position_id">Posisi/Jabatan</label>
                        <select class="form-control @error('position_id') is-invalid @enderror" id="position_id" name="position_id">
                            <option value="">- Pilih Posisi -</option>
                            @foreach($positions as $pos)
                                <option value="{{ $pos->id }}" {{ old('position_id', $committee->position_id) == $pos->id ? 'selected' : '' }}>{{ $pos->name }}</option>
                            @endforeach
                        </select>
                        @error('position_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="address">Alamat</label>
                <textarea class="form-control @error('address') is-invalid @enderror" 
                          id="address" name="address" rows="3">{{ old('address', $committee->address) }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="birth_date">Tanggal Lahir</label>
                        <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                               id="birth_date" name="birth_date" value="{{ old('birth_date', $committee->birth_date ? $committee->birth_date->format('Y-m-d') : '') }}">
                        @error('birth_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="join_date">Tanggal Bergabung</label>
                        <input type="date" class="form-control @error('join_date') is-invalid @enderror" 
                               id="join_date" name="join_date" value="{{ old('join_date', $committee->join_date ? $committee->join_date->format('Y-m-d') : '') }}">
                        @error('join_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="active_status">Status <span class="text-danger">*</span></label>
                        <select class="form-control @error('active_status') is-invalid @enderror" id="active_status" name="active_status" required>
                            <option value="active" {{ old('active_status', $committee->active_status) == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('active_status', $committee->active_status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            <option value="resigned" {{ old('active_status', $committee->active_status) == 'resigned' ? 'selected' : '' }}>Mengundurkan Diri</option>
                        </select>
                        @error('active_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="user_id">Link ke User (Opsional)</label>
                        <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
                            <option value="">- Pilih User -</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $committee->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name ?? $user->nama_lengkap }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="photo">Foto</label>
                        @if($committee->photo_path)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $committee->photo_path) }}" alt="Foto" style="max-width: 100px; max-height: 100px;">
                                <p class="small text-muted">Foto saat ini</p>
                            </div>
                        @endif
                        <input type="file" class="form-control-file @error('photo') is-invalid @enderror" 
                               id="photo" name="photo" accept="image/*">
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Format: JPG, PNG, GIF (Max: 2MB)</small>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="cv">CV/Dokumen (PDF/DOC)</label>
                @if($committee->cv_path)
                    <div class="mb-2">
                        <a href="{{ asset('storage/' . $committee->cv_path) }}" target="_blank" class="btn btn-sm btn-info">Lihat CV Saat Ini</a>
                    </div>
                @endif
                <input type="file" class="form-control-file @error('cv') is-invalid @enderror" 
                       id="cv" name="cv" accept=".pdf,.doc,.docx">
                @error('cv')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Format: PDF, DOC, DOCX (Max: 5MB)</small>
            </div>

            <div class="form-group">
                <a href="{{ route('committees.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection











