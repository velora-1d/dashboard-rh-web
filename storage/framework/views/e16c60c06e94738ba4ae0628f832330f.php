<!DOCTYPE html>
<html>
<head>
    <title>Statistik Prestasi Santri</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #000; padding: 8px; }
        .table th { background-color: #f0f0f0; text-align: center; }
        .rank-1 { background-color: #fffac1; } /* Goldish */
        .rank-2 { background-color: #f0f0f0; } /* Silverish */
        .rank-3 { background-color: #ffe6cc; } /* Bronzeish */
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>STATISTIK PRESTASI SANTRI (TOP 20)</h2>
        <p>
            <?php if(isset($kelasId) && $kelasId): ?>
                Kelas: <?php echo e(\App\Models\Kelas::find($kelasId)->nama_kelas ?? 'All'); ?> |
            <?php endif; ?>
            <?php if(isset($gender) && $gender != 'all'): ?>
                Gender: <?php echo e($gender == 'putra' ? 'Putra' : 'Putri'); ?> |
            <?php endif; ?>
            Tahun Ajaran: <?php echo e($tahunAjaran); ?> | Semester: <?php echo e($semester); ?>

        </p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th width="5%">Rank</th>
                <th>Nama Santri</th>
                <th width="15%">Kelas</th>
                <th width="15%">Rata-Rata Nilai</th>
                <th width="15%">Total Nilai</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $rankings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="<?php echo e($loop->iteration <= 3 ? 'rank-'.$loop->iteration : ''); ?>">
                    <td style="text-align: center; font-weight: bold;"><?php echo e($loop->iteration); ?></td>
                    <td>
                        <strong><?php echo e($item['santri']->nama_santri ?? '-'); ?></strong><br>
                        <small>NIS: <?php echo e($item['santri']->nis ?? '-'); ?></small>
                    </td>
                    <td style="text-align: center;"><?php echo e($item['santri']->kelas->nama_kelas ?? '-'); ?></td>
                    <td style="text-align: center; font-weight: bold; font-size: 1.1em;"><?php echo e(number_format($item['rata_rata'], 2)); ?></td>
                    <td style="text-align: center;"><?php echo e(number_format($item['total_nilai'], 2)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px;">Tidak ada data nilai tersedia.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 30px; font-size: 12px; color: #666;">
        <p>* Peringkat dihitung berdasarkan rata-rata Nilai Akhir dari semua mata pelajaran yang diambil santri.</p>
    </div>

</body>
</html>
<?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\pendidikan\laporan\statistik-prestasi-pdf.blade.php ENDPATH**/ ?>