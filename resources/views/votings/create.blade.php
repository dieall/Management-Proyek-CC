@extends('layouts.app')

@section('title', 'Buat Voting Baru')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Buat Voting Baru</h1>
</div>

<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('votings.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label">Judul Voting <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title') }}" required placeholder="Contoh: Pemilihan Ketua Takmir 2026">
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Jabatan yang Dipilih</label>
                    <select name="position_id" class="form-select">
                        <option value="">Semua Jabatan (Opsional)</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                {{ $position->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="datetime-local" name="starts_at" class="form-control"
                           value="{{ old('starts_at', now()->addHour()->format('Y-m-d\TH:i')) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Berakhir</label>
                    <input type="datetime-local" name="ends_at" class="form-control"
                           value="{{ old('ends_at', now()->addDays(7)->format('Y-m-d\TH:i')) }}">
                    <small class="text-muted">Kosongkan = tidak ada batas waktu</small>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label">Kandidat <span class="text-danger">*</span></label>
                    <div id="candidates-container">
                        <div class="input-group mb-2 candidate-row">
                            <select name="candidate_ids[]" class="form-select @error('candidate_ids') is-invalid @enderror" required>
                                <option value="">Pilih Pengurus</option>
                                @foreach($committees as $committee)
                                    <option value="{{ $committee->id }}">{{ $committee->full_name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-outline-danger remove-candidate">×</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="add-candidate">
                        <i class="fas fa-plus"></i> Tambah Kandidat
                    </button>
                    @error('candidate_ids') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('votings.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn btn-success float-end">
                    <i class="fas fa-save"></i> Buat Voting
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('add-candidate').addEventListener('click', function() {
    const container = document.getElementById('candidates-container');
    const row = container.querySelector('.candidate-row').cloneNode(true);
    row.querySelector('select').value = '';
    container.appendChild(row);
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-candidate')) {
        if (document.querySelectorAll('.candidate-row').length > 1) {
            e.target.closest('.candidate-row').remove();
        }
    }
});
</script>
@endpush
