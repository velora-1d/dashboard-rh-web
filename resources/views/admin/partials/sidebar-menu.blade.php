<li class="sidebar-menu-item">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i data-feather="home" class="sidebar-menu-icon"></i>
        <span>Dashboard</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('admin.activity-log') }}" class="sidebar-menu-link {{ request()->routeIs('admin.activity-log') ? 'active' : '' }}">
        <i data-feather="activity" class="sidebar-menu-icon"></i>
        <span>Riwayat Aktivitas</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('admin.withdrawals') }}" class="sidebar-menu-link {{ request()->routeIs('admin.withdrawals*') ? 'active' : '' }}">
        <i data-feather="external-link" class="sidebar-menu-icon"></i>
        <span>Tracking Penarikan</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('admin.pengaturan') }}" class="sidebar-menu-link {{ request()->routeIs('admin.pengaturan*') ? 'active' : '' }}">
        <i data-feather="settings" class="sidebar-menu-icon"></i>
        <span>Pengaturan</span>
    </a>
</li>

<li class="sidebar-menu-item" style="margin-top: 16px; padding: 12px 20px 6px 20px; border-top: 1px solid rgba(255,255,255,0.06);">
    <span style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #64748b; font-weight: 700;">Akses Modul</span>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('sekretaris.dashboard') }}" class="sidebar-menu-link">
        <i data-feather="users" class="sidebar-menu-icon"></i>
        <span>Sekretaris</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('bendahara.dashboard') }}" class="sidebar-menu-link">
        <i data-feather="dollar-sign" class="sidebar-menu-icon"></i>
        <span>Bendahara</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="{{ route('pendidikan.dashboard') }}" class="sidebar-menu-link">
        <i data-feather="book-open" class="sidebar-menu-icon"></i>
        <span>Pendidikan</span>
    </a>
</li>


