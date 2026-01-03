<!-- resources/views/committees/create.blade.php -->
@extends('layouts.app')

@section('title', 'Tambah Pengurus')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Pengurus</h1>
</div>

<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('committees.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror"
                               value="{{ old('full_name') }}" required>
                        @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                            <option value="">Pilih</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="birth_date" class="form-control"
                               value="{{ old('birth_date') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Tanggal Bergabung</label>
                        <input type="date" name="join_date" class="form-control"
                               value="{{ old('join_date') }}">
                        <small class="text-muted">Kosongkan = hari ini</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Telepon</label>
                        <input type="text" name="phone_number" class="form-control"
                               value="{{ old('phone_number') }}">
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group mb-3">
                        <label>Alamat</label>
                        <textarea name="address" class="form-control" rows="3">{{ old('address') }}</textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Jabatan</label>
                        <select name="position_id" class="form-select">
                            <option value="">Tidak ada jabatan</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                    {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="active_status" class="form-select" required>
                            <option value="active" {{ old('active_status', 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('active_status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            <option value="resigned" {{ old('active_status') == 'resigned' ? 'selected' : '' }}>Mengundurkan Diri</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('committees.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary float-end">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
