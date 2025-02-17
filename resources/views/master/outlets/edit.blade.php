@extends('layouts.app')

@section('title', 'Edit Outlet')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Outlet</h1>
        <a href="{{ route('outlet.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Kembali
        </a>
    </div>

    <!-- Edit Form -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('outlet.update', $outlet->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_outlet" class="form-label">Nama Outlet <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control @error('nama_outlet') is-invalid @enderror"
                                id="nama_outlet"
                                name="nama_outlet"
                                value="{{ old('nama_outlet', $outlet->nama_outlet) }}"
                                required>
                            @error('nama_outlet')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Outlet <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror"
                                id="alamat"
                                name="alamat"
                                rows="3"
                                required>{{ old('alamat', $outlet->alamat) }}</textarea>
                            @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save fa-sm"></i> Update Outlet
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