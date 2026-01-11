<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Talaran Minggu 1-2</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header h2 { margin: 5px 0; font-size: 14px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background-color: #f0f0f0; }
        .text-left { text-align: left; }
        .text-alfa { color: #ef4444; font-weight: bold; font-size: 11px; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; padding: 10px; }
        }
    </style>
</head>
<body onload="window.print()">
    
    <div class="no-print" style="margin-bottom: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Cetak Laporan</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer;">Tutup</button>
    </div>

    <div class="header">
        <h1>LAPORAN TALARAN MINGGU 1-2</h1>
        <h2>Bulan: <?php echo e($monthName); ?> <?php echo e($tahun); ?> | Kelas: <?php echo e($kelasName); ?></h2>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 22%;">Nama Santri</th>
                <th style="width: 13%;">Kelas / Kitab</th>
                <th style="width: 7%;">Minggu 1</th>
                <th style="width: 7%;">Minggu 2</th>
                <th style="width: 7%;">Jumlah</th>
                <th style="width: 7%;">Tamat</th>
                <th style="width: 7%;">Alfa</th>
                <th style="width: 13%;">Total</th>
                <th style="width: 12%;">KET</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $santriList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $talaran = $talaranRecords->get($santri->id);
                ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td class="text-left"><?php echo e($santri->nama_santri); ?></td>
                    <td><?php echo e($santri->kelas->nama_kelas ?? '-'); ?> (<?php echo e($santri->kelas->kitab_talaran ?? '-'); ?>)</td>
                    <td><?php echo e($talaran->minggu_1 ?? 0); ?></td>
                    <td><?php echo e($talaran->minggu_2 ?? 0); ?></td>
                    <td><b><?php echo e($talaran->jumlah_1_2 ?? 0); ?></b></td>
                    <td><?php echo e($talaran->tamat_1_2 ?? 0); ?></td>
                    <td><?php echo e($talaran->alfa_1_2 ?? 0); ?></td>
                    <td><?php echo e($talaran->total_1_2 ?? '-'); ?></td>
                    <td class="text-alfa"><?php if(($talaran->alfa_1_2 ?? 0) > 0): ?> ALFA <?php echo e($talaran->alfa_1_2); ?> <?php endif; ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="10">Tidak ada data.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div style="margin-top: 30px; float: right; text-align: center; width: 200px;">
        <p>Mengetahui,</p>
        <br><br><br>
        <p>Kepala Pondok</p>
    </div>
</body>
</html>
<?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\pendidikan\talaran\pdf\1-2.blade.php ENDPATH**/ ?>