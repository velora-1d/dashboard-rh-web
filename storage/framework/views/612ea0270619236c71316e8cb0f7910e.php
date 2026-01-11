<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Santri per Kelas - Riyadlul Huda</title>
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
        .total-row {
            font-weight: bold;
            background-color: #C8E6C9 !important;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
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
    <h1>STATISTIK SANTRI PER KELAS</h1>
    <p class="subtitle">Yayasan Pondok Pesantren Riyadlul Huda</p>
    <p class="subtitle">Tanggal: <?php echo e(date('d F Y')); ?></p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kelas</th>
                <th>Tingkat</th>
                <th class="text-center">Putra</th>
                <th class="text-center">Putri</th>
                <th class="text-center">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $totalPutra = 0;
                $totalPutri = 0;
                $grandTotal = 0;
            ?>
            
            <?php $__currentLoopData = $statistik; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="text-center"><?php echo e($index + 1); ?></td>
                    <td><?php echo e($data['kelas']); ?></td>
                    <td><?php echo e($data['tingkat']); ?></td>
                    <td class="text-center"><?php echo e($data['putra']); ?></td>
                    <td class="text-center"><?php echo e($data['putri']); ?></td>
                    <td class="text-center"><strong><?php echo e($data['total']); ?></strong></td>
                </tr>
                <?php
                    $totalPutra += $data['putra'];
                    $totalPutri += $data['putri'];
                    $grandTotal += $data['total'];
                ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <tr class="total-row">
                <td colspan="3" class="text-right"><strong>TOTAL KESELURUHAN</strong></td>
                <td class="text-center"><strong><?php echo e($totalPutra); ?></strong></td>
                <td class="text-center"><strong><?php echo e($totalPutri); ?></strong></td>
                <td class="text-center"><strong><?php echo e($grandTotal); ?></strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Dibuat oleh Mahin Utsman Nawawi, S.H</p>
        <p>Dashboard Riyadlul Huda - Sistem Informasi Pondok Pesantren</p>
    </div>
</body>
</html>
<?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\sekretaris\laporan\statistik-kelas-pdf.blade.php ENDPATH**/ ?>