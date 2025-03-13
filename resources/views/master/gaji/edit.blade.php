@extends('layouts.app')
@section('title', 'Edit Tunjangan')
@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center my-3">
        <h1 class="h4 text-gray-800">Edit Tunjangan - {{ $user->name }}</h1>
    </div>

    <!-- Card Form -->
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Form Edit Tunjangan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('salary.update', $kinerja->id ?? '') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Tunjangan Masa Kerja -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tunjangan_masa_kerja" class="form-label">Tunjangan Masa Kerja</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('tunjangan_masa_kerja') is-invalid @enderror"
                                    id="tunjangan_masa_kerja" name="tunjangan_masa_kerja"
                                    value="{{ old('tunjangan_masa_kerja', $kinerja->tunjangan_masa_kerja ?? 0) }}" required>
                            </div>
                            @error('tunjangan_masa_kerja')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tunjangan Jabatan -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tunjangan_jabatan" class="form-label">Tunjangan Jabatan</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('tunjangan_jabatan') is-invalid @enderror"
                                    id="tunjangan_jabatan" name="tunjangan_jabatan"
                                    value="{{ old('tunjangan_jabatan', $kinerja->tunjangan_jabatan ?? 0) }}" required>
                            </div>
                            @error('tunjangan_jabatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Potongan Ukhro -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="potongan" class="form-label">Potongan Ukhro</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('potongan') is-invalid @enderror"
                                    id="potongan" name="potongan"
                                    value="{{ old('potongan', $kinerja->potongan ?? 0) }}" required>
                            </div>
                            @error('potongan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('salary.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection