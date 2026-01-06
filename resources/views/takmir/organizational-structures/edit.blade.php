@extends('layouts.app')

@section('title', 'Edit Struktur Organisasi')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Struktur Organisasi</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Struktur Organisasi</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('organizational-structures.update', $organizationalStructure->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_division" name="is_division" value="1" {{ old('is_division', $organizationalStructure->is_division) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_division">
                        Ini adalah Divisi/Bagian (bukan posisi individual)
                    </label>
                </div>
            </div>

            <div id="division_fields" style="display: {{ old('is_division', $organizationalStructure->is_division) ? 'block' : 'none' }};">
                <div class="form-group">
                    <label for="division_name">Nama Divisi/Bagian</label>
                    <input type="text" class="form-control @error('division_name') is-invalid @enderror" 
                           id="division_name" name="division_name" value="{{ old('division_name', $organizationalStructure->division_name) }}">
                    @error('division_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="division_description">Deskripsi Divisi</label>
                    <textarea class="form-control @error('division_description') is-invalid @enderror" 
                              id="division_description" name="division_description" rows="3">{{ old('division_description', $organizationalStructure->division_description) }}</textarea>
                    @error('division_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div id="position_fields" style="display: {{ old('is_division', $organizationalStructure->is_division) ? 'none' : 'block' }};">
                <div class="form-group">
                    <label for="position_id">Posisi/Jabatan</label>
                    <select class="form-control @error('position_id') is-invalid @enderror" id="position_id" name="position_id">
                        <option value="">- Pilih Posisi -</option>
                        @foreach($positions as $pos)
                            <option value="{{ $pos->id }}" {{ old('position_id', $organizationalStructure->position_id) == $pos->id ? 'selected' : '' }}>{{ $pos->name }}</option>
                        @endforeach
                    </select>
                    @error('position_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="parent_id">Parent/Atasan</label>
                <select class="form-control @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                    <option value="">- Tanpa Parent (Root) -</option>
                    @foreach($structures as $struct)
                        <option value="{{ $struct->id }}" {{ old('parent_id', $organizationalStructure->parent_id) == $struct->id ? 'selected' : '' }}>
                            {{ $struct->is_division ? $struct->division_name : ($struct->position->name ?? '-') }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="order">Order/Urutan</label>
                <input type="number" class="form-control @error('order') is-invalid @enderror" 
                       id="order" name="order" value="{{ old('order', $organizationalStructure->order) }}">
                @error('order')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <a href="{{ route('organizational-structures.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('is_division').addEventListener('change', function() {
        var divisionFields = document.getElementById('division_fields');
        var positionFields = document.getElementById('position_fields');
        if (this.checked) {
            divisionFields.style.display = 'block';
            positionFields.style.display = 'none';
        } else {
            divisionFields.style.display = 'none';
            positionFields.style.display = 'block';
        }
    });
</script>
@endpush
@endsection








