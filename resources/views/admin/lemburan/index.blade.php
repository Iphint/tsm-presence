@extends('layouts.app')

@section('title', 'Gaji')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between my-2">
        <div class="">
            <h1 class="h3 mb-2 text-gray-800">Lemburan</h1>
            <p>Berikut pengajuan lembur karyawan.</p>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pengajuan Lemburan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Tanggal</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th>Status</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lemburs as $lembur)
                        <tr>
                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                            <td>{{ $lembur->user->name }}</td>
                            <td>{{ $lembur->user->posisi }}</td>
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
                            <td style="text-align: center;">
                                <a href="{{ route('lembur-admin.edit', $lembur->id) }}" class="btn btn-sm btn-primary">Process</a>
                                <a href="{{ route('lembur-admin.show', $lembur->id) }}" class="btn btn-sm btn-info">Detail</a>
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