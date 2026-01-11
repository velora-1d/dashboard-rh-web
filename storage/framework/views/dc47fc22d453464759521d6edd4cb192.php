<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Santri per Asrama - Riyadlul Huda</title>
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
        .asrama-section {
            margin-bottom: 40px;
            page-break-inside: avoid;
        }
        .asrama-header {
            background-color: #1B5E20;
            color: white;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .asrama-title {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }
        .asrama-info {
            font-size: 14px;
            margin: 5px 0 0 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #E8F5E9;
        }
        .text-center {
            text-align: center;
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
        .badge-warning {
            background-color: #FFE0B2;
            color: #E65100;
        }
        .badge-error {
            background-color: #FFCDD2;
            color: #C62828;
        }
        .summary {
            background-color: #E8F5E9;
            padding: 15px;
            border-radius: 5px;
            margin-top: 30px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>STATISTIK SANTRI PER ASRAMA</h1>
    <p class="subtitle">Yayasan Pondok Pesantren Riyadlul Huda</p>
    <p class="subtitle">Tanggal: <?php echo e(date('d F Y')); ?></p>

    <?php $__currentLoopData = $statistik; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="asrama-section">
            <div class="asrama-header">
                <p class="asrama-title"><?php echo e($data['asrama']); ?></p>
                <p class="asrama-info">
                    Gender: <?php echo e(ucfirst($data['gender'])); ?> | 
                    Total Santri: <?php echo e($data['total_santri']); ?> | 
                    Total Kobong: <?php echo e($data['total_kobong']); ?>

                </p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Kobong</th>
                        <th class="text-center">Jumlah Santri</th>
                        <th class="text-center">Kapasitas</th>
                        <th class="text-center">Sisa Kapasitas</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data['kobong_detail']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kobong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>Kobong <?php echo e($kobong['nomor']); ?></td>
                            <td class="text-center"><?php echo e($kobong['jumlah_santri']); ?></td>
                            <td class="text-center"><?php echo e($kobong['kapasitas']); ?></td>
                            <td class="text-center"><?php echo e($kobong['sisa_kapasitas']); ?></td>
                            <td class="text-center">
                                <?php if($kobong['sisa_kapasitas'] > 10): ?>
                                    <span class="badge badge-success">Tersedia</span>
                                <?php elseif($kobong['sisa_kapasitas'] > 0): ?>
                                    <span class="badge badge-warning">Terbatas</span>
                                <?php else: ?>
                                    <span class="badge badge-error">Penuh</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div class="summary">
        <h3 style="margin-top: 0; color: #1B5E20;">Ringkasan</h3>
        <?php
            $totalSantriAll = array_sum(array_column($statistik, 'total_santri'));
            $totalKobongAll = array_sum(array_column($statistik, 'total_kobong'));
            $totalKapasitas = $totalKobongAll * 20;
            $sisaKapasitas = $totalKapasitas - $totalSantriAll;
        ?>
        <p><strong>Total Santri Seluruh Asrama:</strong> <?php echo e($totalSantriAll); ?></p>
        <p><strong>Total Kobong:</strong> <?php echo e($totalKobongAll); ?></p>
        <p><strong>Total Kapasitas:</strong> <?php echo e($totalKapasitas); ?></p>
        <p><strong>Sisa Kapasitas:</strong> <?php echo e($sisaKapasitas); ?></p>
    </div>

    <div class="footer">
        <p>Dibuat oleh Mahin Utsman Nawawi, S.H</p>
        <p>Dashboard Riyadlul Huda - Sistem Informasi Pondok Pesantren</p>
    </div>
</body>
</html>
<?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\sekretaris\laporan\statistik-asrama-pdf.blade.php ENDPATH**/ ?>