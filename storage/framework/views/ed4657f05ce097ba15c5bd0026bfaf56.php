<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Absensi Santri</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f0f0f0; text-align: center; }
        .text-center { text-align: center; }
        .badge { display: inline-block; padding: 2px 5px; border-radius: 3px; font-size: 10px; font-weight: bold; }
        .badge-danger { background-color: #fee2e2; color: #991b1b; }
        .badge-success { background-color: #dcfce7; color: #166534; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; padding: 10px; }
        }
    </style>
</head>
<body onload="window.print()">
    
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Cetak Laporan</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer;">Tutup</button>
    </div>

    <div class="header">
        <h1>LAPORAN ABSENSI SANTRI</h1>
        <p>RIYADLUL HUDA</p>
        <p>Periode: 
            <?php if(request('tahun')): ?> Tahun <?php echo e(request('tahun')); ?> <?php endif; ?>
            <?php if(request('minggu_ke')): ?> Minggu Ke-<?php echo e(request('minggu_ke')); ?> <?php endif; ?>
            <?php if(request('kelas_id')): ?> (Kelas: <?php echo e(\App\Models\Kelas::find(request('kelas_id'))->nama_kelas ?? 'All'); ?>) <?php endif; ?>
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Periode</th>
                <th style="width: 10%;">NIS</th>
                <th style="width: 20%;">Nama Santri</th>
                <th style="width: 10%;">Kelas</th>
                <th style="width: 8%;">Sorogan</th>
                <th style="width: 8%;">Hafalan Malam</th>
                <th style="width: 8%;">Hafalan Subuh</th>
                <th style="width: 8%;">Tahajud</th>
                <th style="width: 8%;">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $absensi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="text-center"><?php echo e($index + 1); ?></td>
                    <td>
                        Minggu <?php echo e($a->minggu_ke); ?>, <?php echo e($a->tahun); ?><br>
                        <small><?php echo e($a->tanggal_mulai->format('d/m/y')); ?> - <?php echo e($a->tanggal_selesai->format('d/m/y')); ?></small>
                    </td>
                    <td><?php echo e($a->santri->nis ?? '-'); ?></td>
                    <td><?php echo e($a->santri->nama_santri ?? '-'); ?></td>
                    <td class="text-center"><?php echo e($a->kelas->nama_kelas ?? '-'); ?></td>
                    <td class="text-center"><?php echo e($a->alfa_sorogan); ?></td>
                    <td class="text-center"><?php echo e($a->alfa_menghafal_malam); ?></td>
                    <td class="text-center"><?php echo e($a->alfa_menghafal_subuh); ?></td>
                    <td class="text-center"><?php echo e($a->alfa_tahajud); ?></td>
                    <td class="text-center" style="font-weight: bold;"><?php echo e($a->total_alfa); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="10" class="text-center">Tidak ada data absensi untuk periode ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 30px; float: right; text-align: center; width: 200px;">
        <p>Mengetahui,</p>
        <br><br><br>
        <p>___________________</p>
        <p>Kepala Pondok</p>
    </div>

</body>
</html>
<?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\pendidikan\absensi\cetak.blade.php ENDPATH**/ ?>