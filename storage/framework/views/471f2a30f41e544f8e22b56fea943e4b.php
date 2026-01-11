<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Gaji Pegawai</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { color: #1B5E20; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .summary { margin-top: 20px; padding: 15px; background-color: #E8F5E9; border-radius: 5px; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .badge-success { background-color: #4CAF50; color: white; }
        .badge-error { background-color: #f44336; color: white; }
    </style>
</head>
<body>
    <h2>Laporan Gaji Pegawai</h2>
    <p style="text-align: center;">
        <?php if($request->filled('tahun') || $request->filled('bulan')): ?>
            Periode: 
            <?php if($request->filled('bulan')): ?>
                <?php echo e(date('F', mktime(0, 0, 0, $request->bulan, 1))); ?>

            <?php endif; ?>
            <?php if($request->filled('tahun')): ?>
                <?php echo e($request->tahun); ?>

            <?php endif; ?>
        <?php else: ?>
            Semua Periode
        <?php endif; ?>
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                <th>Jabatan</th>
                <th>Periode Gaji</th>
                <th>Nominal</th>
                <th>Status</th>
                <th>Tanggal Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $gaji; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($g->pegawai->nama_pegawai ?? '-'); ?></td>
                    <td><?php echo e($g->pegawai->jabatan ?? '-'); ?></td>
                    <td><?php echo e(date('F', mktime(0, 0, 0, $g->bulan, 1))); ?> <?php echo e($g->tahun); ?></td>
                    <td>Rp <?php echo e(number_format($g->nominal, 0, ',', '.')); ?></td>
                    <td>
                        <span class="badge <?php echo e($g->is_dibayar ? 'badge-success' : 'badge-error'); ?>">
                            <?php echo e($g->is_dibayar ? 'Sudah Dibayar' : 'Belum Dibayar'); ?>

                        </span>
                    </td>
                    <td><?php echo e($g->tanggal_bayar ? $g->tanggal_bayar->format('d/m/Y') : '-'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data gaji</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="summary">
        <h3>Ringkasan</h3>
        <p><strong>Total Gaji:</strong> Rp <?php echo e(number_format($totalGaji, 0, ',', '.')); ?></p>
        <p><strong>Total Sudah Dibayar:</strong> Rp <?php echo e(number_format($totalDibayar, 0, ',', '.')); ?></p>
        <p><strong>Total Belum Dibayar:</strong> Rp <?php echo e(number_format($totalBelumDibayar, 0, ',', '.')); ?></p>
        <p><strong>Jumlah Transaksi:</strong> <?php echo e($gaji->count()); ?></p>
    </div>

    <p style="margin-top: 30px; text-align: center; font-size: 12px; color: #666;">
        Dicetak pada: <?php echo e(now()->format('d/m/Y H:i:s')); ?><br>
        Yayasan Pondok Pesantren Riyadlul Huda
    </p>
</body>
</html>
<?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\bendahara\exports\laporan-gaji.blade.php ENDPATH**/ ?>