@extends('layouts.app')

@section('content')
<h2>Dashboard User</h2>
<p>Halo {{ auth()->user()->nama_lengkap }}, ini dashboard pengguna biasa.</p>
@endsection