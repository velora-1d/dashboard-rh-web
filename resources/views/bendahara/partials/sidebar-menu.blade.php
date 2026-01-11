{{-- Bendahara Sidebar Menu --}}
@if(auth()->check() && strtolower(auth()->user()->role ?? '') === 'admin')
<li class="sidebar-menu-item" style="margin-bottom: 12px;">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-link" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border-radius: 8px;">
        <i data-feather="arrow-left" class="sidebar-menu-icon" style="color: white;"></i>
        <span>Kembali ke Admin</span>
    </a>
</li>
@endif
<li class="sidebar-menu-item">
    <a href="{{ route('bendahara.dashboard') }}" class="sidebar-menu-link {{ request()->routeIs('bendahara.dashboard') ? 'active' : '' }}">
        <i data-feather="home" class="sidebar-menu-icon"></i>
        <span>Dashboard</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('bendahara.syahriah') }}" class="sidebar-menu-link {{ request()->routeIs('bendahara.syahriah*') ? 'active' : '' }}">
        <i data-feather="dollar-sign" class="sidebar-menu-icon"></i>
        <span>Syahriah</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('bendahara.cek-tunggakan') }}" class="sidebar-menu-link {{ request()->routeIs('bendahara.cek-tunggakan*') ? 'active' : '' }}">
        <i data-feather="search" class="sidebar-menu-icon"></i>
        <span>Cek Tunggakan</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('bendahara.pemasukan') }}" class="sidebar-menu-link {{ request()->routeIs('bendahara.pemasukan*') ? 'active' : '' }}">
        <i data-feather="trending-up" class="sidebar-menu-icon"></i>
        <span>Pemasukan</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('bendahara.pengeluaran') }}" class="sidebar-menu-link {{ request()->routeIs('bendahara.pengeluaran*') ? 'active' : '' }}">
        <i data-feather="trending-down" class="sidebar-menu-icon"></i>
        <span>Pengeluaran</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('bendahara.pegawai') }}" class="sidebar-menu-link {{ request()->routeIs('bendahara.pegawai*') ? 'active' : '' }}">
        <i data-feather="briefcase" class="sidebar-menu-icon"></i>
        <span>Pegawai</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('bendahara.gaji') }}" class="sidebar-menu-link {{ request()->routeIs('bendahara.gaji*') ? 'active' : '' }}">
        <i data-feather="credit-card" class="sidebar-menu-icon"></i>
        <span>Gaji</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('bendahara.laporan') }}" class="sidebar-menu-link {{ request()->routeIs('bendahara.laporan') ? 'active' : '' }}">
        <i data-feather="file-text" class="sidebar-menu-icon"></i>
        <span>Laporan</span>
    </a>
</li>

