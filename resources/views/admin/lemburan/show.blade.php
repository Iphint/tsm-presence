@extends('layouts.app')

@section('title', 'Detail Lemburan')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between my-2">
        <div class="">
            <h1 class="h3 mb-2 text-gray-800">Detail Data Lemburan</h1>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal">Tanggal:</label>
                        <p>{{ $lembur->tanggal }}</p>
                    </div>
                    <div class="form-group">
                        <label for="start_lembur">Mulai:</label>
                        <p>{{ $lembur->start_lembur }}</p>
                    </div>
                    <div class="form-group">
                        <label for="selesai_lembur">Selesai:</label>
                        <p>{{ $lembur->selesai_lembur }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tugas">Tugas:</label>
                        <p>{{ $lembur->tugas }}</p>
                    </div>
                    <div class="form-group">
                        <label for="salary_lembur">Gaji Lembur:</label>
                        <p>Rp. {{ number_format($lembur->salary_lembur, 0, ',', '.') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="action">Status:</label>
                        <p>
                            @if ($lembur->action == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif ($lembur->action == 'approved')
                                <span class="badge badge-success">Approved</span>
                            @else
                                <span class="badge badge-danger">Rejected</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <a href="{{ route('lembur-admin.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
            <a href="{{ route('lembur-admin.edit', $lembur->id) }}" class="btn btn-sm btn-primary">Process</a>
        </div>
    </div>

</div>
@endsection