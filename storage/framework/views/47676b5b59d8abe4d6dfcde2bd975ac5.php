

<?php $__env->startSection('title', 'Tambah Santri'); ?>
<?php $__env->startSection('page-title', 'Tambah Data Santri'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('sekretaris.partials.sidebar-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Aesthetic Header with Gradient -->
    <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 16px; padding: 24px 32px; margin-bottom: 32px; box-shadow: 0 10px 30px rgba(67, 233, 123, 0.3); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -30px; right: -30px; width: 120px; height: 120px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -40px; left: 40%; width: 80px; height: 80px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
            <div style="background: rgba(255,255,255,0.2); width: 56px; height: 56px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                <i data-feather="user-plus" style="width: 28px; height: 28px; color: white;"></i>
            </div>
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 700; color: white; margin: 0 0 4px 0;">Tambah Santri Baru</h2>
                <p style="color: rgba(255,255,255,0.9); font-size: 0.875rem; margin: 0;">Lengkapi Data untuk Mendaftarkan Santri</p>
            </div>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="<?php echo e(route('sekretaris.data-santri.store')); ?>">
            <?php echo csrf_field(); ?>
            
            <h3 style="font-size: var(--font-size-lg); font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-lg); color: var(--color-gray-900);">
                Informasi Santri
            </h3>
            
            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label class="form-label">NIS *</label>
                    <input type="text" name="nis" class="form-input" value="<?php echo e(old('nis')); ?>" required>
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
                    <input type="text" name="nama_santri" class="form-input" value="<?php echo e(old('nama_santri')); ?>" required>
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
                        <option value="putra" <?php echo e(old('gender') == 'putra' ? 'selected' : ''); ?>>Putra</option>
                        <option value="putri" <?php echo e(old('gender') == 'putri' ? 'selected' : ''); ?>>Putri</option>
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
                    <input type="text" name="negara" class="form-input" value="<?php echo e(old('negara', 'Indonesia')); ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Provinsi *</label>
                    <input type="text" name="provinsi" class="form-input" value="<?php echo e(old('provinsi')); ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Kota/Kabupaten *</label>
                    <input type="text" name="kota_kabupaten" class="form-input" value="<?php echo e(old('kota_kabupaten')); ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Kecamatan *</label>
                    <input type="text" name="kecamatan" class="form-input" value="<?php echo e(old('kecamatan')); ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Desa/Kampung *</label>
                    <input type="text" name="desa_kampung" class="form-input" value="<?php echo e(old('desa_kampung')); ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">RT/RW *</label>
                    <input type="text" name="rt_rw" class="form-input" placeholder="001/002" value="<?php echo e(old('rt_rw')); ?>" required>
                </div>
            </div>
            
            <h3 style="font-size: var(--font-size-lg); font-weight: var(--font-weight-semibold); margin: var(--spacing-xl) 0 var(--spacing-lg); color: var(--color-gray-900);">
                Orang Tua / Wali
            </h3>
            
            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label class="form-label">Nama Orang Tua/Wali *</label>
                    <input type="text" name="nama_ortu_wali" class="form-input" value="<?php echo e(old('nama_ortu_wali')); ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">No. HP Orang Tua/Wali *</label>
                    <input type="text" name="no_hp_ortu_wali" class="form-input" placeholder="08xxxxxxxxxx" value="<?php echo e(old('no_hp_ortu_wali')); ?>" required>
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
                            <option value="<?php echo e($kelas->id); ?>" <?php echo e(old('kelas_id') == $kelas->id ? 'selected' : ''); ?>>
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
                            <option value="<?php echo e($asrama->id); ?>" <?php echo e(old('asrama_id') == $asrama->id ? 'selected' : ''); ?>>
                                <?php echo e($asrama->nama_asrama); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Kobong *</label>
                    <select name="kobong_id" id="kobong_id" class="form-select" required>
                        <option value="">Pilih Asrama Dulu</option>
                    </select>
                </div>
            </div>
            
            <div style="display: flex; gap: var(--spacing-md); margin-top: var(--spacing-xl);">
                <button type="submit" class="btn btn-primary">
                    <i data-feather="save" style="width: 16px; height: 16px;"></i>
                    Simpan
                </button>
                <a href="<?php echo e(route('sekretaris.data-santri')); ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Dynamic Kobong dropdown based on Asrama selection
document.getElementById('asrama_id').addEventListener('change', function() {
    const asramaId = this.value;
    const kobongSelect = document.getElementById('kobong_id');
    
    if (!asramaId) {
        kobongSelect.innerHTML = '<option value="">Pilih Asrama Dulu</option>';
        return;
    }
    
    // Fetch kobong data
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\sekretaris\data-santri\create.blade.php ENDPATH**/ ?>