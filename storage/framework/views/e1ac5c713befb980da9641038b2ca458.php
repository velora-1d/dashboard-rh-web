<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Santri</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; font-size: 12px; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .header p { margin: 5px 0; font-size: 14px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>PONTREN RIYADLUL HUDA</h2>
        <p>Laporan Data Santri Aktif</p>
        <p>Per Tanggal: <?php echo e(date('d F Y')); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 10%">NIS</th>
                <th style="width: 25%">Nama Santri</th>
                <th style="width: 10%">Gender</th>
                <th style="width: 15%">Kelas</th>
                <th style="width: 20%">Asrama</th>
                <th style="width: 15%">Kobong</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $santri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td style="text-align: center;"><?php echo e($index + 1); ?></td>
                <td style="text-align: center;"><?php echo e($s->nis); ?></td>
                <td><?php echo e($s->nama_santri); ?></td>
                <td style="text-align: center;"><?php echo e(ucfirst($s->gender)); ?></td>
                <td style="text-align: center;"><?php echo e($s->kelas->nama_kelas ?? '-'); ?></td>
                <td style="text-align: center;"><?php echo e($s->asrama->nama_asrama ?? '-'); ?></td>
                <td style="text-align: center;">
                    <?php if($s->kobong): ?>
                        Kobong <?php echo e($s->kobong->nomor_kobong); ?>

                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    
    <div style="margin-top: 20px; font-size: 11px; text-align: right;">
        Dicetak pada: <?php echo e(date('d-m-Y H:i:s')); ?>

    </div>
</body>
</html>
<?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\sekretaris\laporan\laporan-santri-pdf.blade.php ENDPATH**/ ?>