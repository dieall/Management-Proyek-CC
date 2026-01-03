@extends('layouts.app')

@section('title', isset($position) ? 'Edit' : 'Tambah' . ' Jabatan')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ isset($position) ? 'Edit' : 'Tambah Baru' }} Jabatan</h1>
</div>

<div class="card shadow">
    <div class="card-body">
        <form action="{{ isset($position) ? route('positions.update', $position->id) : route('positions.store') }}" method="POST">
            @csrf
            @if(isset($position)) @method('PUT') @endif

            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label">Nama Jabatan <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $position->name ?? '') }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Urutan Tampilan</label>
                    <input type="number" name="order" class="form-control" min="0"
                           value="{{ old('order', $position->order ?? '') }}" placeholder="0 = paling atas">
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Deskripsi Jabatan</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $position->description ?? '') }}</textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Jabatan Atasan</label>
                    <select name="parent_id" class="form-select">
                        <option value="">Tidak ada (Root)</option>
                        @foreach($positions as $pos)
                            @if(!isset($position) || $pos->id != $position->id)
                            <option value="{{ $pos->id }}" {{ old('parent_id', $position->parent_id ?? '') == $pos->id ? 'selected' : '' }}>
                                {{ $pos->name }}
                            </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Level Jabatan <span class="text-danger">*</span></label>
                    <select name="level" class="form-select @error('level') is-invalid @enderror" required>
                        <option value="leadership" {{ old('level', $position->level ?? '') == 'leadership' ? 'selected' : '' }}>Kepemimpinan</option>
                        <option value="division_head" {{ old('level', $position->level ?? '') == 'division_head' ? 'selected' : '' }}>Kepala Divisi</option>
                        <option value="staff" {{ old('level', $position->level ?? '') == 'staff' ? 'selected' : '' }}>Staf</option>
                        <option value="volunteer" {{ old('level', $position->level ?? '') == 'volunteer' ? 'selected' : '' }}>Relawan</option>
                    </select>
                    @error('level') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" {{ old('status', $position->status ?? 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', $position->status ?? '') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('positions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary float-end">
                    <i class="fas fa-save"></i> {{ isset($position) ? 'Update' : 'Simpan' }} Jabatan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
