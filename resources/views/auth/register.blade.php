<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Selamat datang, Silahkan Register</h1>
                                    </div>

                                    <!-- Tampilkan pesan error validasi -->
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nama</label>
                                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="posisi" class="form-label">Posisi</label>
                                            <select name="posisi" id="posisi" class="form-control" required>
                                                <option value="">-- Pilih Posisi Jabatan --</option>
                                                @foreach ($jabatans as $jabatan)
                                                <option value="{{ $jabatan->nama_jabatan }}" {{ old('posisi') == $jabatan->nama_jabatan ? 'selected' : '' }}>
                                                    {{ $jabatan->nama_jabatan }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="outlet_cabang" class="form-label">Outlet Cabang</label>
                                            <select name="outlet_cabang" id="outlet_cabang" class="form-control" required>
                                                <option value="">-- Pilih Outlet Cabang --</option>
                                                @foreach ($outlets as $outlet)
                                                <option value="{{ $outlet->nama_outlet }}" {{ old('outlet_cabang') == $outlet->nama_outlet ? 'selected' : '' }}>
                                                    {{ $outlet->nama_outlet }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="duration" class="form-label">Duration</label>
                                            <input type="date" name="duration" id="duration" class="form-control" value="{{ old('duration') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="password" id="password" class="form-control" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="nik" class="form-label">NIK</label>
                                            <input type="text" name="nik" id="nik" class="form-control" value="{{ old('nik') }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="npwp" class="form-label">NPWP</label>
                                            <input type="text" name="npwp" id="npwp" class="form-control" value="{{ old('npwp') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="role" class="form-label">Role</label>
                                            <select name="role" id="role" class="form-control" required>
                                                <option value="">-- Pilih Role --</option>
                                                <option value="admin">Admin Outlet</option>
                                                <option value="pegawai">Pegawai</option>
                                                <option value="magang">Magang</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="photo" class="form-label">Photo</label>
                                            <input type="file" name="photo" id="photo" class="form-control">
                                        </div>

                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="login">Sudah punya akun? Login di sini</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>
</body>

</html>