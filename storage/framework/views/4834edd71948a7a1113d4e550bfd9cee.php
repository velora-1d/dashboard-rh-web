<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Kas</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { color: #1B5E20; text-align: center; }
        h3 { color: #2E7D32; margin-top: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .summary { margin-top: 20px; padding: 15px; background-color: #E8F5E9; border-radius: 5px; }
        .saldo-positive { color: #4CAF50; font-weight: bold; }
        .saldo-negative { color: #f44336; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Laporan Arus Kas</h2>
    <p style="text-align: center;">
        Periode: 
        <?php echo e($request->filled('tanggal_mulai') ? date('d/m/Y', strtotime($request->tanggal_mulai)) : 'Awal'); ?>

        s/d
        <?php echo e($request->filled('tanggal_selesai') ? date('d/m/Y', strtotime($request->tanggal_selesai)) : 'Sekarang'); ?>

    </p>

    <h3>Pemasukan</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Sumber</th>
                <th>Kategori</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $pemasukan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($p->tanggal->format('d/m/Y')); ?></td>
                    <td><?php echo e($p->sumber_pemasukan); ?></td>
                    <td><?php echo e(ucfirst($p->kategori)); ?></td>
                    <td>Rp <?php echo e(number_format($p->nominal, 0, ',', '.')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data</td>
                </tr>
            <?php endif; ?>
            <tr style="background-color: #C8E6C9; font-weight: bold;">
                <td colspan="4" style="text-align: right;">Total Pemasukan:</td>
                <td>Rp <?php echo e(number_format($totalPemasukan, 0, ',', '.')); ?></td>
            </tr>
        </tbody>
    </table>

    <h3>Pengeluaran</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Kategori</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $pengeluaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($p->tanggal->format('d/m/Y')); ?></td>
                    <td><?php echo e($p->jenis_pengeluaran); ?></td>
                    <td><?php echo e(ucfirst($p->kategori)); ?></td>
                    <td>Rp <?php echo e(number_format($p->nominal, 0, ',', '.')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data</td>
                </tr>
            <?php endif; ?>
            <tr style="background-color: #FFCDD2; font-weight: bold;">
                <td colspan="4" style="text-align: right;">Total Pengeluaran:</td>
                <td>Rp <?php echo e(number_format($totalPengeluaran, 0, ',', '.')); ?></td>
            </tr>
        </tbody>
    </table>

    <div class="summary">
        <h3>Ringkasan Kas</h3>
        <p><strong>Total Pemasukan:</strong> Rp <?php echo e(number_format($totalPemasukan, 0, ',', '.')); ?></p>
        <p><strong>Total Pengeluaran:</strong> Rp <?php echo e(number_format($totalPengeluaran, 0, ',', '.')); ?></p>
        <p class="<?php echo e($saldoKas >= 0 ? 'saldo-positive' : 'saldo-negative'); ?>">
            <strong>Saldo Kas:</strong> Rp <?php echo e(number_format($saldoKas, 0, ',', '.')); ?>

        </p>
    </div>

    <p style="margin-top: 30px; text-align: center; font-size: 12px; color: #666;">
        Dicetak pada: <?php echo e(now()->format('d/m/Y H:i:s')); ?><br>
        Yayasan Pondok Pesantren Riyadlul Huda
    </p>
</body>
</html>
<?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\bendahara\exports\laporan-keuangan-lengkap.blade.php ENDPATH**/ ?>