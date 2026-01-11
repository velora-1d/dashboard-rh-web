<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Mutasi Santri - Riyadlul Huda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #1B5E20;
            margin-bottom: 10px;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
        }
        .period {
            text-align: center;
            background-color: #E8F5E9;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: bold;
            color: #1B5E20;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #1B5E20;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #E8F5E9;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-success {
            background-color: #C8E6C9;
            color: #1B5E20;
        }
        .badge-error {
            background-color: #FFCDD2;
            color: #C62828;
        }
        .badge-info {
            background-color: #BBDEFB;
            color: #1565C0;
        }
        .badge-warning {
            background-color: #FFE0B2;
            color: #E65100;
        }
        .summary {
            background-color: #E8F5E9;
            padding: 15px;
            border-radius: 5px;
            margin-top: 30px;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <h1>LAPORAN MUTASI SANTRI</h1>
    <p class="subtitle">Yayasan Pondok Pesantren Riyadlul Huda</p>
    <p class="subtitle">Tanggal Cetak: <?php echo e(date('d F Y')); ?></p>
    
    <div class="period">
        Periode: <?php echo e($tanggalMulai == 'Awal' ? 'Awal' : date('d F Y', strtotime($tanggalMulai))); ?> 
        s/d 
        <?php echo e($tanggalSelesai == 'Sekarang' ? 'Sekarang' : date('d F Y', strtotime($tanggalSelesai))); ?>

    </div>

    <?php if($mutasi->count() > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>NIS</th>
                    <th>Nama Santri</th>
                    <th>Jenis Mutasi</th>
                    <th>Dari</th>
                    <th>Ke</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $jenisCounts = [
                        'masuk' => 0,
                        'keluar' => 0,
                        'pindah_kelas' => 0,
                        'pindah_asrama' => 0,
                    ];
                ?>
                
                <?php $__currentLoopData = $mutasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-center"><?php echo e($index + 1); ?></td>
                        <td><?php echo e($m->tanggal_mutasi->format('d/m/Y')); ?></td>
                        <td><?php echo e($m->santri->nis ?? '-'); ?></td>
                        <td><?php echo e($m->santri->nama_santri ?? '-'); ?></td>
                        <td>
                            <?php if($m->jenis_mutasi == 'masuk'): ?>
                                <span class="badge badge-success">Masuk</span>
                            <?php elseif($m->jenis_mutasi == 'keluar'): ?>
                                <span class="badge badge-error">Keluar</span>
                            <?php elseif($m->jenis_mutasi == 'pindah_kelas'): ?>
                                <span class="badge badge-info">Pindah Kelas</span>
                            <?php else: ?>
                                <span class="badge badge-warning">Pindah Asrama</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($m->dari ?? '-'); ?></td>
                        <td><?php echo e($m->ke ?? '-'); ?></td>
                        <td><?php echo e($m->keterangan ?? '-'); ?></td>
                    </tr>
                    <?php
                        $jenisCounts[$m->jenis_mutasi] = ($jenisCounts[$m->jenis_mutasi] ?? 0) + 1;
                    ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <div class="summary">
            <h3 style="margin-top: 0; color: #1B5E20;">Ringkasan Mutasi</h3>
            <p><strong>Total Mutasi:</strong> <?php echo e($mutasi->count()); ?></p>
            <p><strong>Santri Masuk:</strong> <?php echo e($jenisCounts['masuk']); ?></p>
            <p><strong>Santri Keluar:</strong> <?php echo e($jenisCounts['keluar']); ?></p>
            <p><strong>Pindah Kelas:</strong> <?php echo e($jenisCounts['pindah_kelas']); ?></p>
            <p><strong>Pindah Asrama:</strong> <?php echo e($jenisCounts['pindah_asrama']); ?></p>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <p>Tidak ada data mutasi untuk periode yang dipilih</p>
        </div>
    <?php endif; ?>

    <div class="footer">
        <p>Dibuat oleh Mahin Utsman Nawawi, S.H</p>
        <p>Dashboard Riyadlul Huda - Sistem Informasi Pondok Pesantren</p>
    </div>
</body>
</html>
<?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\sekretaris\laporan\mutasi-pdf.blade.php ENDPATH**/ ?>