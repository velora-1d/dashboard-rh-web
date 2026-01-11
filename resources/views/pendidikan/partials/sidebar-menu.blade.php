@if(auth()->check() && strtolower(auth()->user()->role ?? '') === 'admin')
<li class="sidebar-menu-item" style="margin-bottom: 12px;">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-link" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border-radius: 8px;">
        <i data-feather="arrow-left" class="sidebar-menu-icon" style="color: white;"></i>
        <span>Kembali ke Admin</span>
    </a>
</li>
@endif
<li class="sidebar-menu-item">
    <a href="{{ route('pendidikan.dashboard') }}" class="sidebar-menu-link {{ request()->routeIs('pendidikan.dashboard') ? 'active' : '' }}">
        <i data-feather="home" class="sidebar-menu-icon"></i>
        <span>Dashboard</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('pendidikan.absensi') }}" class="sidebar-menu-link {{ request()->routeIs('pendidikan.absensi*') ? 'active' : '' }}">
        <i data-feather="check-square" class="sidebar-menu-icon"></i>
        <span>Absensi Santri</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('talaran.index') }}" class="sidebar-menu-link {{ request()->routeIs('talaran*') ? 'active' : '' }}">
        <i data-feather="layers" class="sidebar-menu-icon"></i>
        <span>Sistem Talaran</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('pendidikan.mapel') }}" class="sidebar-menu-link {{ request()->routeIs('pendidikan.mapel*') ? 'active' : '' }}">
        <i data-feather="book-open" class="sidebar-menu-icon"></i>
        <span>Mata Pelajaran</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('pendidikan.jadwal') }}" class="sidebar-menu-link {{ request()->routeIs('pendidikan.jadwal*') ? 'active' : '' }}">
        <i data-feather="clock" class="sidebar-menu-icon"></i>
        <span>Jadwal Pelajaran</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('mata-pelajaran.index') }}" class="sidebar-menu-link {{ request()->routeIs('mata-pelajaran.*') ? 'active' : '' }}">
        <i data-feather="clipboard" class="sidebar-menu-icon"></i>
        <span>Data Mata Ujian</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('pendidikan.ujian-mingguan') }}" class="sidebar-menu-link {{ request()->routeIs('pendidikan.ujian-mingguan*') ? 'active' : '' }}">
        <i data-feather="calendar" class="sidebar-menu-icon"></i>
        <span>Ujian Mingguan</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('pendidikan.nilai') }}" class="sidebar-menu-link {{ request()->routeIs('pendidikan.nilai*') && !request()->routeIs('pendidikan.nilai-mingguan*') ? 'active' : '' }}">
        <i data-feather="award" class="sidebar-menu-icon"></i>
        <span>Rekapitulasi Nilai</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('pendidikan.laporan') }}" class="sidebar-menu-link {{ request()->routeIs('pendidikan.laporan*') ? 'active' : '' }}">
        <i data-feather="file-text" class="sidebar-menu-icon"></i>
        <span>E-Rapor Digital</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('pendidikan.ijazah') }}" class="sidebar-menu-link {{ request()->routeIs('pendidikan.ijazah*') ? 'active' : '' }}">
        <i data-feather="star" class="sidebar-menu-icon"></i>
        <span>Ijazah Digital</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('pendidikan.kalender') }}" class="sidebar-menu-link {{ request()->routeIs('pendidikan.kalender*') ? 'active' : '' }}">
        <i data-feather="calendar" class="sidebar-menu-icon"></i>
    <span>Kalender Akademik</span>
    </a>
</li>

{{-- Logout Button --}}

