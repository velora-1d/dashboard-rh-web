<!DOCTYPE html>
<html>
<head>
    <title>Daftar Nilai Kelas <?php echo e($kelas->nama_kelas); ?></title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .table th, .table td { border: 1px solid #000; padding: 4px; }
        .table th { background-color: #f0f0f0; }
        .page-break { page-break-after: always; }
        h3 { margin-top: 0; margin-bottom: 5px; }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>REKAPITULASI NILAI SANTRI
            <?php if(isset($gender) && $gender != 'all'): ?> 
                <?php echo e($gender == 'putra' ? '(PUTRA)' : '(PUTRI)'); ?>

            <?php endif; ?>
        </h2>
        <p>Kelas: <?php echo e($kelas->nama_kelas); ?> | Tahun Ajaran: <?php echo e($tahunAjaran); ?> | Semester: <?php echo e($semester); ?></p>
    </div>

    <?php $__currentLoopData = $dataNilai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $santriId => $nilais): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $santri = $nilais->first()->santri; ?>
        <div style="margin-bottom: 15px; border-bottom: 1px dashed #ccc; padding-bottom: 15px;">
            <h3><?php echo e($loop->iteration); ?>. <?php echo e($santri->nama_santri ?? '-'); ?> (NIS: <?php echo e($santri->nis ?? '-'); ?>)</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th width="40%">Mata Pelajaran</th>
                        <th width="15%">Nilai</th>
                        <th width="10%">Grade</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; $count = 0; ?>
                    <?php $__currentLoopData = $nilais; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($n->mataPelajaran->nama_mapel ?? '-'); ?></td>
                            <td style="text-align: center;"><?php echo e($n->nilai_akhir); ?></td>
                            <td style="text-align: center;"><?php echo e($n->grade); ?></td>
                            <td><?php echo e($n->catatan); ?></td>
                        </tr>
                        <?php $total += $n->nilai_akhir; $count++; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr style="background: #fafafa; font-weight: bold;">
                        <td style="text-align: right;">RATA-RATA</td>
                        <td style="text-align: center;"><?php echo e($count > 0 ? number_format($total / $count, 2) : 0); ?></td>
                        <td colspan="2"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <?php if($loop->iteration % 3 == 0): ?> 
            <div class="page-break"></div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</body>
</html>
<?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\pendidikan\laporan\daftar-nilai-pdf.blade.php ENDPATH**/ ?>