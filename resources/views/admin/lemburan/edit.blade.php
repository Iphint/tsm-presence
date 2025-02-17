@extends('layouts.app')

@section('title', 'Lemburan')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between my-2">
        <div class="">
            <h1 class="h3 mb-2 text-gray-800">Approval lemburan karyawan</h1>
            <p>Page untuk mengeksekusi data pengajuan lembur karyawan.</p>
        </div>
        <a href="{{ route('lembur-admin.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left fa-sm"></i> kembali
        </a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('lembur-admin.update', $lembur->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="tanggal">Pengajuan untuk tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $lembur->tanggal) }}" readonly>
                    @error('tanggal')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="start_lembur">Mulai</label>
                    <input type="time" name="start_lembur" id="start_lembur" class="form-control @error('start_lembur') is-invalid @enderror" value="{{ old('start_lembur', $lembur->start_lembur) }}" readonly>
                    @error('start_lembur')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="selesai_lembur">Selesai</label>
                    <input type="time" name="selesai_lembur" id="selesai_lembur" class="form-control @error('selesai_lembur') is-invalid @enderror" value="{{ old('selesai_lembur', $lembur->selesai_lembur) }}" readonly>
                    @error('selesai_lembur')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="action">Status</label>
                    <select name="action" id="action" class="form-control @error('action') is-invalid @enderror">
                        <option value="pending" {{ old('action', $lembur->action) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ old('action', $lembur->action) == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ old('action', $lembur->action) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    @error('action')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection