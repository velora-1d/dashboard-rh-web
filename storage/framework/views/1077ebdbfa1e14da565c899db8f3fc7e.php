<?php if(auth()->check() && strtolower(auth()->user()->role ?? '') === 'admin'): ?>
<li class="sidebar-menu-item" style="margin-bottom: 12px;">
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-menu-link" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border-radius: 8px;">
        <i data-feather="arrow-left" class="sidebar-menu-icon" style="color: white;"></i>
        <span>Kembali ke Admin</span>
    </a>
</li>
<?php endif; ?>
<li class="sidebar-menu-item">
    <a href="<?php echo e(route('pendidikan.dashboard')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('pendidikan.dashboard') ? 'active' : ''); ?>">
        <i data-feather="home" class="sidebar-menu-icon"></i>
        <span>Dashboard</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="<?php echo e(route('pendidikan.absensi')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('pendidikan.absensi*') ? 'active' : ''); ?>">
        <i data-feather="check-square" class="sidebar-menu-icon"></i>
        <span>Absensi Santri</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="<?php echo e(route('talaran.index')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('talaran*') ? 'active' : ''); ?>">
        <i data-feather="layers" class="sidebar-menu-icon"></i>
        <span>Sistem Talaran</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="<?php echo e(route('pendidikan.mapel')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('pendidikan.mapel*') ? 'active' : ''); ?>">
        <i data-feather="book-open" class="sidebar-menu-icon"></i>
        <span>Mata Pelajaran</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="<?php echo e(route('pendidikan.jadwal')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('pendidikan.jadwal*') ? 'active' : ''); ?>">
        <i data-feather="clock" class="sidebar-menu-icon"></i>
        <span>Jadwal Pelajaran</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="<?php echo e(route('mata-pelajaran.index')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('mata-pelajaran.*') ? 'active' : ''); ?>">
        <i data-feather="clipboard" class="sidebar-menu-icon"></i>
        <span>Data Mata Ujian</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="<?php echo e(route('pendidikan.ujian-mingguan')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('pendidikan.ujian-mingguan*') ? 'active' : ''); ?>">
        <i data-feather="calendar" class="sidebar-menu-icon"></i>
        <span>Ujian Mingguan</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="<?php echo e(route('pendidikan.nilai')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('pendidikan.nilai*') && !request()->routeIs('pendidikan.nilai-mingguan*') ? 'active' : ''); ?>">
        <i data-feather="award" class="sidebar-menu-icon"></i>
        <span>Rekapitulasi Nilai</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="<?php echo e(route('pendidikan.laporan')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('pendidikan.laporan*') ? 'active' : ''); ?>">
        <i data-feather="file-text" class="sidebar-menu-icon"></i>
        <span>E-Rapor Digital</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="<?php echo e(route('pendidikan.ijazah')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('pendidikan.ijazah*') ? 'active' : ''); ?>">
        <i data-feather="star" class="sidebar-menu-icon"></i>
        <span>Ijazah Digital</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="<?php echo e(route('pendidikan.kalender')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('pendidikan.kalender*') ? 'active' : ''); ?>">
        <i data-feather="calendar" class="sidebar-menu-icon"></i>
    <span>Kalender Akademik</span>
    </a>
</li>


<li class="sidebar-menu-item" style="margin-top: auto; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 12px;">
    <div style="padding: 12px 16px; margin-bottom: 8px;">
        <div style="font-size: 11px; color: rgba(255,255,255,0.6); margin-bottom: 4px;">Logged in as</div>
        <div style="font-size: 13px; color: white; font-weight: 600;"><?php echo e(auth()->user()->name); ?></div>
        <div style="font-size: 11px; color: rgba(255,255,255,0.7);"><?php echo e(auth()->user()->email); ?></div>
    </div>
    <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin: 0;">
        <?php echo csrf_field(); ?>
        <button type="submit" class="sidebar-menu-link" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; color: #ff6b6b;">
            <i data-feather="log-out" class="sidebar-menu-icon"></i>
            <span>Logout</span>
        </button>
    </form>
</li>
<?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\pendidikan\partials\sidebar-menu.blade.php ENDPATH**/ ?>