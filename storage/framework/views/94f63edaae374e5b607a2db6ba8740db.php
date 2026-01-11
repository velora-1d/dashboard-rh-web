<!DOCTYPE html>
<html>
<head>
    <title>Ranking Kelas <?php echo e($kelas->nama_kelas); ?></title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #000; padding: 8px; }
        .table th { background-color: #f0f0f0; text-align: center; }
        .rank-top { font-weight: bold; }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>PERINGKAT KELAS: <?php echo e(strtoupper($kelas->nama_kelas)); ?> <br>
            <?php if(isset($gender) && $gender != 'all'): ?> 
                <?php echo e($gender == 'putra' ? '(PUTRA)' : '(PUTRI)'); ?>

            <?php endif; ?>
        </h2>
        <p>Tahun Ajaran: <?php echo e($tahunAjaran); ?> | Semester: <?php echo e($semester); ?></p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th width="10%">Peringkat</th>
                <th>Nama Santri</th>
                <th width="20%">NIS</th>
                <th width="20%">Total Nilai</th>
                <th width="20%">Rata-Rata</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $rankings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="<?php echo e($loop->iteration <= 3 ? 'rank-top' : ''); ?>">
                    <td style="text-align: center;"><?php echo e($loop->iteration); ?></td>
                    <td><?php echo e($item['santri']->nama_santri ?? '-'); ?></td>
                    <td style="text-align: center;"><?php echo e($item['santri']->nis ?? '-'); ?></td>
                    <td style="text-align: center;"><?php echo e(number_format($item['total_nilai'], 2)); ?></td>
                    <td style="text-align: center;"><?php echo e(number_format($item['rata_rata'], 2)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px;">Belum ada data nilai di kelas ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer" style="margin-top: 50px; text-align: right; margin-right: 50px;">
        <p>Tasikmalaya, <?php echo e(date('d F Y')); ?></p>
        <p>Wali Kelas,</p>
        <br><br><br>
        <p>_______________________</p>
    </div>

</body>
</html>
<?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\pendidikan\laporan\ranking-kelas-pdf.blade.php ENDPATH**/ ?>