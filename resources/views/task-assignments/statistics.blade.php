@extends('layouts.app')

@section('title', 'Statistik Penugasan')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Statistik Penugasan Tugas</h1>
    <a href="{{ route('task-assignments.index') }}" class="btn btn-primary shadow-sm">
        <i class="fas fa-clipboard-check"></i> Kembali ke Daftar
    </a>
</div>

<!-- Summary Cards -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Penugasan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-tasks fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Selesai</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['by_status']['completed'] ?? 0 }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Dalam Proses</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['in_progress_assignments'] ?? 0 }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-spinner fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Terlambat</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['overdue'] ?? 0 }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Distribusi Status</h6>
            </div>
            <div class="card-body">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Top 5 Pengurus Aktif</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead><tr><th>#</th><th>Pengurus</th><th>Jumlah</th></tr></thead>
                    <tbody>
                        @foreach($topCommittees as $i => $c)
                        <tr><td>{{ $i+1 }}</td><td>{{ $c->full_name }}</td><td>{{ $c->assignment_count }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Selesai', 'Proses', 'Pending', 'Terlambat'],
        datasets: [{
            data: [{{ $stats['by_status']['completed'] ?? 0 }}, {{ $stats['in_progress_assignments'] ?? 0 }}, {{ $stats['by_status']['pending'] ?? 0 }}, {{ $stats['overdue'] ?? 0 }}],
            backgroundColor: ['#1cc88a', '#f6c23e', '#36b9cc', '#e74a3b']
        }]
    },
    options: { maintainAspectRatio: false }
});
</script>
@endpush
