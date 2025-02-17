@extends('layouts.app')

@section('title', 'Presence')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Presence</h1>
        @if(auth()->user()->role == 'admin')
        <a href="{{ route('presence-admin.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Kembali
        </a>
        @else
        <a href="{{ route('presence-pegawai.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Kembali
        </a>
        @endif

    </div>

    <!-- Card untuk Tampilannya -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">Waktu Kedatangan</h5>
                    <p id="arrivalTime" class="card-text">
                        @if($presence && $presence->datang)
                        {{ \Carbon\Carbon::parse($presence->datang)->format('d-m-Y H:i:s') }}
                        @else
                        Belum ada data
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title">Waktu Pulang</h5>
                    <p id="departureTime" class="card-text">
                        @if($presence && $presence->pulang)
                        {{ \Carbon\Carbon::parse($presence->pulang)->format('d-m-Y H:i:s') }}
                        @else
                        Belum ada data
                        @endif
                    </p>
                </div>

            </div>
            <button id="markArrival" class="btn btn-primary mt-4" {{ $presence && $presence->datang ? 'disabled' : '' }}>
                Mark Arrival
            </button>
            <button id="markDeparture" class="btn btn-success mt-4"
                {{ $presence && $presence->pulang ? 'disabled' : '' }}
                {{ !$presence || !$presence->datang ? 'disabled' : '' }}>
                Mark Departure
            </button>
        </div>
    </div>

    <!-- Timer Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="card-title">Real-Time Timer</h5>
            <p id="currentTime" class="display-4 text-center">--:--:--</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateTime() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('currentTime').textContent = `${hours}:${minutes}:${seconds}`;
    }

    setInterval(updateTime, 1000);
    updateTime();

    document.getElementById('markArrival').addEventListener('click', function() {
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const timestamp = new Date();

                const formattedTimestamp = timestamp.getFullYear() + '-' +
                    String(timestamp.getMonth() + 1).padStart(2, '0') + '-' +
                    String(timestamp.getDate()).padStart(2, '0') + ' ' +
                    String(timestamp.getHours()).padStart(2, '0') + ':' +
                    String(timestamp.getMinutes()).padStart(2, '0') + ':' +
                    String(timestamp.getSeconds()).padStart(2, '0');

                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                fetch("{{ route('presence.mark-arrival') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            datang: formattedTimestamp,
                            latitude: latitude,
                            longitude: longitude
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert("Something went wrong. Please try again.");
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert("An error occurred. Please try again.");
                    });
            }, function(error) {
                alert("Unable to retrieve your location. Please enable location services.");
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    });


    // Mark Departure
    document.getElementById('markDeparture').addEventListener('click', function() {
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const timestamp = new Date();

                const formattedTimestamp = timestamp.getFullYear() + '-' +
                    String(timestamp.getMonth() + 1).padStart(2, '0') + '-' +
                    String(timestamp.getDate()).padStart(2, '0') + ' ' +
                    String(timestamp.getHours()).padStart(2, '0') + ':' +
                    String(timestamp.getMinutes()).padStart(2, '0') + ':' +
                    String(timestamp.getSeconds()).padStart(2, '0');
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                fetch("{{ route('presence.mark-departure') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            pulang: formattedTimestamp,
                            latitude: latitude,
                            longitude: longitude
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert("Something went wrong. Please try again.");
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert("An error occurred. Please try again.");
                    });
            }, function(error) {
                alert("Unable to retrieve your location. Please enable location services.");
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    });
</script>
@endpush