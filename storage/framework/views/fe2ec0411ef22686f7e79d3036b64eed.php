

<?php $__env->startSection('title', 'Hasil Cek Tunggakan'); ?>
<?php $__env->startSection('page-title', 'Hasil Cek Tunggakan'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('bendahara.partials.sidebar-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<style>
    @media print {
        @page { size: A4; margin: 1cm; }
        body { background: white; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        .sidebar, .page-header, .no-print { display: none !important; }
        .main-content { margin: 0 !important; padding: 0 !important; }
        .container-fluid { padding: 0 !important; }
        .card { box-shadow: none !important; border: 1px solid #ddd !important; break-inside: avoid; }
        .btn, a[href] { display: none !important; }
        /* Show only necessary info */
        .print-header { display: block !important; margin-bottom: 20px; text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; }
    }
    .print-header { display: none; }
</style>

<div class="print-header">
    <h3>Laporan Status Keuangan Santri</h3>
    <h2>Riyadlul Huda</h2>
    <p><?php echo e(now()->format('d F Y H:i')); ?></p>
</div>

<div class="container-fluid" style="padding: 20px;">
    <!-- Header -->
    <div style="margin-bottom: 24px;" class="no-print">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <a href="<?php echo e(route('bendahara.cek-tunggakan')); ?>" style="color: #64748b; text-decoration: none; font-weight: 600; font-size: 14px; margin-bottom: 12px; display: inline-block;">
                    <i class="fas fa-arrow-left" style="margin-right: 6px;"></i> Kembali ke Pencarian
                </a>
                <h1 style="font-size: 24px; font-weight: 700; color: #1e293b; margin-bottom: 8px;">Hasil Pengecekan Tunggakan</h1>
            </div>
            <div style="display: flex; gap: 12px;">
                <?php if(count($tunggakanList) > 0 && $santri->no_hp_ortu_wali): ?>
                <?php
                    // Format phone number (remove leading 0, add 62)
                    $phone = $santri->no_hp_ortu_wali;
                    $phone = preg_replace('/[^0-9]/', '', $phone); // Remove non-numeric
                    if (substr($phone, 0, 1) === '0') {
                        $phone = '62' . substr($phone, 1);
                    } elseif (substr($phone, 0, 2) !== '62') {
                        $phone = '62' . $phone;
                    }
                    
                    // Build invoice message
                    $bulanList = collect($tunggakanList)->pluck('label')->implode(', ');
                    $message = "Assalamu'alaikum Wr. Wb.\n\n";
                    $message .= "Yth. Wali dari Ananda *{$santri->nama_santri}*\n";
                    $message .= "NIS: {$santri->nis}\n";
                    $message .= "Kelas: " . ($santri->kelas->nama_kelas ?? '-') . "\n\n";
                    $message .= "Kami informasikan bahwa terdapat *tunggakan Syahriah* yang belum terbayarkan:\n\n";
                    $message .= "📅 *Bulan:* {$bulanList}\n";
                    $message .= "💰 *Total Tunggakan:* Rp " . number_format($totalTunggakan, 0, ',', '.') . "\n\n";
                    $message .= "Mohon untuk dapat melunasi pembayaran melalui Bendahara Pondok Pesantren Riyadlul Huda.\n\n";
                    $message .= "Jazakumullahu Khairan.\n";
                    $message .= "_Bendahara PP Riyadlul Huda_";
                    
                    $waLink = "https://wa.me/{$phone}?text=" . urlencode($message);
                ?>
                <a href="<?php echo e($waLink); ?>" target="_blank" style="background: linear-gradient(135deg, #25D366 0%, #128C7E 100%); color: white; padding: 10px 20px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; text-decoration: none;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Kirim Tagihan via WA
                </a>
                <?php endif; ?>
                <button onclick="window.print()" style="background-color: #0f172a; color: white; padding: 10px 20px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-print"></i> Cetak Laporan
                </button>
            </div>
        </div>
    </div>

    <!-- ... (Rest of Layout) ... -->
    <div class="row">
        <!-- Sidebar - Profil Santri -->
        <div class="col-md-4 mb-4">
            <!-- ... Keep Profil Santri ... -->
            <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); background-color: #fff; height: 100%;">
                <div class="card-body" style="padding: 24px;">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <div style="width: 80px; height: 80px; background-color: #e0e7ff; color: #4f46e5; border-radius: 50%; font-size: 32px; font-weight: 700; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                            <?php echo e(substr($santri->nama_santri, 0, 1)); ?>

                        </div>
                        <h3 style="font-size: 18px; font-weight: 700; color: #1e293b; margin-bottom: 4px;"><?php echo e($santri->nama_santri); ?></h3>
                        <p style="color: #64748b; font-size: 14px; margin: 0;"><?php echo e($santri->nis); ?></p>
                    </div>
                    
                    <hr style="border-top: 1px solid #e2e8f0; margin: 20px 0;">
                    
                    <div style="margin-bottom: 12px;">
                        <span style="display: block; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Kelas</span>
                        <span style="font-size: 16px; font-weight: 600; color: #334155;"><?php echo e($santri->kelas->nama_kelas ?? '-'); ?></span>
                    </div>
                    <div style="margin-bottom: 12px;">
                        <span style="display: block; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Asrama</span>
                        <span style="font-size: 16px; font-weight: 600; color: #334155;"><?php echo e($santri->asrama->nama_asrama ?? '-'); ?></span>
                    </div>
                    <div style="margin-bottom: 24px;">
                        <span style="display: block; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Mulai Masuk (Start Tagihan)</span>
                        <span style="font-size: 16px; font-weight: 600; color: #334155;">
                            <?php echo e($santri->tanggal_masuk ? $santri->tanggal_masuk->format('d F Y') : $santri->created_at->format('d F Y')); ?>

                        </span>
                        <?php if(!$santri->tanggal_masuk): ?>
                            <div style="margin-top: 4px; padding: 6px; background-color: #fffbeb; border-radius: 6px; border: 1px solid #fcd34d;">
                                <small style="display: block; line-height: 1.4; color: #92400e;">
                                    <i class="fas fa-info-circle"></i> Info: Menggunakan tanggal input data.
                                </small>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div style="background-color: #fef2f2; padding: 20px; border-radius: 12px; border: 1px solid #fecaca; text-align: center;">
                        <span style="display: block; font-size: 12px; font-weight: 600; color: #991b1b; text-transform: uppercase; margin-bottom: 4px;">Total Tunggakan</span>
                        <span style="display: block; font-size: 24px; font-weight: 800; color: #dc2626;">Rp <?php echo e(number_format($totalTunggakan, 0, ',', '.')); ?></span>
                        <small style="color: #b91c1c; font-weight: 500;"><?php echo e(count($tunggakanList)); ?> Bulan Belum Lunas</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content - List Tunggakan -->
        <div class="col-md-8">
            <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); background-color: #fff;">
                <div class="card-header" style="background-color: transparent; border-bottom: 1px solid #e2e8f0; padding: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 style="font-size: 18px; font-weight: 700; color: #1e293b; margin: 0;">Rincian Bulan Belum Lunas</h4>
                        <span style="font-size: 14px; font-weight: 600; color: #64748b;">
                            Biaya/Bulan: Rp <?php echo e(number_format($biayaBulanan, 0, ',', '.')); ?>

                        </span>
                    </div>
                </div>
                <div class="card-body" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="table" style="width: 100%; margin: 0;">
                            <thead style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                                <tr>
                                    <th style="padding: 16px 20px; font-weight: 600; color: #475569; width: 50px;">No</th>
                                    <th style="padding: 16px 20px; font-weight: 600; color: #475569;">Bulan / Tahun</th>
                                    <th style="padding: 16px 20px; font-weight: 600; color: #475569;">Tagihan</th>
                                    <th style="padding: 16px 20px; font-weight: 600; color: #475569;">Status</th>
                                    <th style="padding: 16px 20px; font-weight: 600; color: #475569; text-align: right;" class="no-print">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $tunggakanList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="padding: 16px 20px; color: #334155;"><?php echo e($index + 1); ?></td>
                                        <td style="padding: 16px 20px; font-weight: 600; color: #334155;"><?php echo e($item['label']); ?></td>
                                        <td style="padding: 16px 20px; color: #ef4444; font-weight: 600;">
                                            Rp <?php echo e(number_format($item['tagihan'], 0, ',', '.')); ?>

                                        </td>
                                        <td style="padding: 16px 20px;">
                                            <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; background-color: #fee2e2; color: #991b1b;">
                                                Belum Lunas
                                            </span>
                                        </td>
                                        <td style="padding: 16px 20px; text-align: right;" class="no-print">
                                            <a href="<?php echo e(route('bendahara.syahriah')); ?>" style="display: inline-block; padding: 6px 12px; border-radius: 6px; background-color: #4f46e5; color: white; text-decoration: none; font-size: 13px; font-weight: 600;">
                                                Bayar
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" style="text-align: center; padding: 60px;">
                                            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                                <div style="width: 72px; height: 72px; background-color: #dcfce7; border-radius: 50%; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 32px; margin-bottom: 16px; box-shadow: 0 4px 6px -1px rgba(22, 163, 74, 0.2);">
                                                    <i class="fas fa-check-double"></i>
                                                </div>
                                                <h4 style="font-size: 20px; font-weight: 700; color: #1e293b; margin-bottom: 8px;">Alhamdulillah!</h4>
                                                <p style="color: #64748b; margin: 0; font-size: 16px;">
                                                    Santri <strong><?php echo e($santri->nama_santri); ?></strong> tidak memiliki tunggakan.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\bendahara\cek-tunggakan\result.blade.php ENDPATH**/ ?>