@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Outlet</h1>

    <form action="{{ route('outlet.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_outlet" class="form-label">Nama Outlet</label>
            <input type="text" name="nama_outlet" id="nama_outlet" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Outlet</button>
    </form>
</div>
@endsection