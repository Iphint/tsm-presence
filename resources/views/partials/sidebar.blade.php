<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-text mx-3">Tsamaniya</div>
    </a>

    <hr class="sidebar-divider my-0">

    @if(Auth::user()->role == 'master_admin')
    <li class="nav-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard.index') }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('outlet.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('outlet.index') }}">
            <i class="fas fa-cogs"></i>
            <span>Outlets</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('user.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('user.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('jabatan.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('jabatan.index') }}">
            <i class="fas fa-fw fa-briefcase"></i>
            <span>Jabatan</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('presence.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('presence.index') }}">
            <i class="fas fa-fw fa-clock"></i>
            <span>Presensi</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('salary.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('salary.index') }}">
            <i class="fas fa-fw fa-wallet"></i>
            <span>Salary Karyawan</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('pajak.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pajak.index') }}">
            <i class="fas fa-fw fa-file-invoice"></i>
            <span>Cetak Faktur Pajak</span>
        </a>
    </li>
    @endif

    @if(Auth::user()->role == 'magang')
    <li class="nav-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard.index') }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('presence.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('presence.index') }}">
            <i class="fas fa-fw fa-clock"></i>
            <span>Presensi</span>
        </a>
    </li>
    @endif

    @if(Auth::user()->role == 'pegawai')
    <li class="nav-item {{ request()->routeIs('dashboard-pegawai.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard-pegawai.index') }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('presence-pegawai.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('presence-pegawai.index') }}">
            <i class="fas fa-fw fa-clock"></i>
            <span>Presensi</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('gaji-pegawai.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('gaji-pegawai.index') }}">
            <i class="fas fa-fw fa-wallet"></i>
            <span>Sallary</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('lembur-pegawai.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('lembur-pegawai.index') }}">
            <i class="fas fa-fw fa-money-bill-wave"></i>
            <span>Lemburan</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('pengajuan-pegawai.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pengajuan-pegawai.index') }}">
            <i class="fas fa-fw fa-calendar-alt"></i> <span>Pengajuan</span>
        </a>
    </li>
    @endif

    @if(Auth::user()->role == 'admin')
    <li class="nav-item {{ request()->routeIs('dashboard-admin.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard-admin.index') }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('presence-admin.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('presence-admin.index') }}">
            <i class="fas fa-fw fa-clock"></i>
            <span>Presensi</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('user-admin.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('user-admin.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Karyawan</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('gaji-admin.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('gaji-admin.index') }}">
            <i class="fas fa-fw fa-wallet"></i>
            <span>Sallary</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('lembur-admin.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('lembur-admin.index') }}">
            <i class="fas fa-fw fa-wallet"></i>
            <span>Lemburan Karyawan</span>
        </a>
    </li>
    @endif

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>