@extends('layouts.app')

@section('title', 'Edit Jabatan')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Jabatan</h1>
        <a href="{{ route('jabatan.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Kembali
        </a>
    </div>

    <!-- Edit Form -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('jabatan.update', $jabatan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="nama_jabatan" class="form-label">Nama Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_jabatan" id="nama_jabatan" class="form-control" value="{{ old('nama_jabatan', $jabatan->nama_jabatan) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="gaji_pokok" class="form-label">Gaji Pokok <span class="text-danger">*</span></label>
                            <input type="text" name="gaji_pokok" id="gaji_pokok" class="form-control" value="{{ old('gaji_pokok', $jabatan->gaji_pokok) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="tunjangan_jabatan" class="form-label">Tunjangan Jabatan<span class="text-danger">*</span></label>
                            <input type="text" name="tunjangan_jabatan" id="tunjangan_jabatan" class="form-control" value="{{ old('tunjangan_jabatan', $jabatan->tunjangan_jabatan) }}" required>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save fa-sm"></i> Update Jabatan
                        </button>
                        <button type="reset" class="btn btn-warning">
                            <i class="fas fa-undo fa-sm"></i> Reset
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection