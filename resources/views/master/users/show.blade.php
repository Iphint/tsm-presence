@extends('layouts.app')

@section('title', 'Show data user')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Detail Karyawan</h4>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            @if($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}"
                                alt="Foto Profil"
                                class="img-thumbnail mb-3"
                                style="max-width: 200px">
                            @else
                            <div class="text-muted">Tidak ada foto</div>
                            @endif
                        </div>

                        <div class="col-md-8">
                            <h3 class="mb-3">{{ $user->name }}</h3>

                            <div class="row">
                                <div class="col-md-6">
                                    <dl>
                                        <dt>Posisi:</dt>
                                        <dd>{{ $user->posisi ?? '-' }}</dd>

                                        <dt>Outlet/Cabang:</dt>
                                        <dd>{{ $user->outlet_cabang ?? '-' }}</dd>

                                        <dt>Durasi Kerja:</dt>
                                        <dd>@if ($user->duration)
                                            @php
                                            $startDate = \Carbon\Carbon::parse($user->duration);
                                            $currentDate = \Carbon\Carbon::now();
                                            $totalMonths = intval($startDate->diffInMonths($currentDate));
                                            @endphp
                                            {{ $totalMonths }} bulan
                                            @else
                                            Tidak diketahui
                                            @endif
                                        </dd>
                                    </dl>
                                </div>

                                <div class="col-md-6">
                                    <dl>
                                        <dt>Email:</dt>
                                        <dd>{{ $user->email }}</dd>

                                        <dt>NIK:</dt>
                                        <dd>{{ $user->nik ?? '-' }}</dd>

                                        <dt>NPWP:</dt>
                                        <dd>{{ $user->npwp ?? '-' }}</dd>

                                        <dt>BPJS:</dt>
                                        <dd>
                                            @if ($user->bpjs)
                                            Rp. {{ number_format($user->bpjs, 0, ',', '.') }}
                                            @else
                                            -
                                            @endif
                                        </dd>
                                    </dl>
                                </div>
                            </div>

                            <div class="mt-3">
                                <dt>Role:</dt>
                                <dd>
                                    <span class="badge bg-success">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </dd>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning mt-4">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Catatan Keamanan:</strong> Password tidak ditampilkan karena dienkripsi
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ route('user.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection