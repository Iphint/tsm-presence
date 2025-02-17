@extends('layouts.app')

@section('title', 'Data Presensi')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between my-2">
        <h1 class="h3 mb-2 text-gray-800">Pengajuan Dispensasi</h1>
        <a href="{{ route('pengajuan-pegawai.create') }}" class="btn btn-outline-secondary">Daily check</a>
    </div>
    <form action="{{ route('pengajuan-pegawai.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="datang">Start Date</label>
            <input type="datetime-local" class="form-control" name="datang" required>
        </div>

        <div class="form-group">
            <label for="pulang">End Date</label>
            <input type="datetime-local" class="form-control" name="pulang">
        </div>

        <div class="form-group">
            <label for="location">Outlet</label>
            <select name="outlet_cabang" id="outlet_cabang" class="form-control" required>
                <option value="">-- Pilih Outlet Cabang --</option>
                @foreach ($outlets as $outlet)
                <option value="{{ $outlet->nama_outlet }}">{{ $outlet->nama_outlet }}</option>
                @endforeach
            </select>
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
            <label for="image">Upload Bukti Dispensasi</label>
            <input type="file" class="form-control-file" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection