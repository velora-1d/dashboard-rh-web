

<?php $__env->startSection('title', 'Edit Santri'); ?>
<?php $__env->startSection('page-title', 'Edit Data Santri'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <li class="sidebar-menu-item">
        <a href="<?php echo e(route('sekretaris.dashboard')); ?>" class="sidebar-menu-link">
            <i data-feather="home" class="sidebar-menu-icon"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="<?php echo e(route('sekretaris.data-santri')); ?>" class="sidebar-menu-link active">
            <i data-feather="users" class="sidebar-menu-icon"></i>
            <span>Data Santri</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="<?php echo e(route('sekretaris.kartu-digital')); ?>" class="sidebar-menu-link">
            <i data-feather="credit-card" class="sidebar-menu-icon"></i>
            <span>Kartu Digital</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="<?php echo e(route('sekretaris.mutasi-santri')); ?>" class="sidebar-menu-link">
            <i data-feather="repeat" class="sidebar-menu-icon"></i>
            <span>Mutasi Santri</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="<?php echo e(route('sekretaris.laporan')); ?>" class="sidebar-menu-link">
            <i data-feather="file-text" class="sidebar-menu-icon"></i>
            <span>Laporan</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="sidebar-menu-link" style="width: 100%; background: none; border: none; cursor: pointer; text-align: left;">
                <i data-feather="log-out" class="sidebar-menu-icon"></i>
                <span>Logout</span>
            </button>
        </form>
    </li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Aesthetic Header with Gradient -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 24px 32px; margin-bottom: 32px; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -30px; right: -30px; width: 120px; height: 120px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -40px; left: 40%; width: 80px; height: 80px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
            <div style="background: rgba(255,255,255,0.2); width: 56px; height: 56px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                <i data-feather="edit" style="width: 28px; height: 28px; color: white;"></i>
            </div>
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 700; color: white; margin: 0 0 4px 0;">Edit Data Santri</h2>
                <p style="color: rgba(255,255,255,0.9); font-size: 0.875rem; margin: 0;"><?php echo e($santri->nama_santri); ?> (<?php echo e($santri->nis); ?>)</p>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success" style="background-color: #dcfce7; color: #166534; padding: 16px; border-radius: 8px; margin-bottom: 24px; border: 1px solid #bbf7d0;">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-error" style="background-color: #fee2e2; color: #991b1b; padding: 16px; border-radius: 8px; margin-bottom: 24px; border: 1px solid #fecaca;">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="card">
        <form method="POST" action="<?php echo e(route('sekretaris.data-santri.update', $santri->id)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <h3 style="font-size: var(--font-size-lg); font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-lg); color: var(--color-gray-900);">
                Virtual Account (Pembayaran)
            </h3>

            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; margin-bottom: 24px;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #64748b; margin-bottom: 4px;">Nomor VA (BCA/BRI/BNI)</label>
                        <?php if($santri->virtual_account_number): ?>
                            <div style="font-size: 1.25rem; font-weight: 700; color: #0f172a; font-family: monospace; letter-spacing: 1px;">
                                <?php echo e($santri->virtual_account_number); ?>

                            </div>
                        <?php else: ?>
                            <div style="color: #64748b; font-style: italic;">
                                Belum ada VA Generated
                            </div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <?php if(!$santri->virtual_account_number): ?>
                            
                            <button type="button" onclick="document.getElementById('form-generate-va').submit()" 
                                class="btn" style="background-color: #059669; color: white;">
                                <i data-feather="credit-card" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 4px;"></i>
                                Generate VA
                            </button>
                        <?php else: ?>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <span class="badge" style="background-color: #dcfce7; color: #166534; padding: 4px 12px; border-radius: 99px; font-weight: 600; font-size: 0.875rem;">
                                    Aktif
                                </span>
                                <button type="button" onclick="if(confirm('Yakin ingin mereset VA? Santri harus generate ulang untuk bisa bayar.')) document.getElementById('form-reset-va').submit()" 
                                    class="btn" style="background-color: #ef4444; color: white; padding: 4px 12px; font-size: 0.75rem;">
                                    <i data-feather="refresh-cw" style="width: 12px; height: 12px; vertical-align: middle;"></i>
                                    Reset
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <h3 style="font-size: var(--font-size-lg); font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-lg); color: var(--color-gray-900);">
                Informasi Santri
            </h3>
            
            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label class="form-label">NIS *</label>
                    <input type="text" name="nis" class="form-input" value="<?php echo e(old('nis', $santri->nis)); ?>" required>
                    <?php $__errorArgs = ['nis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="form-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Nama Santri *</label>
                    <input type="text" name="nama_santri" class="form-input" value="<?php echo e(old('nama_santri', $santri->nama_santri)); ?>" required>
                    <?php $__errorArgs = ['nama_santri'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="form-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Gender *</label>
                    <select name="gender" class="form-select" required>
                        <option value="">Pilih Gender</option>
                        <option value="putra" <?php echo e(old('gender', $santri->gender) == 'putra' ? 'selected' : ''); ?>>Putra</option>
                        <option value="putri" <?php echo e(old('gender', $santri->gender) == 'putri' ? 'selected' : ''); ?>>Putri</option>
                    </select>
                    <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="form-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            
            <h3 style="font-size: var(--font-size-lg); font-weight: var(--font-weight-semibold); margin: var(--spacing-xl) 0 var(--spacing-lg); color: var(--color-gray-900);">
                Alamat Lengkap
            </h3>
            
            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label class="form-label">Negara *</label>
                    <input type="text" name="negara" class="form-input" value="<?php echo e(old('negara', $santri->negara)); ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Provinsi *</label>
                    <input type="text" name="provinsi" class="form-input" value="<?php echo e(old('provinsi', $santri->provinsi)); ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Kota/Kabupaten *</label>
                    <input type="text" name="kota_kabupaten" class="form-input" value="<?php echo e(old('kota_kabupaten', $santri->kota_kabupaten)); ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Kecamatan *</label>
                    <input type="text" name="kecamatan" class="form-input" value="<?php echo e(old('kecamatan', $santri->kecamatan)); ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Desa/Kampung *</label>
                    <input type="text" name="desa_kampung" class="form-input" value="<?php echo e(old('desa_kampung', $santri->desa_kampung)); ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">RT/RW *</label>
                    <input type="text" name="rt_rw" class="form-input" value="<?php echo e(old('rt_rw', $santri->rt_rw)); ?>" required>
                </div>
            </div>
            
            <h3 style="font-size: var(--font-size-lg); font-weight: var(--font-weight-semibold); margin: var(--spacing-xl) 0 var(--spacing-lg); color: var(--color-gray-900);">
                Orang Tua / Wali
            </h3>
            
            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label class="form-label">Nama Orang Tua/Wali *</label>
                    <input type="text" name="nama_ortu_wali" class="form-input" value="<?php echo e(old('nama_ortu_wali', $santri->nama_ortu_wali)); ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">No. HP Orang Tua/Wali *</label>
                    <input type="text" name="no_hp_ortu_wali" class="form-input" value="<?php echo e(old('no_hp_ortu_wali', $santri->no_hp_ortu_wali)); ?>" required>
                </div>
            </div>
            
            <h3 style="font-size: var(--font-size-lg); font-weight: var(--font-weight-semibold); margin: var(--spacing-xl) 0 var(--spacing-lg); color: var(--color-gray-900);">
                Penempatan
            </h3>
            
            <div class="grid grid-cols-3">
                <div class="form-group">
                    <label class="form-label">Kelas *</label>
                    <select name="kelas_id" class="form-select" required>
                        <option value="">Pilih Kelas</option>
                        <?php $__currentLoopData = $kelasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($kelas->id); ?>" <?php echo e(old('kelas_id', $santri->kelas_id) == $kelas->id ? 'selected' : ''); ?>>
                                <?php echo e($kelas->nama_kelas); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Asrama *</label>
                    <select name="asrama_id" id="asrama_id" class="form-select" required>
                        <option value="">Pilih Asrama</option>
                        <?php $__currentLoopData = $asramaList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asrama): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($asrama->id); ?>" <?php echo e(old('asrama_id', $santri->asrama_id) == $asrama->id ? 'selected' : ''); ?>>
                                <?php echo e($asrama->nama_asrama); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Kobong *</label>
                    <select name="kobong_id" id="kobong_id" class="form-select" required>
                        <?php $__currentLoopData = $kobongList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kobong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($kobong->id); ?>" <?php echo e(old('kobong_id', $santri->kobong_id) == $kobong->id ? 'selected' : ''); ?>>
                                Kobong <?php echo e($kobong->nomor_kobong); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            
            <div style="display: flex; gap: var(--spacing-md); margin-top: var(--spacing-xl);">
                <button type="submit" class="btn btn-primary">
                    <i data-feather="save" style="width: 16px; height: 16px;"></i>
                    Update
                </button>
                <a href="<?php echo e(route('sekretaris.data-santri')); ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
    <form id="form-generate-va" action="<?php echo e(route('santri.generate-va', $santri->id)); ?>" method="POST" style="display: none;">
        <?php echo csrf_field(); ?>
    </form>
    <form id="form-reset-va" action="<?php echo e(route('santri.reset-va', $santri->id)); ?>" method="POST" style="display: none;">
        <?php echo csrf_field(); ?>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('asrama_id').addEventListener('change', function() {
    const asramaId = this.value;
    const kobongSelect = document.getElementById('kobong_id');
    
    if (!asramaId) {
        kobongSelect.innerHTML = '<option value="">Pilih Asrama Dulu</option>';
        return;
    }
    
    fetch(`/sekretaris/api/kobong/${asramaId}`)
        .then(response => response.json())
        .then(data => {
            kobongSelect.innerHTML = '<option value="">Pilih Kobong</option>';
            data.forEach(kobong => {
                kobongSelect.innerHTML += `<option value="${kobong.id}">Kobong ${kobong.nomor_kobong}</option>`;
            });
        })
        .catch(error => console.error('Error:', error));
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\sekretaris\data-santri\edit.blade.php ENDPATH**/ ?>