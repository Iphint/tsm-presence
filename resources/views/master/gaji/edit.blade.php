@extends('layouts.app')
@section('title', 'Data Presensi')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center my-2">
        <h1 class="h3 mb-2 text-gray-800">Edit tunjangan {{$user->name}} </h1>
    </div>
    <!-- Form Section -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('salary.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Allowances Section -->
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="tunjangan_masa_kerja" class="form-label">Tunjangan Masa Kerja</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="tunjangan_masa_kerja"
                                    name="tunjangan_masa_kerja"
                                    value="{{ $kinerja->tunjangan_masa_kerja ?? 0 }}"
                                    required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tunjangan_jabatan" class="form-label">Tunjangan Jabatan</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="tunjangan_jabatan"
                                    name="tunjangan_jabatan"
                                    value="{{ $kinerja->tunjangan_jabatan ?? 0 }}"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Form Actions -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('salary.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection