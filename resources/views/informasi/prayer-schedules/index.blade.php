@extends('layouts.app')

@section('title', 'Jadwal Sholat (Dari API)')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">🕌 Jadwal Sholat</h1>
</div>

<div class="alert alert-info">
    <i class="fas fa-info-circle"></i> 
    <strong>Informasi:</strong> Mulai sekarang jadwal sholat di halaman landing diambil otomatis dari API Kota Bandung.
    Halaman ini tidak lagi menggunakan input/CRUD manual, sehingga pengaturan jadwal dilakukan langsung dari sumber API.
</div>
@endsection













