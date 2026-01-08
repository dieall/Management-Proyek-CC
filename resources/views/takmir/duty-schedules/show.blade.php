@extends('layouts.app')

@section('title', 'Detail Jadwal Piket')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Jadwal Piket/Tugas</h1>
    <div>
        <a href="{{ route('duty-schedules.edit', $dutySchedule->id) }}" class="btn btn-warning btn-icon-split">
            <span class="icon text-white-50"><i class="fas fa-edit"></i></span>
            <span class="text">Edit</span>
        </a>
        <a href="{{ route('duty-schedules.index') }}" class="btn btn-secondary btn-icon-split">
            <span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
            <span class="text">Kembali</span>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Jadwal Piket</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Pengurus</th>
                        <td>: <a href="{{ route('committees.show', $dutySchedule->committee->id) }}">{{ $dutySchedule->committee->full_name }}</a></td>
                    </tr>
                    <tr>
                        <th>Posisi</th>
                        <td>: {{ $dutySchedule->committee->position->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>: {{ $dutySchedule->duty_date->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Waktu</th>
                        <td>: {{ $dutySchedule->start_time }} - {{ $dutySchedule->end_time }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <td>: {{ $dutySchedule->location }}</td>
                    </tr>
                    <tr>
                        <th>Tipe Tugas</th>
                        <td>: {{ ucfirst($dutySchedule->duty_type) }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>: 
                            @if($dutySchedule->status == 'completed')
                                <span class="badge badge-success">Selesai</span>
                            @elseif($dutySchedule->status == 'ongoing')
                                <span class="badge badge-info">Berjalan</span>
                            @elseif($dutySchedule->status == 'cancelled')
                                <span class="badge badge-danger">Dibatalkan</span>
                            @else
                                <span class="badge badge-warning">Terjadwal</span>
                            @endif
                        </td>
                    </tr>
                    @if($dutySchedule->is_recurring)
                    <tr>
                        <th>Jadwal Berulang</th>
                        <td>: Ya ({{ ucfirst($dutySchedule->recurring_type) }})</td>
                    </tr>
                    @if($dutySchedule->recurring_end_date)
                    <tr>
                        <th>Berakhir Pada</th>
                        <td>: {{ $dutySchedule->recurring_end_date->format('d/m/Y') }}</td>
                    </tr>
                    @endif
                    @endif
                    @if($dutySchedule->remarks)
                    <tr>
                        <th>Keterangan</th>
                        <td>: {{ $dutySchedule->remarks }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection











