

<?php $__env->startSection('title', 'Ijazah'); ?>
<?php $__env->startSection('page-title', 'Manajemen Ijazah'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('pendidikan.partials.sidebar-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            ✓ <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Page Header (Aesthetic like other pages) -->
    <div style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 12px; padding: 24px 28px; margin-bottom: 24px; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.15);">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i data-feather="award" style="width: 24px; height: 24px; color: white;"></i>
            </div>
            <div>
                <h2 style="font-size: 24px; font-weight: 700; color: white; margin: 0;">Manajemen Ijazah</h2>
                <p style="font-size: 14px; color: rgba(255,255,255,0.9); margin: 4px 0 0 0;">Cetak ijazah untuk santri yang lulus dari Ibtida dan Tsanawi</p>
            </div>
        </div>
    </div>

    <!-- Settings Card -->
    <div style="background: white; border-radius: 10px; padding: 0; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid rgba(245,158,11,0.1); overflow: hidden;">
        <div style="padding: 16px 20px; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-bottom: 2px solid #f59e0b;">
            <h3 style="font-size: 16px; font-weight: 600; margin: 0; color: #92400e; display: flex; align-items: center; gap: 8px;">
                <i data-feather="settings" style="width: 18px; height: 18px;"></i>
                Pengaturan Ijazah Global
            </h3>
        </div>
        <div style="padding: 20px;">
            <form method="POST" action="<?php echo e(route('pendidikan.ijazah.settings')); ?>">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-2 gap-4" style="margin-bottom: 16px;">
                    <div class="form-group">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">
                            Tanggal Ijazah
                        </label>
                        <input type="date" name="tanggal_ijazah" class="form-input" 
                               value="<?php echo e($settings->tanggal_ijazah?->format('Y-m-d') ?? now()->format('Y-m-d')); ?>"
                               style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px; width: 100%;">
                        <small style="color: #666; font-size: 11px;">Berlaku untuk semua ijazah</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">
                            Tahun Ajaran
                        </label>
                        <input type="text" name="tahun_ajaran" class="form-input" 
                               value="<?php echo e($settings->tahun_ajaran); ?>"
                               placeholder="2024/2025"
                               style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px; width: 100%;">
                    </div>
                </div>
                
                <button type="submit" style="padding: 10px 20px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px;"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(245,158,11,0.3)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    <i data-feather="save" style="width: 16px; height: 16px;"></i>
                    Simpan Pengaturan
                </button>
            </form>
        </div>
    </div>

    <!-- Ijazah Ibtida Section -->
    <div style="background: white; border-radius: 10px; padding: 0; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid rgba(16,185,129,0.1); overflow: hidden;">
        <div style="padding: 16px 20px; background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border-bottom: 2px solid #10b981;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 16px; font-weight: 600; margin: 0; color: #065f46; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="award" style="width: 18px; height: 18px;"></i>
                    Ijazah Ibtida
                    <span style="font-size: 12px; font-weight: 400; color: #666; margin-left: 8px;">
                        Untuk santri yang lulus dari Kelas 3 Ibtida
                    </span>
                </h3>
            </div>
        </div>
        <div style="padding: 20px;">
            <?php if($kelasIbtida && $santriIbtida->count() > 0): ?>
                <!-- Gender Filter -->
                <div style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; border: 1.5px solid #bbf7d0; display: flex; align-items: center; gap: 16px;">
                    <label style="font-size: 13px; font-weight: 600; color: #166534; display: flex; align-items: center; gap: 6px;">
                        <i data-feather="filter" style="width: 14px; height: 14px;"></i>
                        Filter Gender:
                    </label>
                    <select id="filterGenderIbtida" class="form-select" style="font-size: 13px; border: 1.5px solid #d1d5db; border-radius: 6px; padding: 6px 12px; min-width: 150px;">
                        <option value="all">Semua</option>
                        <option value="putra">Putra</option>
                        <option value="putri">Putri</option>
                    </select>
                    <?php if($kelasIbtida): ?>
                        <div style="margin-left: auto; display: flex; gap: 8px;">
                            <a href="<?php echo e(route('pendidikan.ijazah.cetak', ['type' => 'ibtida', 'kelasId' => $kelasIbtida->id])); ?>" 
                               id="btnCetakSemuaIbtida"
                               class="btn btn-secondary" style="padding: 8px 16px; font-size: 13px;" target="_blank">
                                <i data-feather="printer" style="width: 14px; height: 14px;"></i>
                                Cetak Semua (<span id="countIbtida"><?php echo e($santriIbtida->count()); ?></span>)
                            </a>
                            <a href="javascript:void(0)" 
                               onclick="window.open('<?php echo e(route('pendidikan.ijazah.cetak', ['type' => 'ibtida', 'kelasId' => $kelasIbtida->id])); ?>?download=1', '_blank')"
                               id="btnUnduhSemuaIbtida"
                               class="btn btn-primary" style="padding: 8px 16px; font-size: 13px; background: #059669; border: none;">
                                <i data-feather="download-cloud" style="width: 14px; height: 14px;"></i>
                                Unduh Semua
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="table-container">
                    <table class="table" id="tableIbtida" style="font-size: 12px;">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama Santri</th>
                                <th>NIS</th>
                                <th>Jenis Kelamin</th>
                                <th style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $santriIbtida; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr data-gender="<?php echo e($santri->gender); ?>">
                                    <td><?php echo e($index + 1); ?></td>
                                    <td style="font-weight: 600;"><?php echo e($santri->nama_santri); ?></td>
                                    <td><?php echo e($santri->nis); ?></td>
                                    <td>
                                        <span class="badge" style="background: <?php echo e($santri->gender == 'putra' ? '#dbeafe' : '#fce7f3'); ?>; color: <?php echo e($santri->gender == 'putra' ? '#1e40af' : '#be185d'); ?>; padding: 4px 10px; font-size: 11px;">
                                            <?php echo e($santri->gender == 'putra' ? 'Putra' : 'Putri'); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('pendidikan.ijazah.cetak-santri', ['type' => 'ibtida', 'santriId' => $santri->id])); ?>" 
                                           class="btn btn-secondary" style="padding: 6px 12px; font-size: 11px;" target="_blank">
                                            <i data-feather="printer" style="width: 12px; height: 12px;"></i>
                                            Cetak
                                        </a>
                                        <a href="javascript:void(0)" 
                                           onclick="window.open('<?php echo e(route('pendidikan.ijazah.cetak-santri', ['type' => 'ibtida', 'santriId' => $santri->id])); ?>?download=1', '_blank')"
                                           class="btn btn-primary" style="padding: 6px 12px; font-size: 11px; background: #059669; border: none;">
                                            <i data-feather="download" style="width: 12px; height: 12px;"></i>
                                            Unduh
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 40px; color: #666;">
                    <i data-feather="users" style="width: 48px; height: 48px; opacity: 0.3;"></i>
                    <p style="margin-top: 12px;">Tidak ada santri di Kelas 3 Ibtida</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Ijazah Tsanawi Section -->
    <div style="background: white; border-radius: 10px; padding: 0; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid rgba(59,130,246,0.1); overflow: hidden;">
        <div style="padding: 16px 20px; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-bottom: 2px solid #3b82f6;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 16px; font-weight: 600; margin: 0; color: #1e40af; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="award" style="width: 18px; height: 18px;"></i>
                    Ijazah Tsanawi
                    <span style="font-size: 12px; font-weight: 400; color: #666; margin-left: 8px;">
                        Untuk santri yang lulus dari Kelas 3 Tsanawi
                    </span>
                </h3>
            </div>
        </div>
        <div style="padding: 20px;">
            <?php if($kelasTsanawi && $santriTsanawi->count() > 0): ?>
                <!-- Gender Filter -->
                <div style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; border: 1.5px solid #bfdbfe; display: flex; align-items: center; gap: 16px;">
                    <label style="font-size: 13px; font-weight: 600; color: #1e40af; display: flex; align-items: center; gap: 6px;">
                        <i data-feather="filter" style="width: 14px; height: 14px;"></i>
                        Filter Gender:
                    </label>
                    <select id="filterGenderTsanawi" class="form-select" style="font-size: 13px; border: 1.5px solid #d1d5db; border-radius: 6px; padding: 6px 12px; min-width: 150px;">
                        <option value="all">Semua</option>
                        <option value="putra">Putra</option>
                        <option value="putri">Putri</option>
                    </select>
                    <?php if($kelasTsanawi): ?>
                        <div style="margin-left: auto; display: flex; gap: 8px;">
                            <a href="<?php echo e(route('pendidikan.ijazah.cetak', ['type' => 'tsanawi', 'kelasId' => $kelasTsanawi->id])); ?>" 
                               id="btnCetakSemuaTsanawi"
                               class="btn btn-secondary" style="padding: 8px 16px; font-size: 13px;" target="_blank">
                                <i data-feather="printer" style="width: 14px; height: 14px;"></i>
                                Cetak Semua (<span id="countTsanawi"><?php echo e($santriTsanawi->count()); ?></span>)
                            </a>
                            <a href="javascript:void(0)" 
                               onclick="window.open('<?php echo e(route('pendidikan.ijazah.cetak', ['type' => 'tsanawi', 'kelasId' => $kelasTsanawi->id])); ?>?download=1', '_blank')"
                               id="btnUnduhSemuaTsanawi"
                               class="btn btn-primary" style="padding: 8px 16px; font-size: 13px; background: #059669; border: none;">
                                <i data-feather="download-cloud" style="width: 14px; height: 14px;"></i>
                                Unduh Semua
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="table-container">
                    <table class="table" id="tableTsanawi" style="font-size: 12px;">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama Santri</th>
                                <th>NIS</th>
                                <th>Jenis Kelamin</th>
                                <th style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $santriTsanawi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr data-gender="<?php echo e($santri->gender); ?>">
                                    <td><?php echo e($index + 1); ?></td>
                                    <td style="font-weight: 600;"><?php echo e($santri->nama_santri); ?></td>
                                    <td><?php echo e($santri->nis); ?></td>
                                    <td>
                                        <span class="badge" style="background: <?php echo e($santri->gender == 'putra' ? '#dbeafe' : '#fce7f3'); ?>; color: <?php echo e($santri->gender == 'putra' ? '#1e40af' : '#be185d'); ?>; padding: 4px 10px; font-size: 11px;">
                                            <?php echo e($santri->gender == 'putra' ? 'Putra' : 'Putri'); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('pendidikan.ijazah.cetak-santri', ['type' => 'tsanawi', 'santriId' => $santri->id])); ?>" 
                                           class="btn btn-secondary" style="padding: 6px 12px; font-size: 11px;" target="_blank">
                                            <i data-feather="printer" style="width: 12px; height: 12px;"></i>
                                            Cetak
                                        </a>
                                        <a href="javascript:void(0)" 
                                           onclick="window.open('<?php echo e(route('pendidikan.ijazah.cetak-santri', ['type' => 'tsanawi', 'santriId' => $santri->id])); ?>?download=1', '_blank')"
                                           class="btn btn-primary" style="padding: 6px 12px; font-size: 11px; background: #059669; border: none;">
                                            <i data-feather="download" style="width: 12px; height: 12px;"></i>
                                            Unduh
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 40px; color: #666;">
                    <i data-feather="users" style="width: 48px; height: 48px; opacity: 0.3;"></i>
                    <p style="margin-top: 12px;">Tidak ada santri di Kelas 3 Tsanawi</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Actions Bottom -->
    <div style="margin-top: 30px; display: flex; justify-content: center;">
        <a href="<?php echo e(route('pendidikan.settings')); ?>" style="display: flex; align-items: center; gap: 8px; padding: 12px 24px; background: white; border: 1px solid #cbd5e1; border-radius: 50px; color: #475569; font-weight: 500; text-decoration: none; box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: all 0.2s;"
           onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px rgba(0,0,0,0.1)';"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.05)';">
            <i data-feather="settings" style="width: 18px; height: 18px; color: #64748b;"></i>
            Pengaturan Rapor Digital (TTD & Logo)
        </a>
    </div>

    <!-- Footer Credit -->
    <div style="margin-top: 40px; text-align: center; color: #94a3b8; font-size: 13px; padding-bottom: 20px;">
        <p>Dibuat oleh Mahin Utsman Nawawi, S.H</p>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function initIjazahFilters() {
        feather.replace();
        
        const baseUrlIbtida = "<?php echo e($kelasIbtida ? route('pendidikan.ijazah.cetak', ['type' => 'ibtida', 'kelasId' => $kelasIbtida->id]) : ''); ?>";
        const baseUrlTsanawi = "<?php echo e($kelasTsanawi ? route('pendidikan.ijazah.cetak', ['type' => 'tsanawi', 'kelasId' => $kelasTsanawi->id]) : ''); ?>";
        
        // Function to filter rows properly
        const filterRows = (tableId, gender, baseUrl, btnCetakId, btnUnduhId, countId) => {
            const rows = document.querySelectorAll(`#${tableId} tbody tr`);
            let visibleCount = 0;
            
            rows.forEach(row => {
                const rowGender = row.dataset.gender ? row.dataset.gender.trim().toLowerCase() : '';
                const targetGender = gender.trim().toLowerCase();
                
                if (gender === 'all' || rowGender === targetGender) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Update CETAK button URL
            const btnCetak = document.getElementById(btnCetakId);
            if (btnCetak && baseUrl) {
                btnCetak.href = gender === 'all' ? baseUrl : baseUrl + '?gender=' + gender;
            }
            
            // Update UNDUH button URL (with download=1 parameter and onclick)
            const btnUnduh = document.getElementById(btnUnduhId);
            if (btnUnduh && baseUrl) {
                const downloadUrl = gender === 'all' ? baseUrl + '?download=1' : baseUrl + '?gender=' + gender + '&download=1';
                btnUnduh.onclick = function() { window.open(downloadUrl, '_blank'); return false; };
            }
            
            // Update count
            const countSpan = document.getElementById(countId);
            if (countSpan) countSpan.textContent = visibleCount;
        };

        // Gender filter for Ibtida
        document.getElementById('filterGenderIbtida')?.addEventListener('change', function() {
            filterRows('tableIbtida', this.value, baseUrlIbtida, 'btnCetakSemuaIbtida', 'btnUnduhSemuaIbtida', 'countIbtida');
        });
        
        // Gender filter for Tsanawi
        document.getElementById('filterGenderTsanawi')?.addEventListener('change', function() {
            filterRows('tableTsanawi', this.value, baseUrlTsanawi, 'btnCetakSemuaTsanawi', 'btnUnduhSemuaTsanawi', 'countTsanawi');
        });
    }

    // Initialize on load and turbo:load
    document.addEventListener('turbo:load', initIjazahFilters);
    // Also run immediately in case it's a first page load
    initIjazahFilters();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\pendidikan\ijazah\index.blade.php ENDPATH**/ ?>