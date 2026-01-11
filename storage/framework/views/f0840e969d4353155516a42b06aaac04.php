

<?php $__env->startSection('title', 'Laporan'); ?>
<?php $__env->startSection('page-title', 'Laporan Keuangan'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('bendahara.partials.sidebar-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Header Banner -->
    <div style="background: linear-gradient(135deg, #3f51b5 0%, #1a237e 100%); border-radius: 20px; padding: 40px; margin-bottom: 32px; box-shadow: 0 20px 40px rgba(63, 81, 181, 0.25); position: relative; overflow: hidden; color: white;">
        <div style="position: absolute; top: -50px; right: -50px; width: 250px; height: 250px; background: rgba(255,255,255,0.1); border-radius: 50%; filter: blur(40px);"></div>
        <div style="position: absolute; bottom: -30px; left: 15%; width: 150px; height: 150px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        
        <div style="position: relative; z-index: 2; display: flex; align-items: center; gap: 24px;">
            <div style="background: rgba(255,255,255,0.2); width: 72px; height: 72px; border-radius: 18px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.3);">
                <i data-feather="file-text" style="width: 36px; height: 36px; color: white;"></i>
            </div>
            <div>
                <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 6px; letter-spacing: -0.025em;">Laporan Keuangan</h2>
                <p style="font-size: 1.1rem; opacity: 0.95; font-weight: 400;">Ekspor data keuangan pesantren secara komprehensif dan akurat.</p>
            </div>
        </div>
        <div style="position: absolute; right: 40px; bottom: -20px; opacity: 0.15;">
            <i data-feather="printer" style="width: 180px; height: 180px; transform: rotate(-15deg);"></i>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; align-items: stretch;">
        <!-- Laporan Syahriah -->
        <div style="background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; overflow: hidden; display: flex; flex-direction: column;">
            <div style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9; background: linear-gradient(to right, #f8fafc, white); display: flex; align-items: center; gap: 12px;">
                <div style="width: 36px; height: 36px; background: #ecfdf5; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-feather="dollar-sign" style="width: 18px; height: 18px; color: #10b981;"></i>
                </div>
                <h3 style="font-size: 1rem; font-weight: 800; color: #1e2937;">Laporan Syahriah</h3>
            </div>
            <div style="padding: 24px; flex: 1; display: flex; flex-direction: column;">
                <p style="font-size: 0.875rem; color: #64748b; margin-bottom: 20px; line-height: 1.5;">
                    Laporan pembayaran syahriah santri per periode dengan status lunas/belum lunas.
                </p>
                <form method="GET" action="<?php echo e(route('bendahara.laporan.export-syahriah')); ?>" target="_blank" style="margin-top: auto;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px;">Tahun</label>
                            <input type="number" name="tahun" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.875rem;" value="<?php echo e(date('Y')); ?>">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px;">Bulan</label>
                            <select name="bulan" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.875rem;">
                                <option value="">Semua</option>
                                <?php for($i = 1; $i <= 12; $i++): ?>
                                    <option value="<?php echo e($i); ?>"><?php echo e(date('M', mktime(0, 0, 0, $i, 1))); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" style="width: 100%; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 12px; border-radius: 12px; font-weight: 700; border: none; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; transition: all 0.3s; box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                        <i data-feather="download" style="width: 16px; height: 16px;"></i>
                        Export Laporan
                    </button>
                </form>
            </div>
        </div>

        <!-- Laporan Pemasukan -->
        <div style="background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; overflow: hidden; display: flex; flex-direction: column;">
            <div style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9; background: linear-gradient(to right, #f8fafc, white); display: flex; align-items: center; gap: 12px;">
                <div style="width: 36px; height: 36px; background: #eff6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-feather="plus-circle" style="width: 18px; height: 18px; color: #3b82f6;"></i>
                </div>
                <h3 style="font-size: 1rem; font-weight: 800; color: #1e2937;">Laporan Pemasukan</h3>
            </div>
            <div style="padding: 24px; flex: 1; display: flex; flex-direction: column;">
                <p style="font-size: 0.875rem; color: #64748b; margin-bottom: 20px; line-height: 1.5;">
                    Laporan pemasukan berdasarkan kategori dan periode tertentu.
                </p>
                <form method="GET" action="<?php echo e(route('bendahara.laporan.export-pemasukan')); ?>" target="_blank" style="margin-top: auto;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px;">Mulai</label>
                            <input type="date" name="tanggal_mulai" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.875rem;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px;">Selesai</label>
                            <input type="date" name="tanggal_selesai" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.875rem;">
                        </div>
                    </div>
                    <button type="submit" style="width: 100%; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 12px; border-radius: 12px; font-weight: 700; border: none; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; transition: all 0.3s; box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                        <i data-feather="download" style="width: 16px; height: 16px;"></i>
                        Export Laporan
                    </button>
                </form>
            </div>
        </div>

        <!-- Laporan Pengeluaran -->
        <div style="background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; overflow: hidden; display: flex; flex-direction: column;">
            <div style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9; background: linear-gradient(to right, #f8fafc, white); display: flex; align-items: center; gap: 12px;">
                <div style="width: 36px; height: 36px; background: #fff1f2; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-feather="minus-circle" style="width: 18px; height: 18px; color: #ef4444;"></i>
                </div>
                <h3 style="font-size: 1rem; font-weight: 800; color: #1e2937;">Laporan Pengeluaran</h3>
            </div>
            <div style="padding: 24px; flex: 1; display: flex; flex-direction: column;">
                <p style="font-size: 0.875rem; color: #64748b; margin-bottom: 20px; line-height: 1.5;">
                    Laporan pengeluaran berdasarkan kategori dan periode tertentu.
                </p>
                <form method="GET" action="<?php echo e(route('bendahara.laporan.export-pengeluaran')); ?>" target="_blank" style="margin-top: auto;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px;">Mulai</label>
                            <input type="date" name="tanggal_mulai" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.875rem;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px;">Selesai</label>
                            <input type="date" name="tanggal_selesai" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.875rem;">
                        </div>
                    </div>
                    <button type="submit" style="width: 100%; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 12px; border-radius: 12px; font-weight: 700; border: none; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; transition: all 0.3s; box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                        <i data-feather="download" style="width: 16px; height: 16px;"></i>
                        Export Laporan
                    </button>
                </form>
            </div>
        </div>

        <!-- Laporan Kas -->
        <div style="background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; overflow: hidden; display: flex; flex-direction: column;">
            <div style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9; background: linear-gradient(to right, #f8fafc, white); display: flex; align-items: center; gap: 12px;">
                <div style="width: 36px; height: 36px; background: #ecfdf5; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-feather="database" style="width: 18px; height: 18px; color: #10b981;"></i>
                </div>
                <h3 style="font-size: 1rem; font-weight: 800; color: #1e2937;">Laporan Arus Kas</h3>
            </div>
            <div style="padding: 24px; flex: 1; display: flex; flex-direction: column;">
                <p style="font-size: 0.875rem; color: #64748b; margin-bottom: 20px; line-height: 1.5;">
                    Laporan arus kas (pemasukan - pengeluaran) per periode.
                </p>
                <form method="GET" action="<?php echo e(route('bendahara.laporan.export-kas')); ?>" target="_blank" style="margin-top: auto;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px;">Mulai</label>
                            <input type="date" name="tanggal_mulai" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.875rem;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px;">Selesai</label>
                            <input type="date" name="tanggal_selesai" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.875rem;">
                        </div>
                    </div>
                    <button type="submit" style="width: 100%; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 12px; border-radius: 12px; font-weight: 700; border: none; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; transition: all 0.3s; box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                        <i data-feather="download" style="width: 16px; height: 16px;"></i>
                        Export Laporan
                    </button>
                </form>
            </div>
        </div>

        <!-- Laporan Gaji -->
        <div style="background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; overflow: hidden; display: flex; flex-direction: column;">
            <div style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9; background: linear-gradient(to right, #f8fafc, white); display: flex; align-items: center; gap: 12px;">
                <div style="width: 36px; height: 36px; background: #eef2ff; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-feather="users" style="width: 18px; height: 18px; color: #6366f1;"></i>
                </div>
                <h3 style="font-size: 1rem; font-weight: 800; color: #1e2937;">Gaji Pegawai</h3>
            </div>
            <div style="padding: 24px; flex: 1; display: flex; flex-direction: column;">
                <p style="font-size: 0.875rem; color: #64748b; margin-bottom: 20px; line-height: 1.5;">
                    Laporan pembayaran gaji pegawai per bulan/tahun.
                </p>
                <form method="GET" action="<?php echo e(route('bendahara.laporan.export-gaji')); ?>" target="_blank" style="margin-top: auto;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px;">Tahun</label>
                            <input type="number" name="tahun" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.875rem;" value="<?php echo e(date('Y')); ?>">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px;">Bulan</label>
                            <select name="bulan" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.875rem;">
                                <option value="">Semua</option>
                                <?php for($i = 1; $i <= 12; $i++): ?>
                                    <option value="<?php echo e($i); ?>"><?php echo e(date('M', mktime(0, 0, 0, $i, 1))); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" style="width: 100%; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 12px; border-radius: 12px; font-weight: 700; border: none; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; transition: all 0.3s; box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                        <i data-feather="download" style="width: 16px; height: 16px;"></i>
                        Export Laporan
                    </button>
                </form>
            </div>
        </div>

        <!-- Laporan Keuangan Lengkap -->
        <div style="background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; overflow: hidden; display: flex; flex-direction: column;">
            <div style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9; background: linear-gradient(to right, #f8fafc, white); display: flex; align-items: center; gap: 12px;">
                <div style="width: 36px; height: 36px; background: #fdf2f8; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-feather="briefcase" style="width: 18px; height: 18px; color: #db2777;"></i>
                </div>
                <h3 style="font-size: 1rem; font-weight: 800; color: #1e2937;">Laporan Lengkap</h3>
            </div>
            <div style="padding: 24px; flex: 1; display: flex; flex-direction: column;">
                <p style="font-size: 0.875rem; color: #64748b; margin-bottom: 20px; line-height: 1.5;">
                    Laporan keuangan komprehensif dengan semua transaksi.
                </p>
                <form method="GET" action="<?php echo e(route('bendahara.laporan.export-keuangan-lengkap')); ?>" target="_blank" style="margin-top: auto;">
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px;">Tahun</label>
                        <input type="number" name="tahun" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.875rem;" value="<?php echo e(date('Y')); ?>">
                    </div>
                    <button type="submit" style="width: 100%; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 12px; border-radius: 12px; font-weight: 700; border: none; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; transition: all 0.3s; box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                        <i data-feather="download" style="width: 16px; height: 16px;"></i>
                        Export Laporan
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\bendahara\laporan.blade.php ENDPATH**/ ?>