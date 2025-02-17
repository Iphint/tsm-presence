@extends('layouts.app')

@section('title', 'Data Presensi')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between my-2">
        <h1 class="h3 mb-2 text-gray-800">Data Presensi</h1>
        <a href="{{ route('presence.create') }}" class="btn btn-outline-secondary">Presensi</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 5%; text-align: center">No</th>
                            <th>Nama</th>
                            <th>Posisi</th>
                            <th>Outlet Cabang</th>
                            <th>Masuk</th>
                            <th>Pulang</th>
                            <th style="text-align: center;">Lokasi</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $presences as $presence )
                        <tr>
                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                            <td>{{ $presence->user->name }}</td>
                            <td>{{ $presence->user->posisi }}</td>
                            <td>{{ $presence->user->outlet_cabang }}</td>
                            <td>{{ $presence->datang ? \Carbon\Carbon::parse($presence->datang)->format('d-m-Y H:i:s') : 'Belum ada data' }}</td>
                            <td>{{ $presence->pulang ? \Carbon\Carbon::parse($presence->pulang)->format('d-m-Y H:i:s') : 'Belum ada data' }}</td>
                            <td style="text-align: center;">
                                @if($presence->location)
                                @php
                                preg_match('/Latitude: ([-+]?[0-9]*\.?[0-9]+), Longitude: ([-+]?[0-9]*\.?[0-9]+)/', $presence->location, $matches);
                                $latitude = $matches[1] ?? null;
                                $longitude = $matches[2] ?? null;
                                @endphp
                                @if($latitude && $longitude)
                                <a href="https://www.google.com/maps?q={{ $latitude }},{{ $longitude }}" target="_blank" class="btn btn-info btn-sm">
                                    Open in Map
                                </a>
                                @endif
                                @else
                                Tidak tersedia
                                @endif
                            </td>
                            <td>
                                @if ($presence->status == 'off' or $presence->status == 'izin' or $presence->status == 'sakit' )
                                <span class="badge badge-warning">{{ $presence->status }}</span>
                                @elseif ($presence->status == 'masuk')
                                <span class="badge badge-success">{{ $presence->status }}</span>
                                @else
                                <span class="badge badge-danger">{{ $presence->status }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($presence->keterangan != null)
                                {{ $presence->keterangan }}
                                @else
                                <span style="text-align: center;">-</span>
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