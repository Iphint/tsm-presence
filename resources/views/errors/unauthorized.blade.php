@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white">Akses Ditolak</div>
                <div class="card-body">
                    <div class="alert alert-danger">
                        <p>Anda tidak memiliki izin untuk mengakses halaman ini.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection