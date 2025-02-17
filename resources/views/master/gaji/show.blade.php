@extends('layouts.app')

@section('title', 'Data Presensi')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Detail Gaji - {{ $gajiDetail['nama'] }}</h2>
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Komponen</th>
                        <th scope="col">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Gaji Pokok</th>
                        <td>Rp {{ number_format($gajiDetail['gaji_pokok'], 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Gaji Harian</th>
                        <td>Rp {{ number_format($gajiDetail['gaji_harian'], 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Hari Kerja</th>
                        <td>{{ $gajiDetail['worked_days'] }} hari</td>
                    </tr>
                    <tr>
                        <th>Hari Masuk</th>
                        <td>{{ $gajiDetail['masuk_days'] }} hari</td>
                    </tr>
                    <tr>
                        <th>Hari Izin</th>
                        <td>{{ $gajiDetail['izin_days'] }} hari</td>
                    </tr>
                    <tr>
                        <th>Hari Absen</th>
                        <td>{{ $gajiDetail['absent_days'] }} hari</td>
                    </tr>
                    <tr>
                        <th>Total Lembur</th>
                        <td>{{ $gajiDetail['total_jam_lembur'] }} jam</td>
                    </tr>
                    <tr>
                        <th>Gaji Lembur</th>
                        <td>Rp {{ number_format($gajiDetail['total_gaji_lembur'], 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Tunjangan Jabatan</th>
                        <td>Rp {{ number_format($gajiDetail['tunjangan_jabatan'], 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Tunjangan Masa Kerja</th>
                        <td>Rp {{ number_format($gajiDetail['tunjangan_masa_kerja'], 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>BPJS</th>
                        <td>Rp {{ number_format($gajiDetail['bpjs'], 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Denda Absen</th>
                        <td>Rp {{ number_format($gajiDetail['denda_absent'], 0, ',', '.') }}</td>
                    </tr>
                    <tr class="table-success">
                        <th>Total Gaji</th>
                        <td><strong>Rp {{ number_format($gajiDetail['total_gaji'], 0, ',', '.') }}</strong></td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-4">
                <a href="{{ route('salary.index') }}" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection