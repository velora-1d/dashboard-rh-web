
<?php if(auth()->check() && strtolower(auth()->user()->role ?? '') === 'admin'): ?>
<li class="sidebar-menu-item" style="margin-bottom: 12px;">
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-menu-link" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border-radius: 8px;">
        <i data-feather="arrow-left" class="sidebar-menu-icon" style="color: white;"></i>
        <span>Kembali ke Admin</span>
    </a>
</li>
<?php endif; ?>
<li class="sidebar-menu-item">
    <a href="<?php echo e(route('bendahara.dashboard')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('bendahara.dashboard') ? 'active' : ''); ?>">
        <i data-feather="home" class="sidebar-menu-icon"></i>
        <span>Dashboard</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="<?php echo e(route('bendahara.syahriah')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('bendahara.syahriah*') ? 'active' : ''); ?>">
        <i data-feather="dollar-sign" class="sidebar-menu-icon"></i>
        <span>Syahriah</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="<?php echo e(route('bendahara.cek-tunggakan')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('bendahara.cek-tunggakan*') ? 'active' : ''); ?>">
        <i data-feather="search" class="sidebar-menu-icon"></i>
        <span>Cek Tunggakan</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="<?php echo e(route('bendahara.pemasukan')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('bendahara.pemasukan*') ? 'active' : ''); ?>">
        <i data-feather="trending-up" class="sidebar-menu-icon"></i>
        <span>Pemasukan</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="<?php echo e(route('bendahara.pengeluaran')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('bendahara.pengeluaran*') ? 'active' : ''); ?>">
        <i data-feather="trending-down" class="sidebar-menu-icon"></i>
        <span>Pengeluaran</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="<?php echo e(route('bendahara.pegawai')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('bendahara.pegawai*') ? 'active' : ''); ?>">
        <i data-feather="briefcase" class="sidebar-menu-icon"></i>
        <span>Pegawai</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="<?php echo e(route('bendahara.gaji')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('bendahara.gaji*') ? 'active' : ''); ?>">
        <i data-feather="credit-card" class="sidebar-menu-icon"></i>
        <span>Gaji</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <a href="<?php echo e(route('bendahara.laporan')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('bendahara.laporan') ? 'active' : ''); ?>">
        <i data-feather="file-text" class="sidebar-menu-icon"></i>
        <span>Laporan</span>
    </a>
</li>
<li class="sidebar-menu-item">
    <form method="POST" action="<?php echo e(route('logout')); ?>">
        <?php echo csrf_field(); ?>
        <button type="submit" class="sidebar-menu-link" style="width: 100%; background: none; border: none; cursor: pointer; text-align: left;">
            <i data-feather="log-out" class="sidebar-menu-icon"></i>
            <span>Logout</span>
        </button>
    </form>
</li>
<?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\bendahara\partials\sidebar-menu.blade.php ENDPATH**/ ?>