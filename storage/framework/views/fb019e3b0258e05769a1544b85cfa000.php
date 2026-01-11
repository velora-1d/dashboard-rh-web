


<?php
    $context = $context ?? 'admin';
    $active = $active ?? 'dashboard';
    
    // Define menu items for each context
    $menus = [
        'admin' => [
            // Main items (shown in bottom nav)
            'main' => [
                ['route_name' => 'admin.dashboard', 'icon' => 'home', 'label' => 'Dashboard', 'key' => 'dashboard'],
                ['route_name' => 'sekretaris.dashboard', 'icon' => 'users', 'label' => 'Sekretaris', 'key' => 'sekretaris'],
                ['route_name' => 'bendahara.dashboard', 'icon' => 'dollar-sign', 'label' => 'Bendahara', 'key' => 'bendahara'],
            ],
            'more' => [
                ['route_name' => 'pendidikan.dashboard', 'icon' => 'book-open', 'label' => 'Pendidikan', 'key' => 'pendidikan'],
                ['route_name' => 'backup.download', 'icon' => 'database', 'label' => 'Backup Data', 'key' => 'backup'],
                ['route_name' => 'logout', 'icon' => 'log-out', 'label' => 'Logout', 'key' => 'logout', 'is_form' => true],
            ],
        ],
        'sekretaris' => [
            'main' => [
                ['route_name' => 'sekretaris.dashboard', 'icon' => 'home', 'label' => 'Dashboard', 'key' => 'dashboard'],
                ['route_name' => 'sekretaris.data-santri', 'icon' => 'users', 'label' => 'Santri', 'key' => 'santri'],
                ['route_name' => 'sekretaris.mutasi-santri', 'icon' => 'shuffle', 'label' => 'Mutasi', 'key' => 'mutasi'],
            ],
            'more' => [
                ['route_name' => 'sekretaris.kenaikan-kelas', 'icon' => 'trending-up', 'label' => 'Kenaikan Kelas', 'key' => 'kenaikan'],
                ['route_name' => 'sekretaris.perpindahan', 'icon' => 'move', 'label' => 'Perpindahan', 'key' => 'perpindahan'],
                ['route_name' => 'sekretaris.laporan', 'icon' => 'file-text', 'label' => 'Laporan', 'key' => 'laporan'],
            ],
        ],
        'bendahara' => [
            'main' => [
                ['route_name' => 'bendahara.dashboard', 'icon' => 'home', 'label' => 'Dashboard', 'key' => 'dashboard'],
                ['route_name' => 'bendahara.syahriah', 'icon' => 'credit-card', 'label' => 'Syahriah', 'key' => 'syahriah'],
                ['route_name' => 'bendahara.pemasukan', 'icon' => 'trending-up', 'label' => 'Pemasukan', 'key' => 'pemasukan'],
            ],
            'more' => [
                ['route_name' => 'bendahara.pengeluaran', 'icon' => 'trending-down', 'label' => 'Pengeluaran', 'key' => 'pengeluaran'],
                ['route_name' => 'bendahara.pegawai', 'icon' => 'users', 'label' => 'Pegawai', 'key' => 'pegawai'],
                ['route_name' => 'bendahara.gaji', 'icon' => 'dollar-sign', 'label' => 'Gaji', 'key' => 'gaji'],
                ['route_name' => 'bendahara.laporan', 'icon' => 'file-text', 'label' => 'Laporan', 'key' => 'laporan'],
            ],
        ],
        'pendidikan' => [
            'main' => [
                ['route_name' => 'pendidikan.dashboard', 'icon' => 'home', 'label' => 'Dashboard', 'key' => 'dashboard'],
                ['route_name' => 'pendidikan.nilai', 'icon' => 'edit-3', 'label' => 'Nilai', 'key' => 'nilai'],
                ['route_name' => 'pendidikan.laporan', 'icon' => 'file-text', 'label' => 'E-Rapor', 'key' => 'rapor'],
            ],
            'more' => [
                ['route_name' => 'pendidikan.ijazah', 'icon' => 'award', 'label' => 'Ijazah', 'key' => 'ijazah'],
                ['route_name' => 'pendidikan.absensi', 'icon' => 'check-circle', 'label' => 'Absensi', 'key' => 'absensi'],
                ['route_name' => 'pendidikan.mapel', 'icon' => 'book', 'label' => 'Mata Pelajaran', 'key' => 'mapel'],
                ['route_name' => 'pendidikan.jadwal', 'icon' => 'calendar', 'label' => 'Jadwal', 'key' => 'jadwal'],
            ],
        ],
    ];
    
    $mainItems = $menus[$context]['main'] ?? [];
    $moreItems = $menus[$context]['more'] ?? [];
?>

<?php $__env->startSection('bottom-nav'); ?>
    
    <?php $__currentLoopData = $mainItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="bottom-nav-item">
            <a href="<?php echo e(route($item['route_name'])); ?>" class="bottom-nav-link <?php echo e($active === $item['key'] ? 'active' : ''); ?>">
                <div class="bottom-nav-icon">
                    <i data-feather="<?php echo e($item['icon']); ?>" style="width: 20px; height: 20px;"></i>
                </div>
                <span class="bottom-nav-label"><?php echo e($item['label']); ?></span>
            </a>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    
    <li class="bottom-nav-item">
        <a href="javascript:void(0)" class="bottom-nav-link" id="bottom-nav-more-btn">
            <div class="bottom-nav-icon">
                <i data-feather="menu" style="width: 20px; height: 20px;"></i>
            </div>
            <span class="bottom-nav-label">More</span>
        </a>
    </li>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<style>
    .bottom-sheet {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: white;
        border-radius: 20px 20px 0 0;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.15);
        transform: translateY(100%);
        transition: transform 0.3s ease;
        z-index: 200;
        max-height: 60vh;
        overflow-y: auto;
    }
    
    .bottom-sheet.open {
        transform: translateY(0);
    }
    
    .bottom-sheet-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 199;
    }
    
    .bottom-sheet-overlay.open {
        opacity: 1;
        visibility: visible;
    }
    
    .bottom-sheet-header {
        padding: 20px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .bottom-sheet-title {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
    }
    
    .bottom-sheet-close {
        background: #f3f4f6;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    
    .bottom-sheet-menu {
        padding: 12px;
    }
    
    .bottom-sheet-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        border-radius: 12px;
        text-decoration: none;
        color: #374151;
        transition: background 0.2s;
    }
    
    .bottom-sheet-item:hover {
        background: #f3f4f6;
    }
    
    .bottom-sheet-icon {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .bottom-sheet-label {
        font-size: 15px;
        font-weight: 500;
    }
</style>


<div class="bottom-sheet-overlay" id="bottom-sheet-overlay"></div>
<div class="bottom-sheet" id="bottom-sheet">
    <div class="bottom-sheet-header">
        <h3 class="bottom-sheet-title">Menu Lainnya</h3>
        <button class="bottom-sheet-close" id="bottom-sheet-close">
            <i data-feather="x" style="width: 18px; height: 18px;"></i>
        </button>
    </div>
    <div class="bottom-sheet-menu">
        <?php $__currentLoopData = $moreItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($item['is_form']) && $item['is_form']): ?>
                <form method="POST" action="<?php echo e(route($item['route_name'])); ?>" style="margin: 0;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="bottom-sheet-item" style="width: 100%; border: none; background: none; cursor: pointer;">
                        <div class="bottom-sheet-icon" style="background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);">
                            <i data-feather="<?php echo e($item['icon']); ?>" style="width: 20px; height: 20px;"></i>
                        </div>
                        <span class="bottom-sheet-label"><?php echo e($item['label']); ?></span>
                    </button>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route($item['route_name'])); ?>" class="bottom-sheet-item">
                    <div class="bottom-sheet-icon">
                        <i data-feather="<?php echo e($item['icon']); ?>" style="width: 20px; height: 20px;"></i>
                    </div>
                    <span class="bottom-sheet-label"><?php echo e($item['label']); ?></span>
                </a>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<script>
    document.addEventListener('turbo:load', function() {
        const moreBtn = document.getElementById('bottom-nav-more-btn');
        const bottomSheet = document.getElementById('bottom-sheet');
        const overlay = document.getElementById('bottom-sheet-overlay');
        const closeBtn = document.getElementById('bottom-sheet-close');
        
        if (moreBtn && bottomSheet && overlay) {
            moreBtn.addEventListener('click', () => {
                bottomSheet.classList.add('open');
                overlay.classList.add('open');
                feather.replace();
            });
            
            closeBtn.addEventListener('click', () => {
                bottomSheet.classList.remove('open');
                overlay.classList.remove('open');
            });
            
            overlay.addEventListener('click', () => {
                bottomSheet.classList.remove('open');
                overlay.classList.remove('open');
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\components\bottom-nav.blade.php ENDPATH**/ ?>