<!DOCTYPE html>
<html>
<head>
    <title>Rapor - <?php echo e($santri->nama_santri); ?></title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        .header { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>RAPOR SANTRI</h1>
    
    <div class="header">
        <table style="border: none;">
            <tr style="border: none;">
                <td style="border: none; width: 150px;"><strong>Nama</strong></td>
                <td style="border: none;">: <?php echo e($santri->nama_santri); ?></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>NIS</strong></td>
                <td style="border: none;">: <?php echo e($santri->nis); ?></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Kelas</strong></td>
                <td style="border: none;">: <?php echo e($santri->kelas->nama_kelas ?? '-'); ?></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Tahun Ajaran</strong></td>
                <td style="border: none;">: <?php echo e($tahunAjaran); ?></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Semester</strong></td>
                <td style="border: none;">: <?php echo e($semester); ?></td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>UTS</th>
                <th>UAS</th>
                <th>Tugas</th>
                <th>Praktik</th>
                <th>Nilai Akhir</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $nilai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($n->mataPelajaran->nama_mapel ?? '-'); ?></td>
                    <td><?php echo e($n->nilai_uts ?? '-'); ?></td>
                    <td><?php echo e($n->nilai_uas ?? '-'); ?></td>
                    <td><?php echo e($n->nilai_tugas ?? '-'); ?></td>
                    <td><?php echo e($n->nilai_praktik ?? '-'); ?></td>
                    <td><strong><?php echo e(number_format($n->nilai_akhir ?? 0, 2)); ?></strong></td>
                    <td><strong><?php echo e($n->grade ?? '-'); ?></strong></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td colspan="6" style="text-align: right;"><strong>Rata-rata:</strong></td>
                <td colspan="2"><strong><?php echo e(number_format($nilai->avg('nilai_akhir'), 2)); ?></strong></td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 40px;">
        <p>Dicetak pada: <?php echo e(date('d/m/Y H:i')); ?></p>
    </div>
</body>
</html>
<?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\pendidikan\exports\rapor.blade.php ENDPATH**/ ?>