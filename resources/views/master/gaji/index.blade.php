@extends('layouts.app')

@section('title', 'Data Presensi')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center my-2">
        <h1 class="h3 mb-2 text-gray-800">Data Salary Karyawan</h1>
        <form method="GET" action="{{ route('salary.index') }}">
            <label for="bulan">Pilih Bulan:</label>
            <input type="month" id="bulan" name="bulan" value="{{ $bulan }}" class="form-control d-inline-block" style="width: 200px;">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </div>

    <h5 class="text-muted">Periode: {{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}</h5>

    <div class="table-responsive">
        <table class="table table-striped table-bordered text-nowrap">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th style="width: 15%;">Nama</th>
                    <th style="width: 10%;">Gaji Pokok</th>
                    <th style="width: 10%;">Gaji Harian</th>
                    <th style="width: 5%;">Hari Kerja</th>
                    <th style="width: 5%;">Hari Masuk</th>
                    <th style="width: 5%;">Izin/Off/Sakit/Cuti</th>
                    <th style="width: 5%;">Hari Absen</th>
                    <th style="width: 10%;">Gaji</th>
                    <th style="width: 10%;">Potongan Tidak Masuk</th>
                    <th style="width: 10%;">Tunjangan Masa Kerja</th>
                    <th style="width: 10%;">Tunjangan Jabatan</th>
                    <th>Total Jam Lembur</th>
                    <th style="width: 10%;">Total Gaji Lembur</th>
                    <th style="width: 10%;">BPJS Kesehatan</th>
                    <th style="width: 10%;">BPJS Ketenagakerjaan</th>
                    <th style="width: 10%;">Denda Absent</th>
                    <th style="width: 20%;">Net Salary</th>
                    <th style="width: 20%;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($dataGaji) > 0)
                @foreach ($dataGaji as $gaji)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $gaji['nama'] }}</td>
                    <td>Rp {{ number_format($gaji['gaji_pokok'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($gaji['gaji_harian'], 0, ',', '.') }}</td>
                    <td>{{ $gaji['worked_days'] }}</td>
                    <td>{{ $gaji['masuk_days'] }}</td>
                    <td>{{ $gaji['izin_days'] }}</td>
                    <td>{{ $gaji['absent_days'] }}</td>
                    <td>Rp {{ number_format($gaji['salary'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($gaji['denda_absent'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($gaji['tunjangan_masa_kerja'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($gaji['tunjangan_jabatan'], 0, ',', '.') }}</td>
                    <td>{{ $gaji['total_jam_lembur'] }}</td>
                    <td>Rp {{ number_format($gaji['total_gaji_lembur'], 0, ',', '.') }}</td>
                    <td class="font-weight-bold">Rp {{ number_format($gaji['bpjs'], 0, ',', '.') }}</td>
                    <td class="font-weight-bold">Rp {{ number_format($gaji['ketenagakerjaan'], 0, ',', '.') }}</td>
                    <td class="font-weight-bold">Rp {{ number_format($gaji['denda_absent'], 0, ',', '.') }}</td>
                    <td class="font-weight-bold">Rp {{ number_format($gaji['total_gaji'], 0, ',', '.') }}</td>
                    <td style="text-align: center;">
                        <!-- Tombol Lihat Detail -->
                        <a href="{{ route('salary.show', $gaji['id']) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </a>

                        <!-- Tombol Edit -->
                        <a href="{{ route('salary.edit', $gaji['id']) }}" class="btn btn-warning btn-sm mx-1" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>

                        <!-- Tombol Hapus dengan Form -->
                        <form action="{{ route('salary.destroy', $gaji['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mx-1" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @else
                @endif
            </tbody>
        </table>
    </div>
</div>
<!-- Modal Edit Tunjangan -->
<div class="modal fade" id="editTunjanganModal" tabindex="-1" role="dialog" aria-labelledby="editTunjanganModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTunjanganModalLabel">Edit Tunjangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editTunjanganForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tunjangan_masa_kerja">Tunjangan Masa Kerja</label>
                        <input type="number" class="form-control" id="tunjangan_masa_kerja" name="tunjangan_masa_kerja" required>
                    </div>
                    <div class="form-group">
                        <label for="tunjangan_jabatan">Tunjangan Jabatan</label>
                        <input type="number" class="form-control" id="tunjangan_jabatan" name="tunjangan_jabatan" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection