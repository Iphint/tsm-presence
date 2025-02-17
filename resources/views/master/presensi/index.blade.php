@extends('layouts.app')

@section('title', 'Data Presensi')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between my-2">
        <h1 class="h3 mb-2 text-gray-800">Data Presensi</h1>
        <div>
            <form action="{{ route('presence.index') }}" method="GET" class="form-inline">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari..." value="{{ request('search') }}">
                <input type="date" name="date" class="form-control form-control-sm ml-2" value="{{ request('date') }}">
                <button type="submit" class="btn btn-outline-secondary btn-sm ml-2">Cari</button>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered text-nowrap">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th style="width: 15%;">Nama</th>
                    <th style="width: 10%;">Posisi</th>
                    <th style="width: 10%;">Outlet Cabang</th>
                    <th style="width: 10%;">Masuk</th>
                    <th style="width: 10%;">Pulang</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 10%;">Lokasi</th>
                    <th style="width: 10%;">Keterangan</th>
                    <th style="width: 10%;">Status Verifikasi</th>
                    <th style="width: 10%;">Verified</th>
                    <th style="width: 10%;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($presences as $presence)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $presence->user->name }}</td>
                    <td>{{ $presence->user->posisi }}</td>
                    <td>{{ $presence->user->outlet_cabang }}</td>
                    <td>{{ $presence->datang ? \Carbon\Carbon::parse($presence->datang)->format('d-m-Y H:i:s') : 'Belum ada data' }}</td>
                    <td>{{ $presence->pulang ? \Carbon\Carbon::parse($presence->pulang)->format('d-m-Y H:i:s') : 'Belum ada data' }}</td>
                    <td>
                        @if (in_array($presence->status, ['off', 'izin', 'sakit', 'cuti']))
                        <span class="badge badge-warning">{{ ucfirst($presence->status) }}</span>
                        @elseif ($presence->status == 'masuk')
                        <span class="badge badge-success">{{ ucfirst($presence->status) }}</span>
                        @else
                        <span class="badge badge-danger">{{ ucfirst($presence->status) }}</span>
                        @endif
                    </td>
                    <td class="text-center">
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
                    <td>{{ $presence->keterangan ?? '-' }}</td>
                    <td>
                        @if ($presence->verified)
                        <span class="badge badge-success">Verified</span>
                        @else
                        <span class="badge badge-secondary">Not verified</span>
                        @endif
                    </td>
                    <td>
                        @if (in_array($presence->status, ['off', 'izin', 'sakit', 'cuti']) && !$presence->verified)
                        <button type="button" class="btn btn-sm btn-success mt-1" onclick="verifyPresence('{{ $presence->id }}')">
                            Verifikasi
                        </button>
                        @elseif ($presence->status == 'masuk')
                        <span class="badge badge-success">{{ ucfirst($presence->status) }}</span>
                        @else
                        <span class="badge badge-danger">{{ ucfirst($presence->status) }}</span>
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal{{ $presence->id }}">Edit</button>
                        <div class="modal fade" id="editModal{{ $presence->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $presence->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{ $presence->id }}">Edit Presensi</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('presence.update', $presence->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select class="form-control" name="status" id="status">
                                                    <option value="absent" {{ $presence->status == 'absent' ? 'selected' : '' }}>Absent</option>
                                                    <option value="masuk" {{ $presence->status == 'masuk' ? 'selected' : '' }}>Masuk</option>
                                                    <option value="izin" {{ $presence->status == 'izin' ? 'selected' : '' }}>Izin</option>
                                                    <option value="sakit" {{ $presence->status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                                    <option value="cuti" {{ $presence->status == 'cuti' ? 'selected' : '' }}>Cuti</option>
                                                    <option value="off" {{ $presence->status == 'off' ? 'selected' : '' }}>Off</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="datang">Jam Masuk</label>
                                                <input type="datetime-local" class="form-control" name="datang" id="datang" value="{{ $presence->datang ? \Carbon\Carbon::parse($presence->datang)->format('Y-m-d\TH:i') : '' }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="pulang">Jam Pulang</label>
                                                <input type="datetime-local" class="form-control" name="pulang" id="pulang" value="{{ $presence->pulang ? \Carbon\Carbon::parse($presence->pulang)->format('Y-m-d\TH:i') : '' }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="keterangan">Keterangan</label>
                                                <textarea class="form-control" name="keterangan" id="keterangan" rows="3">{{ $presence->keterangan }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <ul class="pagination">
                @if ($presences->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">Prev</span>
                </li>
                @else
                <li class="page-item">
                    <a class="page-link" href="{{ $presences->previousPageUrl() }}">Prev</a>
                </li>
                @endif

                @foreach ($presences->getUrlRange(1, $presences->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $presences->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
                @endforeach

                @if ($presences->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $presences->nextPageUrl() }}">Next</a>
                </li>
                @else
                <li class="page-item disabled">
                    <span class="page-link">Next</span>
                </li>
                @endif
            </ul>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function verifyPresence(presenceId) {
        if (confirm('Apakah Anda yakin ingin memverifikasi kehadiran ini?')) {
            fetch("{{ route('presence.verify') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        presence_id: presenceId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Presensi berhasil diverifikasi!");
                        location.reload();
                    } else {
                        alert("Terjadi kesalahan: " + data.error);
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }
</script>

@endpush