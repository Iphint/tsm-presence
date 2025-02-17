@extends('layouts.app')

@section('title', 'Gaji')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between my-2">
        <div class="">
            <h1 class="h3 mb-2 text-gray-800">Lemburan</h1>
            <p>Berikut pengajuan lembur secara sistem, dan apabila lemburan belum di proses mendekati jam lembur yang di ajukan dimohon untuk melapor ke kepala toko masing - masing.
        </div>
        <a href="{{ route('lembur-pegawai.create') }}" class="btn btn-secondary btn-sm">Ajukan Lemburan</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Lemburan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 5%; text-align: center">No</th>
                            <th>Tanggal</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th>Status</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lemburs as $lembur)
                        <tr>
                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                            <td>{{ $lembur->tanggal }}</td>
                            <td>{{ $lembur->start_lembur }}</td>
                            <td>{{ $lembur->selesai_lembur }}</td>
                            <td>
                                @if ($lembur->action == 'pending')
                                <span class="badge badge-warning">Pending</span>
                                @elseif ($lembur->action == 'approved')
                                <span class="badge badge-success">Approved</span>
                                @else
                                <span class="badge badge-danger">Rejected</span>
                                @endif
                            </td>
                            <td>
                                @if ($lembur->action == 'approved')
                                Rp. {{ number_format($lembur->salary_lembur, 0, ',', '.') }}
                                @else
                                <span>wait for response</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection