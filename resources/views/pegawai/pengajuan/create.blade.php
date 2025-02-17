@extends('layouts.app')

@section('title', 'Form Pengajuan')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between my-2">
        <h1 class="h3 mb-2 text-gray-800">Form Pengajuan</h1>
    </div>

    <form action="{{ route('presence.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="datang">Masuk</label>
            <input type="datetime-local" class="form-control" name="datang" required>
        </div>

        <div class="form-group">
            <label for="pulang">Pulang</label>
            <input type="datetime-local" class="form-control" name="pulang">
        </div>

        <div class="form-group">
            <label for="location">Lokasi</label>
            <input type="text" class="form-control" name="location">
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" name="status" required>
                <option value="masuk">Masuk</option>
                <option value="off">Off</option>
                <option value="sakit">Sakit</option>
                <option value="izin">Izin</option>
                <option value="cuti">Cuti</option>
                <option value="absent">Absent</option>
            </select>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea class="form-control" name="keterangan"></textarea>
        </div>

        <div class="form-group">
            <label for="image">Upload Bukti Kehadiran</label>
            <input type="file" class="form-control-file" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

</div>
@endsection