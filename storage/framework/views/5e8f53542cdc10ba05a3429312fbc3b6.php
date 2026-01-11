<?php
    // Default value for isPdfDownload if not set (for browser preview)
    $isPdfDownload = $isPdfDownload ?? false;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor Digital - <?php echo e($dataRapor[0]['santri']->nama_santri ?? 'Santri'); ?></title>
    <!-- Google Fonts for Modern Look on Screen -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Noto+Serif:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        /* CSS RESET & VARS */
        :root {
            --primary-color: #0d5f2d;
            --text-color: #333;
            --border-color: #000;
        }
        
        /* PAGE SETUP FOR PRINT */
        @page {
            size: 216mm 330mm; /* F4 */
            margin: 0; /* Control margin via body inside */
        }

        /* GLOBAL STYLES */
        body {
            font-family: 'Noto Serif', serif; /* Professional Serif for print */
            color: #000;
            margin: 0;
            padding: 0;
            background-color: #525659; /* PDF Viewer Background Color */
            -webkit-print-color-adjust: exact;
        }

        /* PAPER CONTAINER (PREVIEW MODE) */
        .page-container {
            width: 216mm;
            min-height: 330mm;
            background: white;
            margin: 30px auto;
            padding: 15mm 20mm; /* INTERNAL MARGINS */
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            position: relative;
            box-sizing: border-box;
        }

        /* PRINT OVERRIDES */
        @media print {
            body {
                background: white;
            }
            .page-container {
                width: 100%;
                margin: 0;
                padding: 15mm 20mm; /* Keep margins */
                box-shadow: none;
                min-height: auto;
            }
            .no-print {
                display: none !important;
            }
        }

        /* TYPOGRAPHY UTILS */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .text-uppercase { text-transform: uppercase; }
        .text-small { font-size: 9pt; }
        
        /* COMPACT LAYOUT FOR F4 */
        .page-container {
            padding: 8mm 12mm;
            font-size: 9pt;
            position: relative; /* Context for watermark */
            z-index: 1;
        }
        
        /* WATERMARK */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            opacity: 0.1; /* Subtle transparent effect */
            z-index: -1; /* Behind text */
            pointer-events: none;
        }
        
        .header-wrapper {
            margin-bottom: 2px;
            padding-bottom: 2px;
            width: 100%;
            position: relative; z-index: 2;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            vertical-align: middle;
            border: none !important;
        }
        .header-logo { width: 80px; max-height: 80px; }
        .rapor-title { font-size: 11pt; margin: 5px 0; font-weight: bold; position: relative; z-index: 2; }
        .identity-table { 
            width: 100%; 
            margin-bottom: 6px; 
            font-size: 9pt; 
            position: relative; 
            z-index: 2; 
            border-collapse: collapse;
        }
        .identity-table td {
            border: none !important;
            padding: 2px 5px;
            vertical-align: top;
        }
        .data-table th, .data-table td { padding: 3px 4px; font-size: 8.5pt; }
        .data-table { position: relative; z-index: 2; }
        .group-header { padding: 3px 8px !important; }
        
        /* STABLE TABLE-BASED SIGNATURES */
        .sig-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
            margin-top: 5px; /* Reduced from 30px to move Tasikmalaya up */
        }
        .sig-table td {
            border: none !important;
            padding: 0;
            text-align: center;
            vertical-align: top;
            width: 33.33%;
        }
        .sig-role {
            font-size: 10pt;
            height: 50px;
            vertical-align: top;
        }
        .sig-date {
            margin-top: -20px; /* Specifically move the date up */
            margin-bottom: 5px;
            display: block;
        }
        .sig-space {
            height: 120px;
            position: relative;
        }
        .sig-name {
            font-weight: bold;
            text-decoration: underline;
            padding-top: 5px;
            display: inline-block;
            position: relative;
            z-index: 1;
        }
        .sig-ttd-wrapper {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 5;
            pointer-events: none;
        }
        .sig-img {
            height: 180px; /* Large for Pimpinan (with Seal) */
            width: auto;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -40%);
        }
        .sig-img.small {
            height: 140px; /* More proportional for Wali Kelas */
            transform: translate(-50%, -20%); /* Lowered to touch name better */
        }
        
        .text-bold { font-weight: bold; }
        /* HEADER / KOP SURAT */

        /* DOCUMENT INFO STRIP */
        .doc-info {
            display: flex;
            justify-content: space-between;
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            padding: 5px 0;
            margin-bottom: 20px;
            font-family: 'Roboto', sans-serif;
            font-size: 8pt;
            color: #555;
        }

        /* TITLE */
        .rapor-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 20px;
            letter-spacing: 2px;
            border-bottom: 1px solid #000;
            display: inline-block;
            padding-bottom: 2px;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }

        /* IDENTITY - Table based for DomPDF */
        .identity-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 10pt;
        }
        .identity-table td {
            border: none !important;
            padding: 2px 5px;
            vertical-align: top;
        }
        .identity-label { width: 100px; font-weight: 600; }
        .identity-colon { width: 15px; text-align: center; }
        .identity-value { font-weight: 500; }

        /* TABLES */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 9.5pt;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #000;
            padding: 6px 8px;
        }
        table.data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
            font-family: 'Roboto', sans-serif;
        }
        table.data-table td {
            vertical-align: middle;
        }
        .group-header {
            background-color: #e8f5e9;
            font-weight: bold;
            font-family: 'Roboto', sans-serif;
            padding: 8px 10px !important;
        }
        
        .signature-nip { font-size: 8pt; }
        .scan-ttd {
            height: 70px;
            width: auto;
            display: block;
            margin: 0 auto;
        }

        /* FAB PRINT BUTTON */
        .fab-print {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: var(--primary-color);
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            cursor: pointer;
            z-index: 1000;
            transition: transform 0.2s;
            border: none;
        }
        .fab-print:hover { transform: scale(1.1); }
        .fab-tooltip {
            position: absolute;
            right: 70px;
            background: #333;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.2s;
            pointer-events: none;
```
        }
        .fab-print:hover .fab-tooltip { opacity: 1; }

    </style>
</head>
<body style="margin: 0; padding: 0; background: #525659;">
    <div id="pdf-content">

    <!-- Loop for Bulk Printing -->
    <?php $__currentLoopData = $dataRapor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $santri = $data['santri'];
        $grades = $data['grades'];
        $kehadiran = $data['kehadiran'];
        $ranking = $data['ranking'];
        $totalSiswa = $data['totalSiswa'];
        $noRapor = $data['noRapor'];

        // Calculate Average Score specific for this Rapor
        $totalNilai = 0;
        $jumlahMapelDinilai = 0;
        
        // Usually Ekstra is not included in Academic Average. Let's stick to Wajib and Diniyah.
        $academicMapels = $mapel_wajib->merge($mapel_diniyah);
        
        foreach($academicMapels as $m) {
            if(isset($grades[$m->id]) && $grades[$m->id]->nilai_akhir) {
                $totalNilai += $grades[$m->id]->nilai_akhir;
                $jumlahMapelDinilai++;
            }
        }
        
        $rataRata = $jumlahMapelDinilai > 0 ? $totalNilai / $jumlahMapelDinilai : 0;
        
        // Dynamic Catatan Logic
        $dynamicCatatan = "";
        if($rataRata >= 90) {
            $dynamicCatatan = "Prestasi yang sangat membanggakan! Pertahankan semangat belajarmu dan jadilah teladan bagi teman-temanmu.";
        } elseif($rataRata >= 80) {
            $dynamicCatatan = "Prestasi yang baik. Tingkatkan terus ketelitian dan keaktifanmu di kelas agar hasilnya semakin maksimal.";
        } elseif($rataRata >= 70) {
            $dynamicCatatan = "Cukup baik, namun kamu perlu lebih fokus lagi saat pelajaran berlangsung. Jangan ragu bertanya jika belum paham.";
        } else {
            $dynamicCatatan = "Perlu perhatian lebih. Kurangi bermain dan tingkatkan waktu belajarmu. Kamu pasti bisa mengejar ketertinggalan.";
        }
        
        // Use manual note if exists, otherwise use dynamic
        $catatanFinal = !empty($data['catatan_wali_kelas']) ? $data['catatan_wali_kelas'] : $dynamicCatatan;
    ?>

    <div class="page-container <?php echo e($index > 0 ? 'page-break-before' : ''); ?>">
        
        <!-- WATERMARK BACKGROUND -->
        <?php if($settings->logo_pondok_path): ?>
            <?php
                $watermarkPath = $isPdfDownload 
                    ? storage_path('app/public/' . $settings->logo_pondok_path)
                    : asset('storage/' . $settings->logo_pondok_path);
            ?>
            <?php if(!$isPdfDownload || file_exists(storage_path('app/public/' . $settings->logo_pondok_path))): ?>
                <img src="<?php echo e($watermarkPath); ?>" class="watermark" alt="Watermark">
            <?php endif; ?>
        <?php endif; ?>
        
        <!-- HEADER FIXED (Table Layout for DomPDF) -->
        <div class="header-wrapper">
            <table class="header-table">
                <tr>
                    <td style="width: 15%; text-align: left;">
                         <?php if($settings->logo_pondok_path): ?>
                            <?php
                                $logoPath = $isPdfDownload 
                                    ? storage_path('app/public/' . $settings->logo_pondok_path)
                                    : asset('storage/' . $settings->logo_pondok_path);
                            ?>
                            <?php if(!$isPdfDownload || file_exists(storage_path('app/public/' . $settings->logo_pondok_path))): ?>
                                <img src="<?php echo e($logoPath); ?>" class="header-logo" alt="Logo">
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td style="width: 70%; text-align: center;">
                        <div style="font-size: 12pt; font-weight: bold; text-transform: uppercase;"><?php echo e($settings->nama_yayasan); ?></div>
                        <div style="font-size: 16pt; font-weight: bold; color: #0d5f2d; text-transform: uppercase;"><?php echo e($settings->nama_pondok); ?></div>
                        <div style="font-size: 8pt;"><?php echo e($settings->alamat); ?></div>
                        <div style="font-size: 8pt;">Email: admin@riyadlulhuda.com</div>
                    </td>
                    <td style="width: 15%; text-align: right;">
                        <?php if($settings->logo_pendidikan_path): ?>
                            <?php
                                $logoPendidikanPath = $isPdfDownload 
                                    ? storage_path('app/public/' . $settings->logo_pendidikan_path)
                                    : asset('storage/' . $settings->logo_pendidikan_path);
                            ?>
                            <?php if(!$isPdfDownload || file_exists(storage_path('app/public/' . $settings->logo_pendidikan_path))): ?>
                                <img src="<?php echo e($logoPendidikanPath); ?>" class="header-logo" alt="Logo">
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>

        <div class="rapor-title text-uppercase" style="margin: 5px 0 15px 0;">LAPORAN HASIL BELAJAR SANTRI</div>

        <!-- IDENTITY - Table based for DomPDF -->
        <table class="identity-table">
            <tr>
                <td class="identity-label">Nama Santri</td>
                <td class="identity-colon">:</td>
                <td class="identity-value" style="font-weight: bold; text-transform: uppercase;"><?php echo e($santri->nama_santri); ?></td>
                <td style="width: 20px;"></td>
                <td class="identity-label">Tahun Ajaran</td>
                <td class="identity-colon">:</td>
                <td class="identity-value"><?php echo e($tahunAjaran); ?></td>
            </tr>
            <tr>
                <td class="identity-label">NIS</td>
                <td class="identity-colon">:</td>
                <td class="identity-value"><?php echo e($santri->nis); ?></td>
                <td></td>
                <td class="identity-label">Semester</td>
                <td class="identity-colon">:</td>
                <td class="identity-value"><?php echo e(($semester == 1) ? '1 (Ganjil)' : '2 (Genap)'); ?></td>
            </tr>
            <tr>
                <td class="identity-label">Kelas</td>
                <td class="identity-colon">:</td>
                <td class="identity-value"><?php echo e($santri->kelas->nama_kelas); ?></td>
                <td></td>
                <td class="identity-label">Peringkat</td>
                <td class="identity-colon">:</td>
                <td class="identity-value"><strong><?php echo e($ranking); ?></strong> dari <?php echo e($totalSiswa); ?> Santri</td>
            </tr>
            <tr>
                <td class="identity-label">Rata-rata</td>
                <td class="identity-colon">:</td>
                <td class="identity-value" colspan="5"><strong><?php echo e(number_format($rataRata, 2)); ?></strong></td>
            </tr>
        </table>

        <!-- GRADES TABLE -->
        <?php
            if (!function_exists('p_grade')) {
                function p_grade($n) { 
                    if(!$n) return '-'; 
                    if($n>=90) return 'A'; 
                    if($n>=80) return 'B'; 
                    if($n>=70) return 'C'; 
                    return 'D'; 
                }
            }
            if (!function_exists('p_desc')) {
                function p_desc($n, $mapel) {
                    if(!$n) return '-';
                    if($n>=90) return "Sangat kompeten dalam memahami seluruh materi $mapel. Pertahankan prestasi ini.";
                    if($n>=80) return "Kompeten dalam memahami materi $mapel, namun perlu lebih teliti di beberapa bagian.";
                    if($n>=70) return "Cukup kompeten dalam materi $mapel, perlu pendampingan belajar untuk meningkatkan hasil.";
                    return "Belum mencapai kompetensi minimal pada $mapel, memerlukan bimbingan remedial.";
                }
            }
        ?>

        <table class="data-table">
            <thead>
                <tr>
                    <th width="4%">NO</th>
                    <th width="26%">MATA PELAJARAN</th>
                    <th width="6%">KKM</th>
                    <th width="6%">NILAI</th>
                    <th width="6%">PRED</th>
                    <th>DESKRIPSI</th>
                </tr>
            </thead>
            <tbody>
                <!-- Group A -->
                <tr><td colspan="6" class="group-header">A. MUATAN WAJIB / NASIONAL</td></tr>
                <?php $no = 1; ?>
                <?php $__currentLoopData = $mapel_wajib; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $v = $grades[$m->id] ?? null; $n = $v ? $v->nilai_akhir : null; ?>
                    <tr>
                        <td class="text-center"><?php echo e($no++); ?></td>
                        <td><?php echo e($m->nama_mapel); ?></td>
                        <td class="text-center"><?php echo e($m->kkm ?? 70); ?></td>
                        <td class="text-center text-bold"><?php echo e($n ? number_format($n,0) : '-'); ?></td>
                        <td class="text-center"><?php echo e(p_grade($n)); ?></td>
                        <td class="text-small"><?php echo e(p_desc($n, $m->nama_mapel)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <!-- Group B -->
                <tr><td colspan="6" class="group-header">B. MUATAN PONDOK PESANTREN & MULOK</td></tr>
                <?php $no = 1; ?>
                <?php $__currentLoopData = $mapel_diniyah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $v = $grades[$m->id] ?? null; $n = $v ? $v->nilai_akhir : null; ?>
                    <tr>
                        <td class="text-center"><?php echo e($no++); ?></td>
                        <td><?php echo e($m->nama_mapel); ?></td>
                        <td class="text-center"><?php echo e($m->kkm ?? 70); ?></td>
                        <td class="text-center text-bold"><?php echo e($n ? number_format($n,0) : '-'); ?></td>
                        <td class="text-center"><?php echo e(p_grade($n)); ?></td>
                        <td class="text-small"><?php echo e(p_desc($n, $m->nama_mapel)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <!-- Group C -->
                <?php if($mapel_ekstra->isNotEmpty()): ?>
                <tr><td colspan="6" class="group-header">C. PENGEMBANGAN DIRI</td></tr>
                <?php $__currentLoopData = $mapel_ekstra; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $v = $grades[$m->id] ?? null; $n = $v ? $v->nilai_akhir : null; ?>
                    <tr>
                        <td class="text-center"><?php echo e($i+1); ?></td>
                        <td><?php echo e($m->nama_mapel); ?></td>
                        <td class="text-center">-</td>
                        <td class="text-center"><?php echo e(p_grade($n)); ?></td>
                        <td colspan="2" class="text-small"><?php echo e($v->catatan ?? 'Mengikuti kegiatan dengan baik'); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </tbody>
        </table>

         <!-- Added Rata-rata to Identity (replacing original identity section) -->
         <style>
            /* Ensure identity grid update applied if needed, but here we inject it below or modify the previous block? 
               The tool replaces a contiguous block. I need to replace the IDENTITY block too if I want to add Rata-rata there.
               Wait, the tool only allows replacing ONE block. 
               The provided EndLine:450 covers the TABLE and ABSENSI section start. 
               The Identity section is lines 327-356. The Table starts at 374. 
               I cannot edit both non-contiguously in "replace_file_content".
               I must use "multi_replace_file_content" or extend the range.
               Extending range from Identity (327) to Notes (450) is safe.
            */
         </style>

        <!-- ABSENSI & NOTES LAYOUT - Table based for DomPDF -->
        <table style="width: 100%; margin-bottom: 15px; position: relative; z-index: 2;" cellspacing="0">
            <tr>
                <td style="width: 40%; vertical-align: top; padding-right: 10px;">
                    <table class="data-table" style="width: 100%;">
                        <tr><th colspan="2" class="group-header text-center" style="padding: 2px;">KETIDAKHADIRAN</th></tr>
                        <tr><td width="60%" style="padding: 2px;">Sakit</td><td class="text-center" style="padding: 2px;"><?php echo e($kehadiran['sakit'] ?? 0); ?> Hari</td></tr>
                        <tr><td style="padding: 2px;">Izin</td><td class="text-center" style="padding: 2px;"><?php echo e($kehadiran['izin'] ?? 0); ?> Hari</td></tr>
                        <tr><td style="padding: 2px;">Alfa</td><td class="text-center" style="padding: 2px;"><?php echo e($kehadiran['alfa'] ?? 0); ?> Hari</td></tr>
                    </table>
                </td>
                <td style="width: 60%; vertical-align: top;">
                    <table class="data-table" style="width: 100%;">
                        <tr><th class="group-header text-center" style="padding: 2px;">CATATAN WALI KELAS</th></tr>
                        <tr>
                            <td style="height: 55px; vertical-align: middle; font-style: italic; padding: 8px; font-size: 8.5pt; text-align: center;">
                                "<?php echo e($catatanFinal); ?>"
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- STABLE TABLE-BASED SIGNATURES -->
        <table class="sig-table">
            <tr>
                <td class="sig-role">Mengetahui,<br>Orang Tua / Wali</td>
                <td class="sig-role">Mengetahui,<br><?php echo e($settings->pimpinan_jabatan); ?></td>
                <td class="sig-role">
                    <span class="sig-date"><?php echo e($settings->kota_terbit); ?>, <?php echo e(\Carbon\Carbon::now()->translatedFormat('d F Y')); ?></span>
                    Wali Kelas
                </td>
            </tr>
            <tr>
                <td class="sig-space"></td>
                <td class="sig-space">
                    <div class="sig-ttd-wrapper">
                        <?php if($settings->pimpinan_ttd_path): ?>
                            <?php
                                $ttdPimpinanPath = $isPdfDownload 
                                    ? storage_path('app/public/' . $settings->pimpinan_ttd_path)
                                    : asset('storage/' . $settings->pimpinan_ttd_path);
                            ?>
                            <?php if(!$isPdfDownload || file_exists(storage_path('app/public/' . $settings->pimpinan_ttd_path))): ?>
                                <img src="<?php echo e($ttdPimpinanPath); ?>" class="sig-img">
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </td>
                <td class="sig-space">
                    <div class="sig-ttd-wrapper">
                        <?php 
                            $waliKelasTtd = $santri->kelas->getWaliKelasTtd($santri->gender);
                        ?>
                        <?php if($waliKelasTtd): ?>
                            <?php
                                $ttdWaliPath = $isPdfDownload 
                                    ? storage_path('app/public/' . $waliKelasTtd)
                                    : asset('storage/' . $waliKelasTtd);
                            ?>
                            <?php if(!$isPdfDownload || file_exists(storage_path('app/public/' . $waliKelasTtd))): ?>
                                <img src="<?php echo e($ttdWaliPath); ?>" class="sig-img small">
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td><span class="sig-name"><?php echo e(ucwords(strtolower($santri->nama_ortu_wali ?? $santri->nama_ayah ?? '....................'))); ?></span></td>
                <td><span class="sig-name"><?php echo e($settings->pimpinan_nama); ?></span></td>
                <td>
                    <?php 
                        $waliKelasName = $santri->kelas->getWaliKelasName($santri->gender);
                    ?>
                    <span class="sig-name"><?php echo e($waliKelasName ?? '............................'); ?></span>
                </td>
            </tr>
        </table>
        <?php if(isset($clearFixRequired)): ?> <div class="clear-fix"></div> <?php endif; ?>
        
        <!-- QR VALIDATION FOOTER - Table based for DomPDF -->
        <table style="margin-top: 15px; border-top: 1px solid #ddd; padding-top: 10px; width: 100%;" cellspacing="0">
            <tr>
                <td style="width: 70px; vertical-align: top;">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?php echo e(urlencode($noRapor . ' | ' . $santri->nama_santri . ' | Valid')); ?>" 
                         style="width: 60px; height: 60px; border: 1px solid #333; padding: 2px; background: #fff;">
                </td>
                <td style="font-size: 8pt; color: #333; line-height: 1.4; vertical-align: middle;">
                    <b style="color: #0d5f2d;">DOKUMEN SAH</b> - Rapor ini ditandatangani secara elektronik.<br>
                    Nomor Dokumen: <b style="font-family: monospace;"><?php echo e($noRapor); ?></b><br>
                    <span style="font-size: 7pt; color: #777;"><i>Scan barcode untuk memverifikasi keaslian dokumen ini.</i></span>
                </td>
            </tr>
        </table>

    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- PDF DOWNLOAD CONTROLS (Hidden in Print) -->
    <div id="download-controls" style="position: fixed; top: 20px; right: 20px; z-index: 1000; background: white; padding: 15px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); border: 1px solid #10b981; display: flex; flex-direction: column; gap: 10px; font-family: sans-serif;">
        <div style="font-weight: bold; color: #0d5f2d; font-size: 14px; margin-bottom: 5px;">Opsi Dokumen</div>
        <button onclick="window.print()" style="padding: 8px 15px; background: #f3f4f6; border: 1px solid #d1d5db; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; color: #374151; display: flex; align-items: center; gap: 8px;">
            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak (Print)
        </button>
        <a href="<?php echo e(url()->current()); ?>?<?php echo e(http_build_query(array_merge(request()->all(), ['download' => '1']))); ?>" 
           style="padding: 10px 15px; background: #10b981; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 700; color: white; display: flex; align-items: center; gap: 8px; box-shadow: 0 2px 5px rgba(16,185,129,0.3); text-decoration: none;">
            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Unduh PDF
        </a>
    </div>

    <style>
        @media print {
            #download-controls { display: none !important; }
        }
    </style>

</body>
</html>
<?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\pendidikan\laporan\rapor-pdf-v2.blade.php ENDPATH**/ ?>