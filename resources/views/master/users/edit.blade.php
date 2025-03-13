@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container">
    <h1 class="h3 mb-4 text-gray-800">Edit User</h1>
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="posisi" class="form-label">Posisi</label>
            <select name="posisi" id="posisi" class="form-control" required>
                <option value="">-- Pilih Posisi Jabatan --</option>
                @foreach ($jabatans as $jabatan)
                <option value="{{ $jabatan->nama_jabatan }}" {{ $user->posisi == $jabatan->nama_jabatan ? 'selected' : '' }}>
                    {{ $jabatan->nama_jabatan }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="outlet_cabang" class="form-label">Outlet Cabang</label>
            <select name="outlet_cabang" id="outlet_cabang" class="form-control" required>
                <option value="">-- Pilih Outlet Cabang --</option>
                @foreach ($outlets as $outlet)
                <option value="{{ $outlet->nama_outlet }}" {{ $user->outlet_cabang == $outlet->nama_outlet ? 'selected' : '' }}>
                    {{ $outlet->nama_outlet }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="duration" class="form-label">Duration</label>
            <input type="date" name="duration" id="duration" class="form-control" value="{{ old('duration', $user->duration) }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="form-control" value="{{ old('alamat', $user->alamat) }}">
        </div>

        <div class="mb-3">
            <label for="nik" class="form-label">NIK</label>
            <input type="text" name="nik" id="nik" class="form-control" value="{{ old('nik', $user->nik) }}" required>
        </div>

        <div class="mb-3">
            <label for="npwp" class="form-label">NPWP</label>
            <input type="text" name="npwp" id="npwp" class="form-control" value="{{ old('npwp', $user->npwp) }}">
        </div>

        <div class="mb-3">
            <label for="no_rek" class="form-label">No rekening</label>
            <input type="text" name="no_rek" id="no_rek" class="form-control" value="{{ old('npwp', $user->no_rek) }}">
            @error('no_rek')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="bpjs" class="form-label">BPJS</label>
            <input type="text" name="bpjs" id="bpjs" class="form-control" value="{{ old('bpjs', $user->bpjs) }}">
        </div>

        <div class="mb-3">
            <label for="ketenagakerjaan" class="form-label">Ketenagakerjaan</label>
            <input type="text" name="ketenagakerjaan" id="ketenagakerjaan" class="form-control" value="{{ old('ketenagakerjaan', $user->ketenagakerjaan) }}">
        </div>

        <div class="mb-3">
            <label for="ptkp" class="form-label">PTKP</label>
            <select name="ptkp" id="ptkp" class="form-control" required>
                <option value="">-- Pilih PTKP --</option>
                @php
                $ptkpOptions = ["K/1", "K/2", "K/3", "K/4", "K/5", "K/6", "K/7", "TK/0", "TK/1", "TK/2", "TK/3", "TK/4", "TK/5", "TK/6", "TK/7"];
                @endphp
                @foreach ($ptkpOptions as $option)
                <option value="{{ $option }}" {{ old('ptkp', $user->ptkp) == $option ? 'selected' : '' }}>{{ $option }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="master_admin" {{ old('role', $user->role) == 'master_admin' ? 'selected' : '' }}>Master Admin</option>
                <option value="pegawai" {{ old('role', $user->role) == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
            </select>
            @error('role')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            @if ($user->photo)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $user->photo) }}" alt="User Photo" style="width: 100px; height: 100px; object-fit: cover;">
            </div>
            @endif
            <input type="file" name="photo" id="photo" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection