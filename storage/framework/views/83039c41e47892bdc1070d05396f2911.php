

<?php $__env->startSection('title', 'Mutasi Santri'); ?>
<?php $__env->startSection('page-title', 'Mutasi Santri'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <li class="sidebar-menu-item">
        <a href="<?php echo e(route('sekretaris.dashboard')); ?>" class="sidebar-menu-link">
            <i data-feather="home" class="sidebar-menu-icon"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="<?php echo e(route('sekretaris.data-santri')); ?>" class="sidebar-menu-link">
            <i data-feather="users" class="sidebar-menu-icon"></i>
            <span>Data Santri</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="<?php echo e(route('sekretaris.mutasi-santri')); ?>" class="sidebar-menu-link active">
            <i data-feather="repeat" class="sidebar-menu-icon"></i>
            <span>Mutasi Santri</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="<?php echo e(route('sekretaris.kenaikan-kelas')); ?>" class="sidebar-menu-link">
            <i data-feather="trending-up" class="sidebar-menu-icon"></i>
            <span>Kenaikan Kelas</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="<?php echo e(route('sekretaris.perpindahan')); ?>" class="sidebar-menu-link">
            <i data-feather="shuffle" class="sidebar-menu-icon"></i>
            <span>Perpindahan</span>
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

<?php $__env->startSection('bottom-nav'); ?>
    <li class="bottom-nav-item">
        <a href="<?php echo e(route('sekretaris.dashboard')); ?>" class="bottom-nav-link">
            <i data-feather="home" class="bottom-nav-icon"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="bottom-nav-item">
        <a href="<?php echo e(route('sekretaris.data-santri')); ?>" class="bottom-nav-link">
            <i data-feather="users" class="bottom-nav-icon"></i>
            <span>Santri</span>
        </a>
    </li>
    <li class="bottom-nav-item">
        <a href="<?php echo e(route('sekretaris.mutasi-santri')); ?>" class="bottom-nav-link active">
            <i data-feather="repeat" class="bottom-nav-icon"></i>
            <span>Mutasi</span>
        </a>
    </li>
    <li class="bottom-nav-item">
        <a href="<?php echo e(route('sekretaris.laporan')); ?>" class="bottom-nav-link">
            <i data-feather="file-text" class="bottom-nav-icon"></i>
            <span>Laporan</span>
        </a>
    </li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('drawer-menu'); ?>
    <li class="drawer-menu-item">
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="drawer-menu-link" style="width: 100%; background: none; border: none; cursor: pointer; text-align: left;">
                <i data-feather="log-out"></i>
                <span>Logout</span>
            </button>
        </form>
    </li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success" style="background-color: var(--color-primary-lightest); color: var(--color-primary-dark); padding: var(--spacing-md); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg); border: 1px solid var(--color-primary-light);">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Aesthetic Header with Gradient -->
    <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 16px; padding: 24px 32px; margin-bottom: 32px; box-shadow: 0 10px 30px rgba(250, 112, 154, 0.3); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -30px; right: -30px; width: 120px; height: 120px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -40px; left: 40%; width: 80px; height: 80px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
            <div style="background: rgba(255,255,255,0.2); width: 56px; height: 56px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                <i data-feather="repeat" style="width: 28px; height: 28px; color: white;"></i>
            </div>
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 700; color: white; margin: 0 0 4px 0;">Mutasi Santri</h2>
                <p style="color: rgba(255,255,255,0.9); font-size: 0.875rem; margin: 0;">Kelola Perpindahan dan Mutasi Santri</p>
            </div>
        </div>
    </div>

    <!-- Form Tambah Mutasi with Gradient -->
    <div style="background: white; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); overflow: hidden; margin-bottom: 24px;">
        <!-- Form Header with Gradient -->
        <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); padding: 20px 24px; position: relative; overflow: hidden;">
            <div style="position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="position: absolute; bottom: -30px; left: 40%; width: 60px; height: 60px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
            <div style="display: flex; align-items: center; gap: 12px; position: relative; z-index: 1;">
                <div style="background: rgba(255,255,255,0.2); width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                    <i data-feather="plus-circle" style="width: 22px; height: 22px; color: white;"></i>
                </div>
                <div>
                    <h3 style="font-size: 1.1rem; font-weight: 700; color: white; margin: 0;">Catat Mutasi Santri</h3>
                    <p style="color: rgba(255,255,255,0.9); font-size: 0.8rem; margin: 0;">Tambah data mutasi baru</p>
                </div>
            </div>
        </div>
        
        <!-- Form Content -->
        <form method="POST" action="<?php echo e(route('sekretaris.mutasi-santri.store')); ?>" style="padding: 24px;">
            <?php echo csrf_field(); ?>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 24px;">
                <!-- Santri -->
                <div>
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: #374151; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                        <i data-feather="user" style="width: 14px; height: 14px; color: #fa709a;"></i>
                        Santri <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="santri_id" required style="width: 100%; height: 44px; border: 2px solid #e5e7eb; border-radius: 10px; padding: 0 14px; font-size: 14px; color: #1f2937; background: white; cursor: pointer; transition: border-color 0.2s;" onfocus="this.style.borderColor='#fa709a';" onblur="this.style.borderColor='#e5e7eb';">
                        <option value="">Pilih Santri</option>
                        <?php $__currentLoopData = $santriAktif; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s->id); ?>"><?php echo e($s->nis); ?> - <?php echo e($s->nama_santri); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                
                <!-- Jenis Mutasi -->
                <div>
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: #374151; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                        <i data-feather="git-branch" style="width: 14px; height: 14px; color: #fa709a;"></i>
                        Jenis Mutasi <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="jenis_mutasi" required style="width: 100%; height: 44px; border: 2px solid #e5e7eb; border-radius: 10px; padding: 0 14px; font-size: 14px; color: #1f2937; background: white; cursor: pointer; transition: border-color 0.2s;" onfocus="this.style.borderColor='#fa709a';" onblur="this.style.borderColor='#e5e7eb';">
                        <option value="">Pilih Jenis</option>
                        <option value="masuk">Masuk</option>
                        <option value="keluar">Keluar</option>
                        <option value="pindah_kelas">Pindah Kelas</option>
                        <option value="pindah_asrama">Pindah Asrama</option>
                    </select>
                </div>
                
                <!-- Tanggal -->
                <div>
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: #374151; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                        <i data-feather="calendar" style="width: 14px; height: 14px; color: #fa709a;"></i>
                        Tanggal Mutasi <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="date" name="tanggal_mutasi" required style="width: 100%; height: 44px; border: 2px solid #e5e7eb; border-radius: 10px; padding: 0 14px; font-size: 14px; color: #1f2937; background: white; transition: border-color 0.2s;" onfocus="this.style.borderColor='#fa709a';" onblur="this.style.borderColor='#e5e7eb';">
                </div>
                
                <!-- Dari -->
                <div>
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: #374151; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                        <i data-feather="arrow-left-circle" style="width: 14px; height: 14px; color: #6b7280;"></i>
                        Dari
                    </label>
                    <input type="text" name="dari" placeholder="Contoh: Kelas 1 Ibtida" style="width: 100%; height: 44px; border: 2px solid #e5e7eb; border-radius: 10px; padding: 0 14px; font-size: 14px; color: #1f2937; background: white; transition: border-color 0.2s;" onfocus="this.style.borderColor='#fa709a';" onblur="this.style.borderColor='#e5e7eb';">
                </div>
                
                <!-- Ke -->
                <div>
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: #374151; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                        <i data-feather="arrow-right-circle" style="width: 14px; height: 14px; color: #6b7280;"></i>
                        Ke
                    </label>
                    <input type="text" name="ke" placeholder="Contoh: Kelas 2 Ibtida" style="width: 100%; height: 44px; border: 2px solid #e5e7eb; border-radius: 10px; padding: 0 14px; font-size: 14px; color: #1f2937; background: white; transition: border-color 0.2s;" onfocus="this.style.borderColor='#fa709a';" onblur="this.style.borderColor='#e5e7eb';">
                </div>
                
                <!-- Keterangan -->
                <div>
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: #374151; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                        <i data-feather="file-text" style="width: 14px; height: 14px; color: #6b7280;"></i>
                        Keterangan
                    </label>
                    <input type="text" name="keterangan" placeholder="Keterangan tambahan" style="width: 100%; height: 44px; border: 2px solid #e5e7eb; border-radius: 10px; padding: 0 14px; font-size: 14px; color: #1f2937; background: white; transition: border-color 0.2s;" onfocus="this.style.borderColor='#fa709a';" onblur="this.style.borderColor='#e5e7eb';">
                </div>
            </div>
            
            <button type="submit" style="display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; padding: 12px 28px; border-radius: 10px; font-weight: 600; font-size: 14px; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(250, 112, 154, 0.35); transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(250, 112, 154, 0.45)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(250, 112, 154, 0.35)';">
                <i data-feather="plus" style="width: 18px; height: 18px;"></i>
                Catat Mutasi
            </button>
        </form>
    </div>

    <div class="card">
        <h3 class="card-header" style="display: flex; align-items: center; gap: 12px;">
            Riwayat Mutasi
            <span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 4px 14px; border-radius: 20px; font-size: 13px; font-weight: 600;"><?php echo e($mutasi->total()); ?> Total</span>
        </h3>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">No</th>
                        <th>Tanggal</th>
                        <th>NIS</th>
                        <th>Nama Santri</th>
                        <th>Jenis Mutasi</th>
                        <th>Dari</th>
                        <th>Ke</th>
                        <th>Keterangan</th>
                        <th style="width: 120px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $mutasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td style="text-align: center; font-weight: 600; color: #6b7280;"><?php echo e($mutasi->firstItem() + $index); ?></td>
                            <td><?php echo e($m->tanggal_mutasi->format('d/m/Y')); ?></td>
                            <td><?php echo e($m->santri->nis ?? '-'); ?></td>
                            <td><?php echo e($m->santri->nama_santri ?? '-'); ?></td>
                            <td>
                                <span class="badge 
                                    <?php if($m->jenis_mutasi == 'masuk'): ?> badge-success
                                    <?php elseif($m->jenis_mutasi == 'keluar'): ?> badge-error
                                    <?php else: ?> badge-info
                                    <?php endif; ?>">
                                    <?php echo e(ucwords(str_replace('_', ' ', $m->jenis_mutasi))); ?>

                                </span>
                            </td>
                            <td><?php echo e($m->dari ?? '-'); ?></td>
                            <td><?php echo e($m->ke ?? '-'); ?></td>
                            <td><?php echo e($m->keterangan ?? '-'); ?></td>
                            <td style="text-align: center;">
                                <div style="display: flex; gap: 6px; justify-content: center;">
                                    <button type="button" onclick="openEditModal(<?php echo e($m->id); ?>, <?php echo e($m->santri_id); ?>, '<?php echo e($m->jenis_mutasi); ?>', '<?php echo e($m->tanggal_mutasi->format('Y-m-d')); ?>', '<?php echo e($m->dari); ?>', '<?php echo e($m->ke); ?>', '<?php echo e($m->keterangan); ?>')" 
                                        style="padding: 6px 10px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; border: none; border-radius: 6px; font-size: 11px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                        <i data-feather="edit-2" style="width: 12px; height: 12px;"></i>
                                        Edit
                                    </button>
                                    <form action="<?php echo e(route('sekretaris.mutasi-santri.destroy', $m->id)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus data mutasi ini?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" style="padding: 6px 10px; background: linear-gradient(135deg, #ff6a00 0%, #ee0979 100%); color: white; border: none; border-radius: 6px; font-size: 11px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                            <i data-feather="trash-2" style="width: 12px; height: 12px;"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" style="text-align: center; padding: var(--spacing-xl); color: var(--color-gray-500);">
                                Belum ada riwayat mutasi
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if($mutasi->hasPages()): ?>
            <div style="margin-top: var(--spacing-lg);">
                <?php echo e($mutasi->links()); ?>

            </div>
        <?php endif; ?>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
        <div style="background: white; border-radius: 16px; padding: 24px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600; color: #1f2937;">Edit Data Mutasi</h3>
                <button type="button" onclick="closeEditModal()" style="background: none; border: none; cursor: pointer; padding: 4px;">
                    <i data-feather="x" style="width: 24px; height: 24px; color: #6b7280;"></i>
                </button>
            </div>
            
            <form id="editForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                    <div>
                        <label style="font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 6px; display: block;">Santri</label>
                        <select name="santri_id" id="edit_santri_id" required style="width: 100%; height: 44px; border: 2px solid #e5e7eb; border-radius: 10px; padding: 0 14px; font-size: 14px;">
                            <?php $__currentLoopData = $santriAktif; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s->id); ?>"><?php echo e($s->nis); ?> - <?php echo e($s->nama_santri); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label style="font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 6px; display: block;">Jenis Mutasi</label>
                        <select name="jenis_mutasi" id="edit_jenis_mutasi" required style="width: 100%; height: 44px; border: 2px solid #e5e7eb; border-radius: 10px; padding: 0 14px; font-size: 14px;">
                            <option value="masuk">Masuk</option>
                            <option value="keluar">Keluar</option>
                            <option value="pindah_kelas">Pindah Kelas</option>
                            <option value="pindah_asrama">Pindah Asrama</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 6px; display: block;">Tanggal Mutasi</label>
                        <input type="date" name="tanggal_mutasi" id="edit_tanggal_mutasi" required style="width: 100%; height: 44px; border: 2px solid #e5e7eb; border-radius: 10px; padding: 0 14px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 6px; display: block;">Keterangan</label>
                        <input type="text" name="keterangan" id="edit_keterangan" style="width: 100%; height: 44px; border: 2px solid #e5e7eb; border-radius: 10px; padding: 0 14px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 6px; display: block;">Dari</label>
                        <input type="text" name="dari" id="edit_dari" style="width: 100%; height: 44px; border: 2px solid #e5e7eb; border-radius: 10px; padding: 0 14px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 6px; display: block;">Ke</label>
                        <input type="text" name="ke" id="edit_ke" style="width: 100%; height: 44px; border: 2px solid #e5e7eb; border-radius: 10px; padding: 0 14px; font-size: 14px;">
                    </div>
                </div>
                <div style="margin-top: 20px; display: flex; gap: 12px; justify-content: flex-end;">
                    <button type="button" onclick="closeEditModal()" style="padding: 10px 20px; background: #f3f4f6; color: #374151; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Batal</button>
                    <button type="submit" style="padding: 10px 20px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function openEditModal(id, santriId, jenisMutasi, tanggal, dari, ke, keterangan) {
        document.getElementById('editForm').action = '/sekretaris/mutasi-santri/' + id;
        document.getElementById('edit_santri_id').value = santriId;
        document.getElementById('edit_jenis_mutasi').value = jenisMutasi;
        document.getElementById('edit_tanggal_mutasi').value = tanggal;
        document.getElementById('edit_dari').value = dari || '';
        document.getElementById('edit_ke').value = ke || '';
        document.getElementById('edit_keterangan').value = keterangan || '';
        
        document.getElementById('editModal').style.display = 'flex';
        if (typeof feather !== 'undefined') feather.replace();
    }
    
    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }
    
    // Close modal when clicking outside
    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) closeEditModal();
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\sekretaris\mutasi\index.blade.php ENDPATH**/ ?>