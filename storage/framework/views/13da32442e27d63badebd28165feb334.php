<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Syahriah</title>
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
    <h2>Laporan Pembayaran Syahriah</h2>
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
                <th>NIS</th>
                <th>Nama Santri</th>
                <th>Bulan/Tahun</th>
                <th>Nominal</th>
                <th>Status</th>
                <th>Tanggal Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $syahriah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($s->santri->nis ?? '-'); ?></td>
                    <td><?php echo e($s->santri->nama_santri ?? '-'); ?></td>
                    <td><?php echo e(date('F', mktime(0, 0, 0, $s->bulan, 1))); ?> <?php echo e($s->tahun); ?></td>
                    <td>Rp <?php echo e(number_format($s->nominal, 0, ',', '.')); ?></td>
                    <td>
                        <span class="badge <?php echo e($s->is_lunas ? 'badge-success' : 'badge-error'); ?>">
                            <?php echo e($s->is_lunas ? 'Lunas' : 'Belum Lunas'); ?>

                        </span>
                    </td>
                    <td><?php echo e($s->tanggal_bayar ? $s->tanggal_bayar->format('d/m/Y') : '-'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="summary">
        <h3>Ringkasan</h3>
        <p><strong>Total Syahriah:</strong> Rp <?php echo e(number_format($totalNominal, 0, ',', '.')); ?></p>
        <p><strong>Total Lunas:</strong> Rp <?php echo e(number_format($totalLunas, 0, ',', '.')); ?></p>
        <p><strong>Total Belum Lunas:</strong> Rp <?php echo e(number_format($totalBelumLunas, 0, ',', '.')); ?></p>
        <p><strong>Jumlah Transaksi:</strong> <?php echo e($syahriah->count()); ?></p>
    </div>

    <p style="margin-top: 30px; text-align: center; font-size: 12px; color: #666;">
        Dicetak pada: <?php echo e(now()->format('d/m/Y H:i:s')); ?><br>
        Yayasan Pondok Pesantren Riyadlul Huda
    </p>
</body>
</html>
<?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\bendahara\exports\laporan-syahriah.blade.php ENDPATH**/ ?>