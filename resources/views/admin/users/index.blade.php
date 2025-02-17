@extends('layouts.app')

@section('title', 'Data Users')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between my-2">
        <h1 class="h3 mb-2 text-gray-800">Data Karyawan</h1>
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
                            <th>Photo</th>
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
                                @if ($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="User Photo" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                <img src="{{ asset('template/img/undraw_profile.svg') }}" alt="Default Photo" style="width: 50px; height: 50px; object-fit: cover;">
                                @endif
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