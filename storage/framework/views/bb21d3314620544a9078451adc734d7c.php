<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Pemasukan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { color: #1B5E20; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .summary { margin-top: 20px; padding: 15px; background-color: #E8F5E9; border-radius: 5px; }
    </style>
</head>
<body>
    <h2>Laporan Pemasukan</h2>
    <p style="text-align: center;">
        <?php if($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')): ?>
            Periode: <?php echo e(\Carbon\Carbon::parse($request->tanggal_mulai)->format('d M Y')); ?> - <?php echo e(\Carbon\Carbon::parse($request->tanggal_selesai)->format('d M Y')); ?>

        <?php elseif($request->filled('tanggal_mulai')): ?>
            Sejak: <?php echo e(\Carbon\Carbon::parse($request->tanggal_mulai)->format('d M Y')); ?>

        <?php elseif($request->filled('tanggal_selesai')): ?>
            Sampai: <?php echo e(\Carbon\Carbon::parse($request->tanggal_selesai)->format('d M Y')); ?>

        <?php else: ?>
            Semua Periode
        <?php endif; ?>
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Sumber Pemasukan</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $pemasukan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($p->tanggal->format('d/m/Y')); ?></td>
                    <td><?php echo e($p->sumber_pemasukan); ?></td>
                    <td style="text-transform: capitalize;"><?php echo e($p->kategori); ?></td>
                    <td><?php echo e($p->keterangan ?? '-'); ?></td>
                    <td style="text-align: right;">Rp <?php echo e(number_format($p->nominal, 0, ',', '.')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data pemasukan</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="summary">
        <h3>Ringkasan</h3>
        <p><strong>Total Pemasukan:</strong> Rp <?php echo e(number_format($totalPemasukan, 0, ',', '.')); ?></p>
        <p><strong>Jumlah Transaksi:</strong> <?php echo e($pemasukan->count()); ?></p>
    </div>

    <p style="margin-top: 30px; text-align: center; font-size: 12px; color: #666;">
        Dicetak pada: <?php echo e(now()->format('d/m/Y H:i:s')); ?><br>
        Yayasan Pondok Pesantren Riyadlul Huda
    </p>
</body>
</html>
<?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\bendahara\exports\laporan-pemasukan.blade.php ENDPATH**/ ?>