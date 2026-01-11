

<?php $__env->startSection('title', 'Data Santri'); ?>
<?php $__env->startSection('page-title', 'Data Santri'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('bendahara.partials.sidebar-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <h2 style="font-size: var(--font-size-xl); font-weight: var(--font-weight-semibold); color: var(--color-gray-900); margin-bottom: var(--spacing-xl);">
        Data Santri (Read-Only)
    </h2>

    <!-- Search -->
    <div class="card" style="margin-bottom: var(--spacing-xl);">
        <form method="GET" action="<?php echo e(route('bendahara.data-santri')); ?>">
            <div style="display: flex; gap: var(--spacing-sm);">
                <input type="text" name="search" class="form-input" placeholder="Cari NIS/Nama..." value="<?php echo e(request('search')); ?>" style="flex: 1;">
                <button type="submit" class="btn btn-primary">
                    <i data-feather="search" style="width: 16px; height: 16px;"></i>
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>NIS</th>
                    <th>Nama Santri</th>
                    <th>Gender</th>
                    <th>Kelas</th>
                    <th>Asrama</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $santri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($s->nis); ?></td>
                        <td><?php echo e($s->nama_santri); ?></td>
                        <td>
                            <span class="badge <?php echo e($s->gender == 'putra' ? 'badge-info' : 'badge-warning'); ?>">
                                <?php echo e(ucfirst($s->gender)); ?>

                            </span>
                        </td>
                        <td><?php echo e($s->kelas->nama_kelas ?? '-'); ?></td>
                        <td><?php echo e($s->asrama->nama_asrama ?? '-'); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: var(--spacing-xl); color: var(--color-gray-500);">
                            Tidak ada data santri
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($santri->hasPages()): ?>
        <div style="margin-top: var(--spacing-lg); display: flex; justify-content: center;">
            <?php echo e($santri->links()); ?>

        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\bendahara\data-santri.blade.php ENDPATH**/ ?>