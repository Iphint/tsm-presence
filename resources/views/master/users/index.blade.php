@extends('layouts.app')

@section('title', 'Data Users')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between my-2">
        <h1 class="h3 mb-2 text-gray-800">Data Users</h1>
        <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah User
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 5%; text-align: center;">No</th>
                            <th>Nama</th>
                            <th>Posisi</th>
                            <th>Roles</th>
                            <th>Outlet Cabang</th>
                            <th>Duration (Bulan)</th>
                            <th>BPJS</th>
                            <th>Ketenagakerjaan</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->posisi }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->outlet_cabang }}</td>
                            <td>
                                @if ($user->duration)
                                @php
                                $startDate = \Carbon\Carbon::parse($user->duration);
                                $currentDate = \Carbon\Carbon::now();
                                $totalMonths = intval($startDate->diffInMonths($currentDate));
                                @endphp
                                {{ $totalMonths }} bulan
                                @else
                                Tidak diketahui
                                @endif
                            </td>
                            <td>
                                @if ($user->bpjs == null)
                                <p style="text-align: center;">-</p>
                                @else
                                Rp. {{ number_format($user->bpjs, 0, ',', '.') }}
                                @endif
                            </td>
                            <td>
                                @if ($user->ketenagakerjaan == null)
                                <p style="text-align: center;">-</p>
                                @else
                                Rp. {{ number_format($user->ketenagakerjaan, 0, ',', '.') }}
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <a href="{{ route('user.show', $user->id) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm mx-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
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