

<?php $__env->startSection('title', 'Pengaturan Rapor'); ?>
<?php $__env->startSection('page-title', 'Pengaturan Rapor Digital'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('pendidikan.partials.sidebar-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <?php if(session('success')): ?>
        <div class="alert alert-success" style="background-color: #d1e7dd; color: #0f5132; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <i data-feather="check-circle" style="width: 18px; vertical-align: text-bottom;"></i> <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>

        <div class="card" style="background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: none; overflow: hidden;">
            <div class="card-header" style="background: #f8fafc; padding: 20px; border-bottom: 1px solid #e2e8f0;">
                <h5 style="margin: 0; font-weight: 600; color: #1e293b;">Identitas & Kop Rapor</h5>
                <p style="margin: 5px 0 0; color: #64748b; font-size: 0.9rem;">Atur identitas pondok, logo, dan tanda tangan default.</p>
            </div>
            <div class="card-body" style="padding: 25px;">
                <form action="<?php echo e(route('pendidikan.settings.update')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Identitas -->
                        <div class="col-span-1">
                            <h6 style="color: #3b82f6; font-weight: 600; margin-bottom: 15px; border-bottom: 2px solid #3b82f6; padding-bottom: 5px; display: inline-block;">Identitas Instansi</h6>
                            
                            <div class="form-group mb-4">
                                <label class="form-label" style="font-weight: 500; margin-bottom: 5px; display: block;">Nama Yayasan (Kop Atas)</label>
                                <input type="text" name="nama_yayasan" class="form-control" value="<?php echo e($settings->nama_yayasan); ?>" required
                                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" style="font-weight: 500; margin-bottom: 5px; display: block;">Nama Pondok / Sekolah (Kop Utama)</label>
                                <input type="text" name="nama_pondok" class="form-control" value="<?php echo e($settings->nama_pondok); ?>" required
                                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" style="font-weight: 500; margin-bottom: 5px; display: block;">Alamat Lengkap</label>
                                <textarea name="alamat" class="form-control" rows="2"
                                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;"><?php echo e($settings->alamat); ?></textarea>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" style="font-weight: 500; margin-bottom: 5px; display: block;">Kontak / Telepon</label>
                                <input type="text" name="telepon" class="form-control" value="<?php echo e($settings->telepon); ?>"
                                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                            </div>
                            
                            <div class="form-group mb-4">
                                <label class="form-label" style="font-weight: 500; margin-bottom: 5px; display: block;">Kota Terbit Rapor</label>
                                <input type="text" name="kota_terbit" class="form-control" value="<?php echo e($settings->kota_terbit); ?>" required
                                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                            </div>
                        </div>

                        <!-- Logo & TTD -->
                        <div class="col-span-1">
                            <h6 style="color: #3b82f6; font-weight: 600; margin-bottom: 15px; border-bottom: 2px solid #3b82f6; padding-bottom: 5px; display: inline-block;">Logo & Validasi</h6>

                            <div class="flex gap-4 mb-4">
                                <div style="flex: 1;">
                                    <label class="form-label" style="font-weight: 500; margin-bottom: 5px; display: block;">Logo Pondok (Kiri)</label>
                                    <?php if($settings->logo_pondok_path): ?>
                                        <div class="mb-2 p-2 border rounded bg-gray-50 text-center">
                                            <img src="<?php echo e(asset('storage/' . $settings->logo_pondok_path)); ?>" alt="Logo Pondok" style="height: 60px; object-fit: contain;">
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" name="logo_pondok" class="form-control" accept="image/*"
                                        style="font-size: 12px;">
                                </div>
                                <div style="flex: 1;">
                                    <label class="form-label" style="font-weight: 500; margin-bottom: 5px; display: block;">Logo Pendidikan (Kanan)</label>
                                    <?php if($settings->logo_pendidikan_path): ?>
                                        <div class="mb-2 p-2 border rounded bg-gray-50 text-center">
                                            <img src="<?php echo e(asset('storage/' . $settings->logo_pendidikan_path)); ?>" alt="Logo Pendidikan" style="height: 60px; object-fit: contain;">
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" name="logo_pendidikan" class="form-control" accept="image/*"
                                        style="font-size: 12px;">
                                </div>
                            </div>

                            <hr style="border-top: 1px dashed #cbd5e1; margin: 20px 0;">

                            <h6 style="color: #3b82f6; font-weight: 600; margin-bottom: 15px; border-bottom: 2px solid #3b82f6; padding-bottom: 5px; display: inline-block;">Pimpinan Umum</h6>
                            
                            <div class="form-group mb-4">
                                <label class="form-label" style="font-weight: 500; margin-bottom: 5px; display: block;">Nama Pimpinan</label>
                                <input type="text" name="pimpinan_nama" class="form-control" value="<?php echo e($settings->pimpinan_nama); ?>" required
                                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                            </div>
                            
                            <div class="form-group mb-4">
                                <label class="form-label" style="font-weight: 500; margin-bottom: 5px; display: block;">Jabatan</label>
                                <input type="text" name="pimpinan_jabatan" class="form-control" value="<?php echo e($settings->pimpinan_jabatan); ?>" required
                                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" style="font-weight: 500; margin-bottom: 5px; display: block;">Tanda Tangan (PNG Transparan)</label>
                                <?php if($settings->pimpinan_ttd_path): ?>
                                    <div class="mb-2 p-2 border rounded bg-gray-50">
                                        <img src="<?php echo e(asset('storage/' . $settings->pimpinan_ttd_path)); ?>" alt="TTD Pimpinan" style="height: 50px;">
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="pimpinan_ttd" class="form-control" accept="image/png"
                                    style="font-size: 12px;">
                                <small class="text-muted" style="display: block; margin-top: 4px; font-size: 11px;">* Wajib upload untuk fitur cetak otomatis</small>
                            </div>
                        </div>
                    </div>

                    <div class="text-right mt-4" style="text-align: right; border-top: 1px solid #e2e8f0; padding-top: 20px;">
                        <button type="submit" class="btn btn-primary" style="background: #3b82f6; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer;">
                            <i data-feather="save" style="width: 16px; margin-right: 5px;"></i> Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Tanda Tangan Wali Kelas -->
        <div class="card mt-4" style="background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: none; overflow: hidden; margin-top: 24px;">
            <div class="card-header" style="background: #f8fafc; padding: 20px; border-bottom: 1px solid #e2e8f0;">
                <h5 style="margin: 0; font-weight: 600; color: #1e293b;">Tanda Tangan Wali Kelas</h5>
                <p style="margin: 5px 0 0; color: #64748b; font-size: 0.9rem;">Upload tanda tangan digital untuk setiap wali kelas. File akan otomatis muncul di rapor siswa kelas tersebut.</p>
            </div>
            <div class="card-body" style="padding: 0;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f1f5f9;">
                        <tr>
                            <th style="padding: 15px 20px; text-align: left; font-weight: 600; color: #475569; width: 50px;">No</th>
                            <th style="padding: 15px 20px; text-align: left; font-weight: 600; color: #475569;">Nama Kelas</th>
                            <th style="padding: 15px 20px; text-align: left; font-weight: 600; color: #475569;">Wali Kelas</th>
                            <th style="padding: 15px 20px; text-align: center; font-weight: 600; color: #475569;">Preview TTD</th>
                            <th style="padding: 15px 20px; text-align: right; font-weight: 600; color: #475569;">Upload File</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $kelasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($kelas->tipe_wali_kelas === 'dual'): ?>
                                <!-- DUAL: PUTRA Row -->
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td rowspan="2" style="padding: 15px 20px; color: #64748b; vertical-align: top; border-bottom: 3px solid #e2e8f0;"><?php echo e($index + 1); ?></td>
                                    <td rowspan="2" style="padding: 15px 20px; font-weight: 600; color: #1e293b; vertical-align: top; border-bottom: 3px solid #e2e8f0;">
                                        <?php echo e($kelas->nama_kelas); ?> <br>
                                        <span class="badge" style="background: #e0f2fe; color: #0369a1; padding: 2px 6px; border-radius: 4px; font-size: 10px;">DUAL</span>
                                    </td>
                                    <td style="padding: 10px 20px; color: #475569;">
                                        Putra: <strong><?php echo e($kelas->wali_kelas_putra ?? '-'); ?></strong>
                                    </td>
                                    <td style="padding: 10px 20px; text-align: center;">
                                        <?php if($kelas->wali_kelas_ttd_path_putra): ?>
                                            <div style="background: #f8fafc; padding: 4px; border: 1px solid #e2e8f0; display: inline-block;">
                                                <img src="<?php echo e(asset('storage/' . $kelas->wali_kelas_ttd_path_putra)); ?>" style="height: 30px;">
                                            </div>
                                        <?php else: ?>
                                            <span style="font-size: 10px; color: #ef4444;">Belum ada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 10px 20px; text-align: right;">
                                        <form action="<?php echo e(route('pendidikan.kelas.upload-ttd', $kelas->id)); ?>" method="POST" enctype="multipart/form-data" class="flex-center-end">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="type" value="putra">
                                            <input type="file" name="ttd_file" required class="form-control" accept="image/png" style="width: 180px; font-size: 11px;">
                                            <button type="submit" class="btn btn-sm-upload"><i data-feather="upload" style="width: 12px;"></i> Upload</button>
                                        </form>
                                    </td>
                                </tr>
                                <!-- DUAL: PUTRI Row -->
                                <tr style="border-bottom: 3px solid #e2e8f0;">
                                    <td style="padding: 10px 20px; color: #475569;">
                                        Putri: <strong><?php echo e($kelas->wali_kelas_putri ?? '-'); ?></strong>
                                    </td>
                                    <td style="padding: 10px 20px; text-align: center;">
                                        <?php if($kelas->wali_kelas_ttd_path_putri): ?>
                                            <div style="background: #f8fafc; padding: 4px; border: 1px solid #e2e8f0; display: inline-block;">
                                                <img src="<?php echo e(asset('storage/' . $kelas->wali_kelas_ttd_path_putri)); ?>" style="height: 30px;">
                                            </div>
                                        <?php else: ?>
                                            <span style="font-size: 10px; color: #ef4444;">Belum ada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 10px 20px; text-align: right;">
                                        <form action="<?php echo e(route('pendidikan.kelas.upload-ttd', $kelas->id)); ?>" method="POST" enctype="multipart/form-data" class="flex-center-end">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="type" value="putri">
                                            <input type="file" name="ttd_file" required class="form-control" accept="image/png" style="width: 180px; font-size: 11px;">
                                            <button type="submit" class="btn btn-sm-upload"><i data-feather="upload" style="width: 12px;"></i> Upload</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <!-- TUNGGAL Row -->
                                <tr style="border-bottom: 3px solid #e2e8f0;">
                                    <td style="padding: 15px 20px; color: #64748b;"><?php echo e($index + 1); ?></td>
                                    <td style="padding: 15px 20px; font-weight: 500; color: #1e293b;"><?php echo e($kelas->nama_kelas); ?></td>
                                    <td style="padding: 15px 20px; color: #475569;"><?php echo e($kelas->wali_kelas ?? '-'); ?></td>
                                    <td style="padding: 15px 20px; text-align: center;">
                                        <?php if($kelas->wali_kelas_ttd_path): ?>
                                            <div style="background: #f8fafc; padding: 5px; border-radius: 4px; border: 1px solid #e2e8f0; display: inline-block;">
                                                <img src="<?php echo e(asset('storage/' . $kelas->wali_kelas_ttd_path)); ?>" alt="TTD" style="height: 40px; object-fit: contain;">
                                            </div>
                                        <?php else: ?>
                                            <span style="font-size: 11px; color: #ef4444; background: #fef2f2; padding: 2px 8px; border-radius: 10px;">Belum ada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 15px 20px; text-align: right;">
                                        <form action="<?php echo e(route('pendidikan.kelas.upload-ttd', $kelas->id)); ?>" method="POST" enctype="multipart/form-data" class="flex-center-end">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="type" value="umum">
                                            <input type="file" name="ttd_file" required class="form-control" accept="image/png" style="width: 200px; font-size: 12px;">
                                            <button type="submit" class="btn btn-sm-upload"><i data-feather="upload" style="width: 14px;"></i> Upload</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>

                    <style>
                        .flex-center-end { display: flex; justify-content: flex-end; align-items: center; gap: 10px; }
                        .btn-sm-upload { background: #10b981; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; gap: 4px; }
                    </style>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\pendidikan\settings\index.blade.php ENDPATH**/ ?>