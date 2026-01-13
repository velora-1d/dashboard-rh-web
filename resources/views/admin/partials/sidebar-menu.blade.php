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

<li class="sidebar-menu-item" style="margin-top: 16px; padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.1);">
    <span style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #64748b; padding: 0 16px;">Akses Modul</span>
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

@if(auth()->user()->role !== 'rois')
<li class="sidebar-menu-item" style="margin-top: 16px;">
    <a href="{{ route('backup.download') }}" class="sidebar-menu-link" style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3);">
        <i data-feather="download" class="sidebar-menu-icon" style="color: #22c55e;"></i>
        <span style="color: #22c55e;">Backup Database</span>
    </a>
</li>
@endif


