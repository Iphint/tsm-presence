@extends('layouts.app')

@section('title', 'Data Pajak')

@section('content')
<!-- Page Heading -->
<div class="d-flex justify-content-between my-2">
    <h1 class="h3 mb-2 text-gray-800">Data Laporan Pajak</h1>
    <form method="GET" action="{{ route('pajak.index') }}">
        <label for="bulan">Pilih Bulan:</label>
        <input type="month" id="bulan" name="bulan" value="{{ $bulan }}" class="form-control d-inline-block" style="width: 200px;">
        <button type="submit" class="btn btn-primary">Cari</button>
    </form>
</div>
<a href="{{ route('pajak.export-excel', ['bulan' => request('bulan')]) }}" class="btn btn-success mb-2">
    Cetak Excel
</a>
<div class="table-responsive">
    <table class="table table-striped table-bordered text-nowrap">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th style="width: 15%;">Tgl Pemotongan (dd/MM/yyyy)</th>
                <th style="width: 10%;">Penerima Penghasilan? (NPWP/NIK)</th>
                <th style="width: 10%;">NPWP (tanpa format/tanda baca)</th>
                <th style="width: 10%;">NIK (tanpa format/tanda baca)</th>
                <th style="width: 10%;">Nama Penerima Penghasilan Sesuai NIK</th>
                <th style="width: 10%;">Alamat Penerima Penghasilan Sesuai NIK</th>
                <th style="width: 10%;">Kode Objek Pajak</th>
                <th style="width: 10%;">Penandatangan Menggunakan? (NPWP/NIK)</th>
                <th style="width: 10%;">NPWP Penandatangan (tanpa format/tanda baca)</th>
                <th style="width: 10%;">NIK Penandatangan (tanpa format/tanda baca)</th>
                <th style="width: 10%;">Kode PTKP</th>
                <th style="width: 10%;">Pegawai Harian? (Ya/Tidak)</th>
                <th style="width: 10%;">Menggunakan Gross Up? (Ya/Tidak)</th>
                <th style="width: 10%;">Penghasilan Bruto</th>
                <th style="width: 10%;">Terdapat Akumulasi Penghasilan Bruto Sebelumnya? (Ya/Tidak)</th>
                <th style="width: 10%;">Akumulasi Penghasilan Bruto Sebelumnya</th>
                <th style="width: 10%;">Mendapatkan Fasilitas ? (N/SKB/DTP)</th>
                <th style="width: 10%;">Nomor SKB/Nomor DTP</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataPajak as $pajak)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $pajak['tanggal_pemotongan'] }}</td>
                <td>NIK</td>
                <td>{{ $pajak['npwp'] }} </td>
                <td>{{ $pajak['nik'] }} </td>
                <td>{{ $pajak['nama'] }}</td>
                <td>{{ $pajak['alamat'] }}</td>
                <td>21-100-01</td>
                <td>NPWP</td>
                <td>933607194429000</td>
                <td>3273201705880002</td>
                <td>{{ $pajak['ptkp'] }} </td>
                <td>Tidak</td>
                <td>Tidak</td>
                <td>Rp {{ number_format($pajak['totalGaji'], 0, ',', '.') }}</td>
                <td>Tidak</td>
                <td>Rp {{ number_format($pajak['net_salary_bulan_sebelumnya'], 0, ',', '.') }}</td>
                <td>N</td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection