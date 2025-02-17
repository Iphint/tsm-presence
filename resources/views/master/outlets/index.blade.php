@extends('layouts.app')

@section('title', 'Data Outlets')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between my-2">
        <h1 class="h3 mb-2 text-gray-800">Data Outlet Cabang</h1>
        <a href="{{ route('outlet.create') }}" class="btn btn-outline-secondary">Add Outlet</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 5%">No</th>
                            <th style="width: 25%;">Nama Outlet</th>
                            <th style="text-align: center;">Alamat Outlet Cabang</th>
                            <th style="text-align: center; width: 15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($outlets as $index => $outlet)
                        <tr>
                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                            <td>{{ $outlet->nama_outlet }}</td>
                            <td>{{ $outlet->alamat }}</td>
                            <td class="text-center">
                                <a href="{{ route('outlet.edit', $outlet->id) }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('outlet.destroy', $outlet->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus outlet ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data outlet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection