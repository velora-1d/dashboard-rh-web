

<?php $__env->startSection('title', 'Absensi Santri - Alfa per 2 Minggu'); ?>
<?php $__env->startSection('page-title', 'Absensi Santri'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('pendidikan.partials.sidebar-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success" style="background-color: var(--color-primary-lightest); color: var(--color-primary-dark); padding: var(--spacing-md); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg); border: 1px solid var(--color-primary-light);">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <h2 style="font-size: var(--font-size-xl); font-weight: var(--font-weight-semibold); color: var(--color-gray-900); margin-bottom: var(--spacing-xl);">
        Rekap Alfa per 2 Minggu
    </h2>

    <!-- Filter Bar: Clean & Modern Layout -->
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-bottom: 24px; padding: 18px 24px; background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%); border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;">
        <!-- Left Group: 4 Kegiatan + Activity Badges + Actions -->
        <div style="display: flex; align-items: center; gap: 16px;">
            <!-- 4 Kegiatan Label -->
            <div style="display: flex; align-items: center; gap: 8px; padding-right: 16px; border-right: 2px solid #e2e8f0;">
                <span style="font-size: 11px; font-weight: 700; color: #0d9488; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">
                    <i data-feather="activity" style="width: 14px; height: 14px; margin-right: 4px; vertical-align: middle;"></i>
                    4 Kegiatan
                </span>
            </div>
            
            <!-- Activity Badges -->
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="display: inline-flex; align-items: center; gap: 4px; padding: 8px 12px; font-size: 11px; font-weight: 600; color: white; background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%); border-radius: 7px; box-shadow: 0 2px 4px rgba(13,148,136,0.25); white-space: nowrap;">
                    <i data-feather="book" style="width: 13px; height: 13px;"></i>
                    Sorogan
                </span>
                <span style="display: inline-flex; align-items: center; gap: 4px; padding: 8px 12px; font-size: 11px; font-weight: 600; color: white; background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%); border-radius: 7px; box-shadow: 0 2px 4px rgba(13,148,136,0.25); white-space: nowrap;">
                    <i data-feather="moon" style="width: 13px; height: 13px;"></i>
                    Menghafal Malam
                </span>
                <span style="display: inline-flex; align-items: center; gap: 4px; padding: 8px 12px; font-size: 11px; font-weight: 600; color: white; background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%); border-radius: 7px; box-shadow: 0 2px 4px rgba(13,148,136,0.25); white-space: nowrap;">
                    <i data-feather="sunrise" style="width: 13px; height: 13px;"></i>
                    Menghafal Subuh
                </span>
                <span style="display: inline-flex; align-items: center; gap: 4px; padding: 8px 12px; font-size: 11px; font-weight: 600; color: white; background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%); border-radius: 7px; box-shadow: 0 2px 4px rgba(13,148,136,0.25); white-space: nowrap;">
                    <i data-feather="star" style="width: 13px; height: 13px;"></i>
                    Tahajud
                </span>
            </div>
            
            <!-- Action Buttons -->
            <div style="display: flex; align-items: center; gap: 8px; padding-left: 16px; border-left: 2px solid #e2e8f0;">
                <button onclick="toggleBulkInput()" style="display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; font-size: 12px; font-weight: 600; color: white; background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%); border: none; border-radius: 8px; box-shadow: 0 2px 6px rgba(22,163,74,0.3); cursor: pointer; white-space: nowrap; transition: all 0.2s;">
                    <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                    Input Alfa
                </button>
                <a href="<?php echo e(route('pendidikan.absensi.rekap')); ?>" style="display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; font-size: 12px; font-weight: 600; color: #374151; background: #f3f4f6; border: 1px solid #d1d5db; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); text-decoration: none; white-space: nowrap; transition: all 0.2s;">
                    <i data-feather="bar-chart-2" style="width: 14px; height: 14px;"></i>
                    Rekap
                </a>
            </div>
        </div>
        
        <!-- Right Group: Filters -->
        <form method="GET" action="<?php echo e(route('pendidikan.absensi')); ?>" style="display: flex; align-items: center; gap: 8px; margin-left: auto;">
            <input type="number" name="tahun" value="<?php echo e(request('tahun', $currentYear)); ?>" style="padding: 8px 12px; font-size: 12px; border: 1px solid #d1d5db; border-radius: 7px; width: 80px; outline: none; transition: all 0.2s;" placeholder="Tahun" onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,0.1)'" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
            
            <input type="number" name="minggu_ke" value="<?php echo e(request('minggu_ke')); ?>" style="padding: 8px 12px; font-size: 12px; border: 1px solid #d1d5db; border-radius: 7px; width: 90px; outline: none; transition: all 0.2s;" placeholder="Minggu" onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,0.1)'" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
            
            <select name="kelas_id" style="padding: 8px 12px; font-size: 12px; border: 1px solid #d1d5db; border-radius: 7px; width: 140px; outline: none; transition: all 0.2s; background: white;" onchange="this.form.submit()" onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,0.1)'" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
                <option value="">Semua Kelas</option>
                <?php $__currentLoopData = $kelasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($kelas->id); ?>" <?php echo e(request('kelas_id') == $kelas->id ? 'selected' : ''); ?>><?php echo e($kelas->nama_kelas); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            
            <select name="gender" style="padding: 8px 12px; font-size: 12px; border: 1px solid #d1d5db; border-radius: 7px; width: 100px; outline: none; transition: all 0.2s; background: white;" onchange="this.form.submit()" onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 3px rgba(22,163,74,0.1)'" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
                <option value="">Semua</option>
                <option value="putra" <?php echo e(request('gender') == 'putra' ? 'selected' : ''); ?>>Putra</option>
                <option value="putri" <?php echo e(request('gender') == 'putri' ? 'selected' : ''); ?>>Putri</option>
            </select>
            
            <button type="submit" style="display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; font-size: 12px; font-weight: 600; color: white; background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%); border: none; border-radius: 8px; box-shadow: 0 2px 6px rgba(22,163,74,0.3); cursor: pointer; white-space: nowrap; transition: all 0.2s;">
                <i data-feather="filter" style="width: 14px; height: 14px;"></i>
                Filter
            </button>
            
            <button type="submit" formaction="<?php echo e(route('pendidikan.absensi.cetak')); ?>" formtarget="_blank" style="display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; font-size: 12px; font-weight: 600; color: #374151; background: #f3f4f6; border: 1px solid #d1d5db; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); cursor: pointer; white-space: nowrap; transition: all 0.2s;">
                <i data-feather="printer" style="width: 14px; height: 14px;"></i>
                Cetak
            </button>
            
            <?php if(request()->has('minggu_ke') || request()->has('kelas_id') || request()->has('gender') || request('tahun', $currentYear) != $currentYear): ?>
                <a href="<?php echo e(route('pendidikan.absensi')); ?>" style="display: inline-flex; align-items: center; justify-content: center; padding: 9px 12px; font-size: 12px; font-weight: 600; color: #374151; background: #f3f4f6; border: 1px solid #d1d5db; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); text-decoration: none; white-space: nowrap; transition: all 0.2s;" title="Reset">
                    <i data-feather="x" style="width: 14px; height: 14px;"></i>
                </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Bulk Input Form -->
    <div id="bulkInputForm" class="card" style="display: none; margin-bottom: var(--spacing-xl);">
        <h3 class="card-header">Input Alfa per 2 Minggu</h3>
        <form method="POST" action="<?php echo e(route('pendidikan.absensi.store')); ?>" id="alfaForm">
            <?php echo csrf_field(); ?>
            <div class="grid grid-cols-4 gap-4" style="margin-bottom: var(--spacing-md);">
                <div class="form-group">
                    <label class="form-label">Kelas</label>
                    <select name="kelas_id" id="kelasSelect" class="form-select w-full rounded-lg border-gray-300 focus:ring-blue-500" required onchange="loadSantriByKelas()">
                        <option value="">Pilih Kelas</option>
                        <?php $__currentLoopData = $kelasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($kelas->id); ?>"><?php echo e($kelas->nama_kelas); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tahun</label>
                    <select name="tahun" id="tahunSelect" class="form-select w-full rounded-lg" onchange="updateWeekNumber()">
                        <?php $__currentLoopData = range(date('Y')-1, date('Y')+3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($y); ?>" <?php echo e($y == $currentYear ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Bulan</label>
                    <select id="bulanSelect" class="form-select w-full rounded-lg" onchange="updateWeekNumber()">
                        <?php
                            $months = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];
                            $currentMonth = date('n');
                        ?>
                        <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($num); ?>" <?php echo e($num == $currentMonth ? 'selected' : ''); ?>><?php echo e($name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Minggu Ke-</label>
                    <select id="mingguBulanSelect" class="form-select w-full rounded-lg" onchange="updateWeekNumber()">
                        <option value="1">Minggu 1</option>
                        <option value="2">Minggu 2</option>
                        <option value="3">Minggu 3</option>
                        <option value="4" selected>Minggu 4</option>
                    </select>
                    <input type="hidden" name="minggu_ke" id="mingguKeHidden" value="<?php echo e($currentWeek); ?>">
                    <small style="color: #666; font-size: 11px;">Week #<span id="weekNumDisplay"><?php echo e($currentWeek); ?></span></small>
                </div>
            </div>

            <script>
                function updateWeekNumber() {
                    let year = document.getElementById('tahunSelect').value;
                    let month = document.getElementById('bulanSelect').value;
                    let week = document.getElementById('mingguBulanSelect').value;
                    
                    let day = 1 + (week - 1) * 7;
                    let d = new Date(year, month - 1, day);
                    
                    d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
                    d.setUTCDate(d.getUTCDate() + 4 - (d.getUTCDay()||7));
                    var yearStart = new Date(Date.UTC(d.getUTCFullYear(),0,1));
                    var weekNo = Math.ceil(( ( (d - yearStart) / 86400000) + 1)/7);
                    
                    document.getElementById('mingguKeHidden').value = weekNo;
                    if(document.getElementById('weekNumDisplay')) {
                        document.getElementById('weekNumDisplay').innerText = weekNo;
                    }
                }
                document.addEventListener('DOMContentLoaded', function() {
                    if (typeof updateWeekNumber === 'function') {
                        updateWeekNumber();
                    }
                });
            </script>

            <div id="santriList" style="display: none;">
                <h4 style="margin-bottom: var(--spacing-md); font-size: var(--font-size-lg);">Input Jumlah Alfa per Santri</h4>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 40px;">No</th>
                                <th>NIS</th>
                                <th>Nama Santri</th>
                                <th style="width: 100px;">Sorogan</th>
                                <th style="width: 100px;">Menghafal Malam</th>
                                <th style="width: 100px;">Menghafal Subuh</th>
                                <th style="width: 100px;">Tahajud</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="santriTableBody">
                            <!-- Populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-primary" style="margin-top: var(--spacing-md);">
                    <i data-feather="save" style="width: 16px; height: 16px;"></i>
                    Simpan Data Alfa
                </button>
                <button type="button" onclick="toggleBulkInput()" class="btn btn-secondary" style="margin-top: var(--spacing-md);">
                    Batal
                </button>
            </div>
        </form>
    </div>

    <!-- Filter section removed - now integrated in header above -->
    <div style="display: none;">
        <form method="GET" action="<?php echo e(route('pendidikan.absensi')); ?>" style="display: none;">
            <div style="min-width: 80px;">
                <label style="font-size: 11px; font-weight: 600; margin-bottom: 2px; display: block; color: #374151;">Tahun</label>
                <input type="number" name="tahun" value="<?php echo e(request('tahun', $currentYear)); ?>" class="form-input" style="padding: 6px 8px; font-size: 12px; height: 34px; width: 100%;" placeholder="Tahun">
            </div>

            <div style="min-width: 100px;">
                <label style="font-size: 11px; font-weight: 600; margin-bottom: 2px; display: block; color: #374151;">Minggu Ke-</label>
                <input type="number" name="minggu_ke" value="<?php echo e(request('minggu_ke')); ?>" class="form-input" style="padding: 6px 8px; font-size: 12px; height: 34px; width: 100%;" placeholder="Semua">
            </div>

            <div style="min-width: 130px;">
                <label style="font-size: 11px; font-weight: 600; margin-bottom: 2px; display: block; color: #374151;">Kelas</label>
                <select name="kelas_id" class="form-select" style="padding: 6px 8px; font-size: 12px; height: 34px; width: 100%;" onchange="this.form.submit()">
                    <option value="">Semua Kelas</option>
                    <?php $__currentLoopData = $kelasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($kelas->id); ?>" <?php echo e(request('kelas_id') == $kelas->id ? 'selected' : ''); ?>>
                            <?php echo e($kelas->nama_kelas); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div style="min-width: 100px;">
                <label style="font-size: 11px; font-weight: 600; margin-bottom: 2px; display: block; color: #374151;">Gender</label>
                <select name="gender" class="form-select" style="padding: 6px 8px; font-size: 12px; height: 34px; width: 100%;" onchange="this.form.submit()">
                    <option value="">Semua</option>
                    <option value="putra" <?php echo e(request('gender') == 'putra' ? 'selected' : ''); ?>>Putra</option>
                    <option value="putri" <?php echo e(request('gender') == 'putri' ? 'selected' : ''); ?>>Putri</option>
                </select>
            </div>

            <div style="display: flex; gap: 6px;">
                <button type="submit" class="btn btn-primary" style="padding: 6px 14px; font-size: 12px; height: 34px; white-space: nowrap;">
                    <i data-feather="filter" style="width: 14px; height: 14px; margin-right: 4px;"></i>
                    Filter
                </button>
                <button type="submit" formaction="<?php echo e(route('pendidikan.absensi.cetak')); ?>" formtarget="_blank" class="btn btn-secondary" style="padding: 6px 14px; font-size: 12px; height: 34px; display: flex; align-items: center; gap: 4px; white-space: nowrap;">
                    <i data-feather="printer" style="width: 14px; height: 14px;"></i>
                    Cetak
                </button>
                <?php if(request()->has('minggu_ke') || request()->has('kelas_id') || request()->has('gender') || request('tahun', $currentYear) != $currentYear): ?>
                    <a href="<?php echo e(route('pendidikan.absensi')); ?>" class="btn btn-secondary" style="padding: 6px 14px; font-size: 12px; height: 34px; display: flex; align-items: center; white-space: nowrap;">
                        <i data-feather="x" style="width: 14px; height: 14px; margin-right: 4px;"></i>
                        Reset
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Periode</th>
                    <th>NIS</th>
                    <th>Nama Santri</th>
                    <th>Kelas</th>
                    <th style="text-align: center;">Sorogan</th>
                    <th style="text-align: center;">Menghafal Malam</th>
                    <th style="text-align: center;">Menghafal Subuh</th>
                    <th style="text-align: center;">Tahajud</th>
                    <th style="text-align: center;">Total Alfa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $absensi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr id="row-<?php echo e($a->id); ?>">
                        <td style="text-align: center; font-weight: 600;"><?php echo e($absensi->firstItem() + $index); ?></td>
                        <td>
                            <strong>Minggu <?php echo e($a->minggu_ke); ?>, <?php echo e($a->tahun); ?></strong><br>
                            <small style="color: var(--color-gray-600);">
                                <?php echo e($a->tanggal_mulai->format('d/m/Y')); ?> - <?php echo e($a->tanggal_selesai->format('d/m/Y')); ?>

                            </small>
                        </td>
                        <td><?php echo e($a->santri->nis ?? '-'); ?></td>
                        <td><?php echo e($a->santri->nama_santri ?? '-'); ?></td>
                        <td><?php echo e($a->kelas->nama_kelas ?? '-'); ?></td>
                        <td style="text-align: center;"><span class="badge <?php echo e($a->alfa_sorogan > 0 ? 'badge-error' : 'badge-success'); ?>"><?php echo e($a->alfa_sorogan); ?></span></td>
                        <td style="text-align: center;"><span class="badge <?php echo e($a->alfa_menghafal_malam > 0 ? 'badge-error' : 'badge-success'); ?>"><?php echo e($a->alfa_menghafal_malam); ?></span></td>
                        <td style="text-align: center;"><span class="badge <?php echo e($a->alfa_menghafal_subuh > 0 ? 'badge-error' : 'badge-success'); ?>"><?php echo e($a->alfa_menghafal_subuh); ?></span></td>
                        <td style="text-align: center;"><span class="badge <?php echo e($a->alfa_tahajud > 0 ? 'badge-error' : 'badge-success'); ?>"><?php echo e($a->alfa_tahajud); ?></span></td>
                        <td style="text-align: center;"><strong><?php echo e($a->total_alfa); ?></strong></td>
                        <td>
                            <button onclick="toggleEdit(<?php echo e($a->id); ?>)" class="btn btn-secondary" style="padding: 4px 12px; font-size: 12px;">
                                <i data-feather="edit" style="width: 14px; height: 14px;"></i>
                                Edit
                            </button>
                            <form method="POST" action="<?php echo e(route('pendidikan.absensi.destroy', $a->id)); ?>" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-secondary" style="padding: 4px 12px; font-size: 12px; background-color: #f44336;">
                                    <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    <tr id="edit-<?php echo e($a->id); ?>" style="display: none;">
                        <td colspan="11" style="background-color: #f5f5f5; padding: var(--spacing-lg);">
                            <form method="POST" action="<?php echo e(route('pendidikan.absensi.update', $a->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <div class="grid grid-cols-4" style="gap: var(--spacing-md); margin-bottom: var(--spacing-md);">
                                    <div class="form-group">
                                        <label class="form-label">Alfa Sorogan</label>
                                        <input type="number" name="alfa_sorogan" class="form-input" value="<?php echo e($a->alfa_sorogan); ?>" min="0" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Alfa Menghafal Malam</label>
                                        <input type="number" name="alfa_menghafal_malam" class="form-input" value="<?php echo e($a->alfa_menghafal_malam); ?>" min="0" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Alfa Menghafal Subuh</label>
                                        <input type="number" name="alfa_menghafal_subuh" class="form-input" value="<?php echo e($a->alfa_menghafal_subuh); ?>" min="0" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Alfa Tahajud</label>
                                        <input type="number" name="alfa_tahajud" class="form-input" value="<?php echo e($a->alfa_tahajud); ?>" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: var(--spacing-md);">
                                    <label class="form-label">Keterangan</label>
                                    <input type="text" name="keterangan" class="form-input" value="<?php echo e($a->keterangan); ?>">
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" onclick="toggleEdit(<?php echo e($a->id); ?>)" class="btn btn-secondary">Batal</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <tr>
                        <td colspan="11" style="text-align: center; padding: 40px; color: var(--color-gray-500);">
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 12px;">
                                <div style="background: #f3f4f6; padding: 12px; border-radius: 50%;">
                                    <i data-feather="inbox" style="width: 24px; height: 24px; color: #9ca3af;"></i>
                                </div>
                                <p style="font-size: 14px; margin: 0;">Belum ada data absensi yang tersedia.</p>
                                <button onclick="toggleBulkInput()" class="btn btn-primary" style="padding: 8px 16px; font-size: 13px;">
                                    <i data-feather="plus" style="width: 14px; height: 14px; margin-right: 6px;"></i>
                                    Input Alfa Baru
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($absensi->hasPages()): ?>
        <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center; padding: 16px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <!-- Showing info -->
            <div style="font-size: 13px; color: #666;">
                Menampilkan <strong><?php echo e($absensi->firstItem()); ?></strong> - <strong><?php echo e($absensi->lastItem()); ?></strong> dari <strong><?php echo e($absensi->total()); ?></strong> data
            </div>
            
            <!-- Pagination buttons -->
            <div style="display: flex; gap: 8px; align-items: center;">
                
                <?php if($absensi->onFirstPage()): ?>
                    <span style="padding: 8px 16px; background: #f5f5f5; color: #ccc; border-radius: 6px; font-size: 13px; cursor: not-allowed; display: inline-flex; align-items: center; gap: 6px;">
                        <i data-feather="chevron-left" style="width: 16px; height: 16px;"></i>
                        Previous
                    </span>
                <?php else: ?>
                    <a href="<?php echo e($absensi->previousPageUrl()); ?>" style="padding: 8px 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 500; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(102,126,234,0.4)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
                        <i data-feather="chevron-left" style="width: 16px; height: 16px;"></i>
                        Previous
                    </a>
                <?php endif; ?>

                
                <div style="display: flex; gap: 4px;">
                    <?php
                        $start = max($absensi->currentPage() - 2, 1);
                        $end = min($start + 4, $absensi->lastPage());
                        $start = max($end - 4, 1);
                    ?>

                    <?php if($start > 1): ?>
                        <a href="<?php echo e($absensi->url(1)); ?>" style="min-width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 500; background: #f5f5f5; color: #666; transition: all 0.2s;" onmouseover="this.style.background='#e0e0e0'" onmouseout="this.style.background='#f5f5f5'">
                            1
                        </a>
                        <?php if($start > 2): ?>
                            <span style="min-width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; color: #999;">...</span>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php for($i = $start; $i <= $end; $i++): ?>
                        <?php if($i == $absensi->currentPage()): ?>
                            <span style="min-width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; font-size: 13px; font-weight: 600; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; box-shadow: 0 2px 8px rgba(102,126,234,0.3);">
                                <?php echo e($i); ?>

                            </span>
                        <?php else: ?>
                            <a href="<?php echo e($absensi->url($i)); ?>" style="min-width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 500; background: #f5f5f5; color: #666; transition: all 0.2s;" onmouseover="this.style.background='#e0e0e0'" onmouseout="this.style.background='#f5f5f5'">
                                <?php echo e($i); ?>

                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if($end < $absensi->lastPage()): ?>
                        <?php if($end < $absensi->lastPage() - 1): ?>
                            <span style="min-width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; color: #999;">...</span>
                        <?php endif; ?>
                        <a href="<?php echo e($absensi->url($absensi->lastPage())); ?>" style="min-width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 500; background: #f5f5f5; color: #666; transition: all 0.2s;" onmouseover="this.style.background='#e0e0e0'" onmouseout="this.style.background='#f5f5f5'">
                            <?php echo e($absensi->lastPage()); ?>

                        </a>
                    <?php endif; ?>
                </div>

                
                <?php if($absensi->hasMorePages()): ?>
                    <a href="<?php echo e($absensi->nextPageUrl()); ?>" style="padding: 8px 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 500; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(102,126,234,0.4)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
                        Next
                        <i data-feather="chevron-right" style="width: 16px; height: 16px;"></i>
                    </a>
                <?php else: ?>
                    <span style="padding: 8px 16px; background: #f5f5f5; color: #ccc; border-radius: 6px; font-size: 13px; cursor: not-allowed; display: inline-flex; align-items: center; gap: 6px;">
                        Next
                        <i data-feather="chevron-right" style="width: 16px; height: 16px;"></i>
                    </span>
                <?php endif; ?>
            </div>
        </div>
        
        <script>
            // Replace feather icons after pagination renders
            setTimeout(() => feather.replace(), 100);
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const santriData = <?php echo json_encode($santriList, 15, 512) ?>;

function toggleBulkInput() {
    const form = document.getElementById('bulkInputForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
    if (form.style.display === 'block') {
        document.getElementById('kelasSelect').value = '';
        document.getElementById('santriList').style.display = 'none';
        
        // Trigger update week number on open
        if(typeof updateWeekNumber === 'function') updateWeekNumber();
    }
}

function loadSantriByKelas() {
    const kelasId = document.getElementById('kelasSelect').value;
    if (!kelasId) {
        document.getElementById('santriList').style.display = 'none';
        return;
    }

    const filteredSantri = santriData.filter(s => s.kelas_id == kelasId);
    const tbody = document.getElementById('santriTableBody');
    tbody.innerHTML = '';

    filteredSantri.forEach((santri, index) => {
        const row = `
            <tr>
                <td>${index + 1}</td>
                <td>${santri.nis}</td>
                <td>${santri.nama_santri}</td>
                <td>
                    <input type="hidden" name="santri[${index}][id]" value="${santri.id}">
                    <input type="number" name="santri[${index}][alfa_sorogan]" class="form-input" value="0" min="0" required style="margin: 0; width: 80px;">
                </td>
                <td>
                    <input type="number" name="santri[${index}][alfa_menghafal_malam]" class="form-input" value="0" min="0" required style="margin: 0; width: 80px;">
                </td>
                <td>
                    <input type="number" name="santri[${index}][alfa_menghafal_subuh]" class="form-input" value="0" min="0" required style="margin: 0; width: 80px;">
                </td>
                <td>
                    <input type="number" name="santri[${index}][alfa_tahajud]" class="form-input" value="0" min="0" required style="margin: 0; width: 80px;">
                </td>
                <td>
                    <input type="text" name="santri[${index}][keterangan]" class="form-input" placeholder="Opsional" style="margin: 0;">
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });

    document.getElementById('santriList').style.display = 'block';
    feather.replace();
}

function toggleEdit(id) {
    const row = document.getElementById('row-' + id);
    const editRow = document.getElementById('edit-' + id);
    
    if (editRow.style.display === 'none') {
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\pendidikan\absensi\index.blade.php ENDPATH**/ ?>