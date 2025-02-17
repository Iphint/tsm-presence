@extends('layouts.app')

@section('title', 'Data Jabatan')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between my-2">
        <h1 class="h3 mb-2 text-gray-800">List Jabatan</h1>
        <a href="{{ route('jabatan.create') }}" class="btn btn-outline-secondary">Add Jabatan</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 5%; text-align: center;">No</th>
                            <th style="text-align: center;">Posisi Jabatan</th>
                            <th style="text-align: center; width: 30%">Gaji Pokok</th>
                            <th style="text-align: center; width: 30%">Tunjangan Jabatan</th>
                            <th style="text-align: center; width: 15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $jabatans as $jabatan )
                        <tr>
                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                            <td>{{ $jabatan->nama_jabatan }}</td>
                            <td>Rp. {{ number_format($jabatan->gaji_pokok, 0, ',', '.') }}</td>
                            <td>Rp. {{ number_format($jabatan->tunjangan_jabatan, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <a href="{{ route('jabatan.edit', $jabatan->id) }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('jabatan.destroy', $jabatan->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus outlet ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection