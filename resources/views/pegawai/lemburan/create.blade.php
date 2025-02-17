@extends('layouts.app')

@section('title', 'lemburan')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between my-2">
        <div class="">
            <h1 class="h3 mb-2 text-gray-800">Form Pengajuan Lemburan</h1>
            <p>Untuk lemburan ada SOP tersendiri, silahkan jika masih bingung, tanyakan kepada kepala outlet.</p>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('lembur-pegawai.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control">
                </div>

                <div class="form-group">
                    <label>Jam Lembur</label>
                    <div class="input-group">
                        <input type="time" name="start_lembur" id="start_lembur" class="form-control">
                        <span class="input-group-text">→</span>
                        <input type="time" name="selesai_lembur" id="selesai_lembur" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="tugas">Tugas Lemburan</label>
                    <textarea name="tugas" id="tugas" class="form-control">{{ $lembur->tugas ?? '' }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Ajukan</button>
            </form>

        </div>
    </div>

</div>
@endsection