

<?php $__env->startSection('title', 'Mata Pelajaran'); ?>
<?php $__env->startSection('page-title', 'Mata Pelajaran'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('pendidikan.partials.sidebar-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success" style="background-color: var(--color-primary-lightest); color: var(--color-primary-dark); padding: var(--spacing-md); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg); border: 1px solid var(--color-primary-light);">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>


    <!-- Compact Gradient Header with Inline Filters -->
    <div style="background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%); border-radius: 10px; padding: 16px 24px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(76,175,80,0.25);">
        <!-- Title Row -->
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                    <i data-feather="book" style="width: 20px; height: 20px; color: white;"></i>
                </div>
                <div>
                    <h2 style="font-size: 1.1rem; font-weight: 700; color: white; margin: 0 0 2px 0;">Daftar Mata Pelajaran</h2>
                    <p style="color: rgba(255,255,255,0.85); font-size: 0.75rem; margin: 0;">Kelola mata pelajaran dan pengampu</p>
                </div>
            </div>
        </div>
        
        <!-- Compact Filter Form in Single Row -->
        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <!-- Filter Kelas -->
            <div style="display: flex; flex-direction: column; gap: 4px; min-width: 180px;">
                <label style="font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.9); text-transform: uppercase; letter-spacing: 0.5px; margin: 0; display: flex; align-items: center; gap: 4px;">
                    <i data-feather="users" style="width: 11px; height: 11px;"></i>
                    Filter Kelas
                </label>
                <select id="filterKelas" class="form-select" 
                    style="height: 38px; border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; padding: 0 12px; font-size: 13px; background: rgba(255,255,255,0.95); color: #1f2937; font-weight: 500; cursor: pointer;">
                    <option value="">Semua Kelas</option>
                    <?php $__currentLoopData = $kelasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($kelas->id); ?>"><?php echo e($kelas->nama_kelas); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            
            <!-- Filter Waktu -->
            <div style="display: flex; flex-direction: column; gap: 4px; min-width: 160px;">
                <label style="font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.9); text-transform: uppercase; letter-spacing: 0.5px; margin: 0; display: flex; align-items: center; gap: 4px;">
                    <i data-feather="clock" style="width: 11px; height: 11px;"></i>
                    Filter Waktu
                </label>
                <select id="filterWaktu" class="form-select" 
                    style="height: 38px; border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; padding: 0 12px; font-size: 13px; background: rgba(255,255,255,0.95); color: #1f2937; font-weight: 500; cursor: pointer;">
                    <option value="">Semua Waktu</option>
                    <option value="Subuh">Subuh</option>
                    <option value="Pagi">Pagi</option>
                    <option value="Siang">Siang</option>
                    <option value="Sore">Sore</option>
                    <option value="Malam">Malam</option>
                </select>
            </div>
            
            <!-- Reset Button -->
            <div style="display: flex; gap: 8px; margin-left: auto; align-self: flex-end;">
                <button id="btnResetFilter" class="btn btn-secondary" 
                    style="height: 38px; padding: 0 16px; display: none; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer; transition: all 0.2s; backdrop-filter: blur(10px);"
                    onmouseover="this.style.background='rgba(255,255,255,0.25)';"
                    onmouseout="this.style.background='rgba(255,255,255,0.2)';">
                    <i data-feather="x" style="width: 14px; height: 14px;"></i>
                    Reset
                </button>
            </div>
        </div>
        
        <!-- Filter Info -->
        <div id="filterInfo" style="margin-top: 12px; padding: 8px 12px; background: rgba(255,255,255,0.15); border-radius: 6px; font-size: 12px; color: white; display: none; backdrop-filter: blur(10px);">
            <i data-feather="filter" style="width: 14px; height: 14px; vertical-align: middle;"></i>
            <span id="filterText"></span>
        </div>
    </div>


    <!-- Add Form with Modern Design -->
    <div style="background: white; border-radius: 10px; padding: 20px 24px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid rgba(76,175,80,0.1);">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
            <div style="background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%); width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <i data-feather="plus-circle" style="width: 18px; height: 18px; color: white;"></i>
            </div>
            <h3 style="font-size: 16px; font-weight: 600; margin: 0; color: #1f2937;">Tambah Mata Pelajaran</h3>
        </div>
        
        <form method="POST" action="<?php echo e(route('pendidikan.mapel.store')); ?>">
            <?php echo csrf_field(); ?>
            <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 12px; align-items: end;">
                <!-- Nama Mapel -->
                <div style="min-width: 180px; flex: 1.5;">
                    <label style="font-size: 11px; margin-bottom: 4px; display: block; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.3px;">Nama Mata Pelajaran</label>
                    <input type="text" name="nama_mapel" class="form-input" required 
                        style="height: 36px; padding: 0 10px; font-size: 13px; border: 1.5px solid #e5e7eb; border-radius: 6px; background: #f9fafb; transition: all 0.2s; width: 100%;"
                        onfocus="this.style.borderColor='#4caf50'; this.style.background='white';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb';">
                </div>
                
                <!-- Kode -->
                <div style="min-width: 100px; flex: 0.8;">
                    <label style="font-size: 11px; margin-bottom: 4px; display: block; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.3px;">Kode</label>
                    <input type="text" name="kode_mapel" class="form-input" placeholder="MTK01" required 
                        style="height: 36px; padding: 0 10px; font-size: 13px; border: 1.5px solid #e5e7eb; border-radius: 6px; background: #f9fafb; transition: all 0.2s; width: 100%;"
                        onfocus="this.style.borderColor='#4caf50'; this.style.background='white';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb';">
                </div>
                
                <!-- Kategori -->
                <div style="min-width: 120px; flex: 1;">
                    <label style="font-size: 11px; margin-bottom: 4px; display: block; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.3px;">Kategori</label>
                    <select name="kategori" class="form-select" required 
                        style="height: 36px; padding: 0 10px; font-size: 13px; border: 1.5px solid #e5e7eb; border-radius: 6px; background: #f9fafb; transition: all 0.2s; width: 100%; cursor: pointer;"
                        onfocus="this.style.borderColor='#4caf50'; this.style.background='white';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb';">
                        <option value="Agama">Agama</option>
                        <option value="Umum">Umum</option>
                        <option value="Ekstrakurikuler">Ekstrakurikuler</option>
                    </select>
                </div>
                
                <!-- Waktu -->
                <div style="min-width: 100px; flex: 0.8;">
                    <label style="font-size: 11px; margin-bottom: 4px; display: block; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.3px;">Waktu</label>
                    <select name="waktu_pelajaran" class="form-select" required 
                        style="height: 36px; padding: 0 10px; font-size: 13px; border: 1.5px solid #e5e7eb; border-radius: 6px; background: #f9fafb; transition: all 0.2s; width: 100%; cursor: pointer;"
                        onfocus="this.style.borderColor='#4caf50'; this.style.background='white';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb';">
                        <option value="Subuh">Subuh</option>
                        <option value="Pagi" selected>Pagi</option>
                        <option value="Siang">Siang</option>
                        <option value="Sore">Sore</option>
                        <option value="Malam">Malam</option>
                    </select>
                </div>
                
                <!-- Guru -->
                <div style="min-width: 140px; flex: 1;">
                    <label style="font-size: 11px; margin-bottom: 4px; display: block; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.3px;">Guru</label>
                    <input type="text" name="guru_pengampu" class="form-input" placeholder="Nama Guru" 
                        style="height: 36px; padding: 0 10px; font-size: 13px; border: 1.5px solid #e5e7eb; border-radius: 6px; background: #f9fafb; transition: all 0.2s; width: 100%;"
                        onfocus="this.style.borderColor='#4caf50'; this.style.background='white';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb';">
                </div>
                
                <!-- Deskripsi -->
                <div style="min-width: 180px; flex: 2;">
                    <label style="font-size: 11px; margin-bottom: 4px; display: block; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.3px;">Deskripsi</label>
                    <input type="text" name="deskripsi" class="form-input" placeholder="Deskripsi singkat" 
                        style="height: 36px; padding: 0 10px; font-size: 13px; border: 1.5px solid #e5e7eb; border-radius: 6px; background: #f9fafb; transition: all 0.2s; width: 100%;"
                        onfocus="this.style.borderColor='#4caf50'; this.style.background='white';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb';">
                </div>
            </div>
            
            <!-- Kelas Selection -->
            <div style="margin-bottom: 16px;">
                <label style="font-size: 11px; margin-bottom: 6px; display: block; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.3px;">Kelas (Pilih yang sesuai)</label>
                <div style="display: flex; gap: 8px; flex-wrap: wrap; padding: 12px; border: 1.5px solid #e5e7eb; border-radius: 8px; background: #f9fafb;">
                    <label style="display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; font-size: 12px; cursor: pointer; font-weight: 600; color: white; background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%); border-radius: 6px; transition: all 0.2s;"
                        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 2px 6px rgba(76,175,80,0.3)';"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                        <input type="checkbox" name="kelas_umum" value="1" style="margin: 0; width: 14px; height: 14px; cursor: pointer;">
                        <span>Umum</span>
                    </label>
                    <?php $__currentLoopData = $kelasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label style="display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; font-size: 12px; cursor: pointer; background: white; border: 1.5px solid #e5e7eb; border-radius: 6px; transition: all 0.2s;"
                            onmouseover="this.style.borderColor='#4caf50'; this.style.background='#f0f9ff';"
                            onmouseout="this.style.borderColor='#e5e7eb'; this.style.background='white';">
                            <input type="checkbox" name="kelas_ids[]" value="<?php echo e($kelas->id); ?>" style="margin: 0; width: 14px; height: 14px; cursor: pointer;">
                            <span><?php echo e($kelas->nama_kelas); ?></span>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            
            <!-- Submit Button -->
            <button type="submit" 
                style="height: 38px; padding: 0 24px; display: inline-flex; align-items: center; gap: 6px; background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%); color: white; border: none; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 6px rgba(76,175,80,0.3);"
                onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 10px rgba(76,175,80,0.4)';"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 6px rgba(76,175,80,0.3)';">
                <i data-feather="plus" style="width: 16px; height: 16px;"></i>
                Tambah Mata Pelajaran
            </button>
        </form>
    </div>

    <!-- Table with Modern Design -->
    <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid rgba(76,175,80,0.1);">
        <div class="table-container" style="overflow-x: auto;">
            <table class="table" style="font-size: 12px; width: 100%; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr style="background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%); color: white;">
                        <th style="padding: 12px 10px; text-align: left; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; border-top-left-radius: 8px;">Kode</th>
                        <th style="padding: 12px 10px; text-align: left; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Nama Mata Pelajaran</th>
                        <th style="padding: 12px 10px; text-align: center; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Kategori</th>
                        <th style="padding: 12px 10px; text-align: left; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Guru Pengampu</th>
                        <th style="padding: 12px 10px; text-align: left; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Guru Badal</th>
                        <th style="padding: 12px 10px; text-align: center; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Kelas</th>
                        <th style="padding: 12px 10px; text-align: center; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Waktu</th>
                        <th style="padding: 12px 10px; text-align: center; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Status</th>
                        <th style="padding: 12px 10px; text-align: center; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; border-top-right-radius: 8px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $mapel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr id="row-<?php echo e($m->id); ?>" style="border-bottom: 1px solid #f0f0f0; transition: all 0.2s;"
                            onmouseover="this.style.background='#f9fafb';"
                            onmouseout="this.style.background='white';">
                            <td style="padding: 10px;"><strong style="color: #4caf50; font-weight: 600;"><?php echo e($m->kode_mapel); ?></strong></td>
                            <td style="padding: 10px; color: #1f2937; font-weight: 500;"><?php echo e($m->nama_mapel); ?></td>
                            <td style="padding: 10px; text-align: center;">
                                <?php if($m->kategori == 'Agama'): ?>
                                    <span style="display: inline-block; padding: 4px 10px; background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%); color: white; border-radius: 12px; font-size: 11px; font-weight: 600;">Agama</span>
                                <?php elseif($m->kategori == 'Umum'): ?>
                                    <span style="display: inline-block; padding: 4px 10px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border-radius: 12px; font-size: 11px; font-weight: 600;">Umum</span>
                                <?php else: ?>
                                    <span style="display: inline-block; padding: 4px 10px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border-radius: 12px; font-size: 11px; font-weight: 600;">Ekstrakurikuler</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 10px; color: #6b7280;"><?php echo e($m->guru_pengampu ?? '-'); ?></td>
                            <td style="padding: 10px; color: #6b7280;"><?php echo e($m->guru_badal ?? '-'); ?></td>
                            <td style="padding: 10px; text-align: center;">
                                <?php if($m->kelas->isNotEmpty()): ?>
                                    <?php
                                        $kelasNames = $m->kelas->pluck('nama_kelas')->take(3)->toArray();
                                        $remaining = $m->kelas->count() - 3;
                                    ?>
                                    <span style="font-size: 11px; color: #6b7280;">
                                        <?php echo e(implode(', ', $kelasNames)); ?>

                                        <?php if($remaining > 0): ?>
                                            <span style="color: #4caf50; font-weight: 600;">+<?php echo e($remaining); ?></span>
                                        <?php endif; ?>
                                    </span>
                                <?php else: ?>
                                    <span style="font-size: 11px; color: #9ca3af;">-</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 10px; text-align: center;">
                                <span style="display: inline-block; padding: 4px 10px; background: #e0f2fe; color: #0369a1; border-radius: 12px; font-size: 11px; font-weight: 600;"><?php echo e($m->waktu_pelajaran ?? $m->jam_pelajaran . ' jam'); ?></span>
                            </td>
                            <td style="padding: 10px; text-align: center;">
                                <?php if($m->is_active): ?>
                                    <span style="display: inline-block; padding: 4px 10px; background: #dcfce7; color: #15803d; border-radius: 12px; font-size: 11px; font-weight: 600;">Aktif</span>
                                <?php else: ?>
                                    <span style="display: inline-block; padding: 4px 10px; background: #fee2e2; color: #dc2626; border-radius: 12px; font-size: 11px; font-weight: 600;">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 10px; text-align: center;">
                                <div style="display: flex; gap: 4px; justify-content: center;">
                                    <button onclick="toggleEdit(<?php echo e($m->id); ?>)" 
                                        style="padding: 6px 10px; background: white; color: #3b82f6; border: 1.5px solid #3b82f6; border-radius: 4px; font-size: 11px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 4px;"
                                        onmouseover="this.style.background='#3b82f6'; this.style.color='white';"
                                        onmouseout="this.style.background='white'; this.style.color='#3b82f6';">
                                        <i data-feather="edit" style="width: 12px; height: 12px;"></i>
                                        Edit
                                    </button>
                                    <form method="POST" action="<?php echo e(route('pendidikan.mapel.destroy', $m->id)); ?>" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" 
                                            style="padding: 6px 10px; background: white; color: #ef4444; border: 1.5px solid #ef4444; border-radius: 4px; font-size: 11px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 4px;"
                                            onmouseover="this.style.background='#ef4444'; this.style.color='white';"
                                            onmouseout="this.style.background='white'; this.style.color='#ef4444';">
                                            <i data-feather="trash-2" style="width: 12px; height: 12px;"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                        </td>
                    </tr>
                    <tr id="edit-<?php echo e($m->id); ?>" style="display: none;">
                        <td colspan="8" style="background-color: #f5f5f5; padding: 12px;">
                            <form method="POST" action="<?php echo e(route('pendidikan.mapel.update', $m->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <div style="display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr 1fr 1fr 1fr 3fr; gap: 12px; margin-bottom: 12px; align-items: end;">
                                    <div>
                                        <label style="font-size: 12px; margin-bottom: 4px; display: block; font-weight: 500;">Nama Mata Pelajaran</label>
                                        <input type="text" name="nama_mapel" class="form-input" value="<?php echo e($m->nama_mapel); ?>" required style="padding: 6px; font-size: 13px;">
                                    </div>
                                    <div>
                                        <label style="font-size: 12px; margin-bottom: 4px; display: block; font-weight: 500;">Kode</label>
                                        <input type="text" name="kode_mapel" class="form-input" value="<?php echo e($m->kode_mapel); ?>" required style="padding: 6px; font-size: 13px;">
                                    </div>
                                    <div>
                                        <label style="font-size: 12px; margin-bottom: 4px; display: block; font-weight: 500;">Kategori</label>
                                        <select name="kategori" class="form-select" required style="padding: 6px; font-size: 13px;">
                                            <option value="Agama" <?php echo e($m->kategori == 'Agama' ? 'selected' : ''); ?>>Agama</option>
                                            <option value="Umum" <?php echo e($m->kategori == 'Umum' ? 'selected' : ''); ?>>Umum</option>
                                            <option value="Ekstrakurikuler" <?php echo e($m->kategori == 'Ekstrakurikuler' ? 'selected' : ''); ?>>Ekstrakurikuler</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label style="font-size: 12px; margin-bottom: 4px; display: block; font-weight: 500;">Waktu</label>
                                        <select name="waktu_pelajaran" class="form-select" required style="padding: 6px; font-size: 13px;">
                                            <option value="Subuh" <?php echo e(($m->waktu_pelajaran ?? '') == 'Subuh' ? 'selected' : ''); ?>>Subuh</option>
                                            <option value="Pagi" <?php echo e(($m->waktu_pelajaran ?? '') == 'Pagi' ? 'selected' : ''); ?>>Pagi</option>
                                            <option value="Siang" <?php echo e(($m->waktu_pelajaran ?? '') == 'Siang' ? 'selected' : ''); ?>>Siang</option>
                                            <option value="Sore" <?php echo e(($m->waktu_pelajaran ?? '') == 'Sore' ? 'selected' : ''); ?>>Sore</option>
                                            <option value="Malam" <?php echo e(($m->waktu_pelajaran ?? '') == 'Malam' ? 'selected' : ''); ?>>Malam</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label style="font-size: 12px; margin-bottom: 4px; display: block; font-weight: 500;">Guru Pengampu</label>
                                        <input type="text" name="guru_pengampu" class="form-input" value="<?php echo e($m->guru_pengampu); ?>" style="padding: 6px; font-size: 13px;">
                                    </div>
                                    <div>
                                        <label style="font-size: 12px; margin-bottom: 4px; display: block; font-weight: 500;">Guru Badal</label>
                                        <input type="text" name="guru_badal" class="form-input" value="<?php echo e($m->guru_badal); ?>" style="padding: 6px; font-size: 13px;">
                                    </div>
                                    <div>
                                        <label style="font-size: 12px; margin-bottom: 4px; display: block; font-weight: 500;">Deskripsi</label>
                                        <input type="text" name="deskripsi" class="form-input" value="<?php echo e($m->deskripsi); ?>" style="padding: 6px; font-size: 13px;">
                                    </div>
                                    <div>
                                        <label style="font-size: 12px; margin-bottom: 4px; display: block; font-weight: 500;">Status</label>
                                        <select name="is_active" class="form-select" style="padding: 6px; font-size: 13px;">
                                            <option value="1" <?php echo e($m->is_active ? 'selected' : ''); ?>>Aktif</option>
                                            <option value="0" <?php echo e(!$m->is_active ? 'selected' : ''); ?>>Nonaktif</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label style="font-size: 12px; margin-bottom: 4px; display: block; font-weight: 500;">Kelas</label>
                                        <div style="display: flex; gap: 6px; flex-wrap: wrap; padding: 6px; border: 1px solid #ddd; border-radius: 4px; background: white;">
                                            <?php
                                                $selectedKelasIds = $m->kelas->pluck('id')->toArray();
                                                $isKelasUmum = $m->kelas->isNotEmpty() && $m->kelas->first()->pivot->is_kelas_umum;
                                            ?>
                                            <label style="display: flex; align-items: center; gap: 3px; font-size: 11px; cursor: pointer; font-weight: 600; color: #2e7d32;">
                                                <input type="checkbox" name="kelas_umum" value="1" <?php echo e($isKelasUmum ? 'checked' : ''); ?> style="margin: 0;">
                                                <span>Umum</span>
                                            </label>
                                            <span style="color: #ddd; font-size: 11px;">|</span>
                                            <?php $__currentLoopData = $kelasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <label style="display: flex; align-items: center; gap: 3px; font-size: 11px; cursor: pointer;">
                                                    <input type="checkbox" name="kelas_ids[]" value="<?php echo e($kelas->id); ?>" 
                                                           <?php echo e(in_array($kelas->id, $selectedKelasIds) ? 'checked' : ''); ?> 
                                                           style="margin: 0;">
                                                    <span><?php echo e($kelas->nama_kelas); ?></span>
                                                </label>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                                <div style="display: flex; gap: 8px;">
                                    <button type="submit" class="btn btn-primary" style="padding: 6px 12px; font-size: 13px;">Simpan</button>
                                    <button type="button" onclick="toggleEdit(<?php echo e($m->id); ?>)" class="btn btn-secondary" style="padding: 6px 12px; font-size: 13px;">Batal</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: var(--spacing-xl); color: var(--color-gray-500);">
                            Tidak ada data mata pelajaran
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($mapel->hasPages()): ?>
        <div style="margin-top: var(--spacing-lg); display: flex; justify-content: center;">
            <?php echo e($mapel->links()); ?>

        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Real-time filtering without page reload
document.addEventListener('DOMContentLoaded', function() {
    const filterKelas = document.getElementById('filterKelas');
    const filterWaktu = document.getElementById('filterWaktu');
    const btnReset = document.getElementById('btnResetFilter');
    const filterInfo = document.getElementById('filterInfo');
    const filterText = document.getElementById('filterText');
    const tableRows = document.querySelectorAll('tbody tr:not([id^="edit-"])');
    
    // Store original data for each row
    const rowData = [];
    tableRows.forEach((row, index) => {
        if (index % 2 === 0) { // Only process main rows, not edit rows
            const kelasCell = row.cells[4]; // Kelas column
            const waktuCell = row.cells[5]; // Waktu column
            
            // Extract kelas IDs from the cell
            const kelasText = kelasCell ? kelasCell.textContent.trim() : '';
            
            // Extract waktu from badge
            const waktuBadge = waktuCell ? waktuCell.querySelector('.badge') : null;
            const waktuText = waktuBadge ? waktuBadge.textContent.trim() : '';
            
            rowData.push({
                row: row,
                editRow: tableRows[index + 1], // The edit row follows the main row
                kelasText: kelasText,
                waktuText: waktuText
            });
        }
    });
    
    function applyFilters() {
        const selectedKelas = filterKelas.value;
        const selectedWaktu = filterWaktu.value;
        
        let visibleCount = 0;
        let filterMessages = [];
        
        rowData.forEach(data => {
            let showRow = true;
            
            // Filter by kelas
            if (selectedKelas) {
                // Check if the kelas text contains the selected kelas name
                const kelasOption = filterKelas.options[filterKelas.selectedIndex];
                const kelasName = kelasOption ? kelasOption.text : '';
                showRow = showRow && data.kelasText.includes(kelasName);
            }
            
            // Filter by waktu
            if (selectedWaktu) {
                showRow = showRow && data.waktuText.includes(selectedWaktu);
            }
            
            // Show/hide with smooth transition
            if (showRow) {
                data.row.style.display = '';
                if (data.editRow) data.editRow.style.display = 'none'; // Keep edit row hidden
                visibleCount++;
            } else {
                data.row.style.display = 'none';
                if (data.editRow) data.editRow.style.display = 'none';
            }
        });
        
        // Update filter info
        if (selectedKelas || selectedWaktu) {
            if (selectedKelas) {
                const kelasName = filterKelas.options[filterKelas.selectedIndex].text;
                filterMessages.push(`Kelas: ${kelasName}`);
            }
            if (selectedWaktu) {
                filterMessages.push(`Waktu: ${selectedWaktu}`);
            }
            
            filterText.textContent = `Menampilkan ${visibleCount} dari ${rowData.length} mata pelajaran (${filterMessages.join(', ')})`;
            filterInfo.style.display = 'block';
            btnReset.style.display = 'inline-block';
        } else {
            filterInfo.style.display = 'none';
            btnReset.style.display = 'none';
        }
        
        // Replace feather icons
        feather.replace();
    }
    
    
    function resetFilters() {
        filterKelas.value = '';
        filterWaktu.value = '';
        applyFilters();
    }
    
    // Event listeners
    filterKelas.addEventListener('change', applyFilters);
    filterWaktu.addEventListener('change', applyFilters);
    btnReset.addEventListener('click', resetFilters);
    
    // Initial state
    applyFilters();
});

// Update Guru Badal
function updateGuruBadal(id) {
    const input = document.getElementById('guru-badal-' + id);
    const guruBadal = input.value;
    
    fetch(`/pendidikan/mapel/${id}/update-guru-badal`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ guru_badal: guruBadal })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success feedback
            input.style.borderColor = '#4caf50';
            input.style.background = '#dcfce7';
            setTimeout(() => {
                input.style.borderColor = '#e5e7eb';
                input.style.background = '#f9fafb';
            }, 1500);
        } else {
            alert('Gagal menyimpan guru badal');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan');
    });
}

// Update Guru Pengampu
function updateGuruPengampu(id) {
    const input = document.getElementById('guru-pengampu-' + id);
    const guruPengampu = input.value;
    
    fetch(`/pendidikan/mapel/${id}/update-guru-pengampu`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ guru_pengampu: guruPengampu })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success feedback
            input.style.borderColor = '#3b82f6';
            input.style.background = '#dbeafe';
            setTimeout(() => {
                input.style.borderColor = '#e5e7eb';
                input.style.background = '#f9fafb';
            }, 1500);
        } else {
            alert('Gagal menyimpan guru pengampu');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan');
    });
}

function toggleEdit(id) {
    const row = document.getElementById('row-' + id);
    const editRow = document.getElementById('edit-' + id);
    
    if (editRow.style.display === 'none' || editRow.style.display === '') {
        editRow.style.display = 'table-row';
        row.style.backgroundColor = '#f5f5f5';
    } else {
        editRow.style.display = 'none';
        row.style.backgroundColor = '';
    }
    
    feather.replace();
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\pendidikan\mapel\index.blade.php ENDPATH**/ ?>