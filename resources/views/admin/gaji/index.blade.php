@extends('layouts.app')

@section('title', 'Gaji')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between my-2">
        <div class="">
            <h1 class="h3 mb-2 text-gray-800">Gaji Bulan Ini</h1>
            <p>berikut perhitungan secara sistem, dan apabila terdapat lemburan boleh untuk di ajukan dan di approve oleh kepala toko masing - masing</p>
        </div>
        <a href="{{ route('gaji.print') }}" class="btn btn-secondary btn-sm">
            salary slip <i class="fas fa-arrow-down fa-sm"></i>
        </a>
    </div>


    <!-- Gaji Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="card-title">Gaji pokok per hari ini</h5>
                    <p class="card-text">
                        <strong>Rp. {{ number_format($totalGaji, 0, ',', '.') }}</strong>
                    </p>
                </div>
                <div class="col-md-4">
                    <h5 class="card-title">Jumlah hari kerja</h5>
                    <p class="card-text">
                        <strong>{{ $masukDays }} Hari</strong>
                    </p>
                </div>
                <div class="col-md-4">
                    <h5 class="card-title">Jumlah izin kerja</h5>
                    <p class="card-text">
                        <strong>{{ $izinDays }} Hari</strong>
                    </p>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="card-title">Total lembur</h5>
                    <p class="card-text">
                        <strong>{{ $totalJamLembur }} Jam</strong>
                    </p>
                </div>
                <div class="col-md-4">
                    <h5 class="card-title">Tunjangan masa kerja</h5>
                    <p class="card-text">
                        <strong>Rp. {{ number_format($tunjanganMasaKerja, 0, ',', '.') }}</strong>
                    </p>
                </div>
                <div class="col-md-4">
                    <h5 class="card-title">Jumlah absent</h5>
                    <p class="card-text">
                        <strong> {{ $absentDays }} Hari</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection