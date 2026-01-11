<?php $__env->startSection('title', 'Dashboard Pendidikan'); ?>
<?php $__env->startSection('page-title', 'Dashboard Pendidikan'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('pendidikan.partials.sidebar-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Prevent layout shift on initial load */
    .main-content {
        min-height: 100vh;
    }
    
    /* Optimize grid rendering */
    [style*="display: grid"] {
        will-change: contents;
        contain: layout style paint;
    }
    
    /* Hide Scrollbars for cleaner look */
    body {
        overflow-x: hidden;
    }
    
    /* Hide scrollbar for Chrome, Safari and Opera */
    ::-webkit-scrollbar {
        width: 0px;
        background: transparent;
    }
    
    /* Hide scrollbar for IE, Edge and Firefox */
    * {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
    
    /* Make filter section sticky and elegant - MUST stay below page header */
    .filter-sticky {
        position: sticky;
        top: 100px; /* Position below the page-header which is at top: 0 */
        z-index: 90; /* Lower than page-header (z-index: 100) */
        background: white;
        padding-top: 20px;
        margin-bottom: 24px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success" style="background-color: var(--color-primary-lightest); color: var(--color-primary-dark); padding: var(--spacing-md); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg); border: 1px solid var(--color-primary-light);">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>


    <!-- Sticky Header and Filter Container -->
    <div class="filter-sticky">
        <form method="GET" action="<?php echo e(route('pendidikan.dashboard')); ?>" style="width: 100%;">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px 24px; border-radius: 12px;">
                <!-- Single Row Filter Layout -->
                <div style="display: flex; align-items: flex-end; gap: 12px;">
                    <!-- Filter 1: Tahun Ajaran -->
                    <div style="display: flex; flex-direction: column; gap: 4px; flex: 1; min-width: 140px;">
                        <label style="font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.95); text-transform: uppercase; letter-spacing: 0.5px; margin: 0; display: flex; align-items: center; gap: 4px;">
                            <i data-feather="calendar" style="width: 11px; height: 11px;"></i>
                            Tahun Ajaran
                        </label>
                        <select name="tahun_ajaran" 
                            style="height: 38px; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; padding: 0 10px; font-size: 13px; background: rgba(255,255,255,0.98); color: #1f2937; font-weight: 500; cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.borderColor='rgba(255,255,255,0.5)';"
                            onmouseout="this.style.borderColor='rgba(255,255,255,0.3)';">
                            <?php $__currentLoopData = $tahunAjaranList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($ta); ?>" <?php echo e($tahunAjaran == $ta ? 'selected' : ''); ?>><?php echo e($ta); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Filter 2: Semester -->
                    <div style="display: flex; flex-direction: column; gap: 4px; flex: 0.8; min-width: 120px;">
                        <label style="font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.95); text-transform: uppercase; letter-spacing: 0.5px; margin: 0; display: flex; align-items: center; gap: 4px;">
                            <i data-feather="book" style="width: 11px; height: 11px;"></i>
                            Semester
                        </label>
                        <select name="semester" 
                            style="height: 38px; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; padding: 0 10px; font-size: 13px; background: rgba(255,255,255,0.98); color: #1f2937; font-weight: 500; cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.borderColor='rgba(255,255,255,0.5)';"
                            onmouseout="this.style.borderColor='rgba(255,255,255,0.3)';">
                            <option value="1" <?php echo e($semester == '1' ? 'selected' : ''); ?>>Semester 1</option>
                            <option value="2" <?php echo e($semester == '2' ? 'selected' : ''); ?>>Semester 2</option>
                        </select>
                    </div>

                    <!-- Filter 3: Kelas -->
                    <div style="display: flex; flex-direction: column; gap: 4px; flex: 1; min-width: 130px;">
                        <label style="font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.95); text-transform: uppercase; letter-spacing: 0.5px; margin: 0; display: flex; align-items: center; gap: 4px;">
                            <i data-feather="users" style="width: 11px; height: 11px;"></i>
                            Kelas
                        </label>
                        <select name="kelas_id" 
                            style="height: 38px; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; padding: 0 10px; font-size: 13px; background: rgba(255,255,255,0.98); color: #1f2937; font-weight: 500; cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.borderColor='rgba(255,255,255,0.5)';"
                            onmouseout="this.style.borderColor='rgba(255,255,255,0.3)';">
                            <option value="">Semua Kelas</option>
                            <?php $__currentLoopData = $kelasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($kelas->id); ?>" <?php echo e($kelasId == $kelas->id ? 'selected' : ''); ?>><?php echo e($kelas->nama_kelas); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Filter 4: Gender -->
                    <div style="display: flex; flex-direction: column; gap: 4px; flex: 0.9; min-width: 130px;">
                        <label style="font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.95); text-transform: uppercase; letter-spacing: 0.5px; margin: 0; display: flex; align-items: center; gap: 4px;">
                            <i data-feather="user" style="width: 11px; height: 11px;"></i>
                            Gender
                        </label>
                        <select name="gender" 
                            style="height: 38px; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; padding: 0 10px; font-size: 13px; background: rgba(255,255,255,0.98); color: #1f2937; font-weight: 500; cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.borderColor='rgba(255,255,255,0.5)';"
                            onmouseout="this.style.borderColor='rgba(255,255,255,0.3)';">
                            <option value="">Semua Gender</option>
                            <option value="L" <?php echo e($gender == 'L' ? 'selected' : ''); ?>>Laki-laki</option>
                            <option value="P" <?php echo e($gender == 'P' ? 'selected' : ''); ?>>Perempuan</option>
                        </select>
                    </div>

                    <!-- Filter 5: Mata Pelajaran -->
                    <div style="display: flex; flex-direction: column; gap: 4px; flex: 1.2; min-width: 150px;">
                        <label style="font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.95); text-transform: uppercase; letter-spacing: 0.5px; margin: 0; display: flex; align-items: center; gap: 4px;">
                            <i data-feather="layers" style="width: 11px; height: 11px;"></i>
                            Mata Pelajaran
                        </label>
                        <select name="mapel_id" 
                            style="height: 38px; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; padding: 0 10px; font-size: 13px; background: rgba(255,255,255,0.98); color: #1f2937; font-weight: 500; cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.borderColor='rgba(255,255,255,0.5)';"
                            onmouseout="this.style.borderColor='rgba(255,255,255,0.3)';">
                            <option value="">Semua Mapel</option>
                            <?php $__currentLoopData = $mapelList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mapel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($mapel->id); ?>" <?php echo e($mapelId == $mapel->id ? 'selected' : ''); ?>><?php echo e($mapel->nama_mapel); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 8px; flex-shrink: 0;">
                        <a href="<?php echo e(route('pendidikan.dashboard')); ?>" 
                            style="height: 38px; padding: 0 16px; display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; font-weight: 600; font-size: 13px; text-decoration: none; transition: all 0.2s; backdrop-filter: blur(10px);"
                            onmouseover="this.style.background='rgba(255,255,255,0.3)'; this.style.transform='translateY(-1px)';"
                            onmouseout="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='translateY(0)';">
                            <i data-feather="rotate-ccw" style="width: 14px; height: 14px;"></i>
                            Reset
                        </a>
                        <button type="submit" 
                            style="height: 38px; padding: 0 20px; display: inline-flex; align-items: center; gap: 6px; background: white; color: #667eea; border: none; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 8px rgba(0,0,0,0.15);"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.25)';"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.15)';">
                            <i data-feather="search" style="width: 14px; height: 14px;"></i>
                            Terapkan Filter
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- KPI Cards -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: var(--spacing-xl);">
        <!-- Card 1: Total Santri -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 40px rgba(102, 126, 234, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(102, 126, 234, 0.3)';">
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
                <div style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                    <i data-feather="users" style="width: 32px; height: 32px; color: white;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 13px; font-weight: 500; margin-bottom: 4px;">Total Santri Aktif</div>
                    <div style="color: white; font-size: 32px; font-weight: 700; line-height: 1;"><?php echo e(number_format($totalSantri)); ?></div>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Kelas -->
        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(240, 147, 251, 0.3); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 40px rgba(240, 147, 251, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(240, 147, 251, 0.3)';">
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
                <div style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                    <i data-feather="grid" style="width: 32px; height: 32px; color: white;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 13px; font-weight: 500; margin-bottom: 4px;">Total Kelas</div>
                    <div style="color: white; font-size: 32px; font-weight: 700; line-height: 1;"><?php echo e(number_format($totalKelas)); ?></div>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Mapel -->
        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(79, 172, 254, 0.3); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 40px rgba(79, 172, 254, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(79, 172, 254, 0.3)';">
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
                <div style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                    <i data-feather="book-open" style="width: 32px; height: 32px; color: white;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 13px; font-weight: 500; margin-bottom: 4px;">Total Mata Pelajaran</div>
                    <div style="color: white; font-size: 32px; font-weight: 700; line-height: 1;"><?php echo e(number_format($totalMapel)); ?></div>
                </div>
            </div>
        </div>

        <!-- Card 4: Rata-rata Nilai -->
        <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(67, 233, 123, 0.3); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 40px rgba(67, 233, 123, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(67, 233, 123, 0.3)';">
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
                <div style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                    <i data-feather="award" style="width: 32px; height: 32px; color: white;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 13px; font-weight: 500; margin-bottom: 4px;">Rata-rata Nilai</div>
                    <div style="color: white; font-size: 32px; font-weight: 700; line-height: 1;"><?php echo e(number_format($rataRataNilai, 2)); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row KPI Cards -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: var(--spacing-xl);">
        <!-- Card 5: Santri Berprestasi -->
        <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(250, 112, 154, 0.3); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 40px rgba(250, 112, 154, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(250, 112, 154, 0.3)';">
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
                <div style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                    <i data-feather="trending-up" style="width: 32px; height: 32px; color: white;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 13px; font-weight: 500; margin-bottom: 4px;">Santri Berprestasi</div>
                    <div style="color: white; font-size: 32px; font-weight: 700; line-height: 1;"><?php echo e($santriBerprestasi->count()); ?></div>
                </div>
            </div>
        </div>

        <!-- Card 6: Perlu Bimbingan -->
        <div style="background: linear-gradient(135deg, #ff6a00 0%, #ee0979 100%); border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(255, 106, 0, 0.3); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 40px rgba(255, 106, 0, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(255, 106, 0, 0.3)';">
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
                <div style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                    <i data-feather="trending-down" style="width: 32px; height: 32px; color: white;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 13px; font-weight: 500; margin-bottom: 4px;">Perlu Bimbingan</div>
                    <div style="color: white; font-size: 32px; font-weight: 700; line-height: 1;"><?php echo e($santriPerluBimbingan->count()); ?></div>
                </div>
            </div>
        </div>

        <!-- Card 7: Tingkat Kehadiran -->
        <div style="background: linear-gradient(135deg, #30cfd0 0%, #330867 100%); border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(48, 207, 208, 0.3); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 40px rgba(48, 207, 208, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(48, 207, 208, 0.3)';">
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
                <div style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                    <i data-feather="check-circle" style="width: 32px; height: 32px; color: white;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 13px; font-weight: 500; margin-bottom: 4px;">Tingkat Kehadiran</div>
                    <div style="color: white; font-size: 32px; font-weight: 700; line-height: 1;"><?php echo e(number_format($tingkatKehadiran)); ?>%</div>
                </div>
            </div>
        </div>

        <!-- Card 8: Total Guru -->
        <div style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(168, 237, 234, 0.3); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 40px rgba(168, 237, 234, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(168, 237, 234, 0.3)';">
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
                <div style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                    <i data-feather="user-check" style="width: 32px; height: 32px; color: #666;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="color: rgba(0,0,0,0.7); font-size: 13px; font-weight: 500; margin-bottom: 4px;">Total Guru/Ustadz</div>
                    <div style="color: #333; font-size: 32px; font-weight: 700; line-height: 1;"><?php echo e(number_format($totalGuru)); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-2" style="margin-bottom: var(--spacing-xl);">
        <div class="card">
            <h3 class="card-header">Rata-rata Nilai per Kelas</h3>
            <canvas id="chartKelas" style="max-height: 300px;"></canvas>
        </div>

        <div class="card">
            <h3 class="card-header">Sebaran Nilai Santri</h3>
            <canvas id="chartGrade" style="max-height: 300px;"></canvas>
        </div>
    </div>

    <!-- Module Summaries -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: var(--spacing-xl);">
        <div class="card">
            <h4 style="font-size: var(--font-size-md); font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-md);">Jadwal Pelajaran</h4>
            <div style="font-size: var(--font-size-2xl); font-weight: var(--font-weight-bold); color: var(--color-primary); margin-bottom: var(--spacing-sm);">
                <?php echo e(number_format($totalJadwal, 0, ',', '.')); ?>

            </div>
            <div style="font-size: var(--font-size-sm); color: var(--color-gray-600); margin-bottom: var(--spacing-md);">Jadwal Aktif</div>
            <a href="<?php echo e(route('pendidikan.jadwal')); ?>" class="btn btn-secondary btn-sm" style="width: 100%; text-decoration: none;">
                Kelola <i data-feather="arrow-right" style="width: 14px; height: 14px;"></i>
            </a>
        </div>

        <div class="card">
            <h4 style="font-size: var(--font-size-md); font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-md);">Data Nilai</h4>
            <div style="font-size: var(--font-size-2xl); font-weight: var(--font-weight-bold); color: var(--color-primary); margin-bottom: var(--spacing-sm);">
                <?php echo e(number_format($totalNilaiRecords, 0, ',', '.')); ?>

            </div>
            <div style="font-size: var(--font-size-sm); color: var(--color-gray-600); margin-bottom: var(--spacing-md);">Total Nilai</div>
            <a href="<?php echo e(route('pendidikan.nilai')); ?>" class="btn btn-secondary btn-sm" style="width: 100%; text-decoration: none;">
                Kelola <i data-feather="arrow-right" style="width: 14px; height: 14px;"></i>
            </a>
        </div>

        <div class="card">
            <h4 style="font-size: var(--font-size-md); font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-md);">Data Absensi</h4>
            <div style="font-size: var(--font-size-2xl); font-weight: var(--font-weight-bold); color: var(--color-primary); margin-bottom: var(--spacing-sm);">
                <?php echo e(number_format($totalAbsensiThisSemester, 0, ',', '.')); ?>

            </div>
            <div style="font-size: var(--font-size-sm); color: var(--color-gray-600); margin-bottom: var(--spacing-md);">Record Absensi</div>
            <a href="<?php echo e(route('pendidikan.absensi')); ?>" class="btn btn-secondary btn-sm" style="width: 100%; text-decoration: none;">
                Kelola <i data-feather="arrow-right" style="width: 14px; height: 14px;"></i>
            </a>
        </div>

        <div class="card">
            <h4 style="font-size: var(--font-size-md); font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-md);">Laporan</h4>
            <div style="font-size: var(--font-size-sm); color: var(--color-gray-600); margin-bottom: var(--spacing-lg); margin-top: var(--spacing-md);">
                Akses semua laporan akademik
            </div>
            <a href="<?php echo e(route('pendidikan.laporan')); ?>" class="btn btn-secondary btn-sm" style="width: 100%; text-decoration: none;">
                Buka Laporan <i data-feather="arrow-right" style="width: 14px; height: 14px;"></i>
            </a>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="grid grid-cols-2" style="margin-bottom: var(--spacing-xl);">
        <!-- Recent Nilai -->
        <div class="card">
            <h3 class="card-header">Input Nilai Terbaru</h3>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Santri</th>
                            <th>Mata Pelajaran</th>
                            <th>Nilai Akhir</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recentNilai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nilai): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($nilai->santri->nama_santri ?? '-'); ?></td>
                                <td><?php echo e($nilai->mataPelajaran->nama_mapel ?? '-'); ?></td>
                                <td><strong><?php echo e(number_format($nilai->nilai_akhir, 2)); ?></strong></td>
                                <td>
                                    <span class="badge <?php echo e($nilai->grade == 'A' ? 'badge-success' : ($nilai->grade == 'B' ? 'badge-info' : 'badge-warning')); ?>">
                                        <?php echo e($nilai->grade); ?>

                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--color-gray-500);">Belum ada data nilai</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Absensi -->
        <div class="card">
            <h3 class="card-header">Data Absensi Terbaru</h3>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Santri</th>
                            <th>Kelas</th>
                            <th>Periode</th>
                            <th>Total Alfa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recentAbsensi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $absensi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($absensi->santri->nama_santri ?? '-'); ?></td>
                                <td><?php echo e($absensi->kelas->nama_kelas ?? '-'); ?></td>
                                <td>Minggu <?php echo e($absensi->minggu_ke); ?>/<?php echo e($absensi->tahun); ?></td>
                                <td>
                                    <?php
                                        $totalAlfa = $absensi->alfa_sorogan + $absensi->alfa_menghafal_malam + $absensi->alfa_menghafal_subuh + $absensi->alfa_tahajud;
                                    ?>
                                    <span class="badge <?php echo e($totalAlfa == 0 ? 'badge-success' : ($totalAlfa < 5 ? 'badge-warning' : 'badge-danger')); ?>">
                                        <?php echo e($totalAlfa); ?>

                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--color-gray-500);">Belum ada data absensi</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Top & Bottom Students -->
    <div class="grid grid-cols-2" style="margin-bottom: var(--spacing-xl);">
        <div class="card">
            <h3 class="card-header">Top 10 Santri Berprestasi</h3>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $santriBerprestasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><strong><?php echo e($index + 1); ?></strong></td>
                                <td><?php echo e($item->santri->nis ?? '-'); ?></td>
                                <td><?php echo e($item->santri->nama_santri ?? '-'); ?></td>
                                <td><span class="badge badge-success"><?php echo e(number_format($item->rata_rata, 2)); ?></span></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--color-gray-500);">Belum ada data</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <h3 class="card-header">Santri Perlu Bimbingan</h3>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $santriPerluBimbingan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><strong><?php echo e($index + 1); ?></strong></td>
                                <td><?php echo e($item->santri->nis ?? '-'); ?></td>
                                <td><?php echo e($item->santri->nama_santri ?? '-'); ?></td>
                                <td><span class="badge badge-error"><?php echo e(number_format($item->rata_rata, 2)); ?></span></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--color-gray-500);">Belum ada data</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart Kelas
const ctxKelas = document.getElementById('chartKelas').getContext('2d');
new Chart(ctxKelas, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($chartKelasLabels); ?>,
        datasets: [{
            label: 'Rata-rata Nilai',
            data: <?php echo json_encode($chartKelasData); ?>,
            backgroundColor: 'rgba(76, 175, 80, 0.6)',
            borderColor: 'rgba(76, 175, 80, 1)',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                beginAtZero: true,
                max: 100
            }
        }
    }
});

// Chart Grade
const ctxGrade = document.getElementById('chartGrade').getContext('2d');
new Chart(ctxGrade, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($chartGradeLabels); ?>,
        datasets: [{
            data: <?php echo json_encode($chartGradeData); ?>,
            backgroundColor: [
                'rgba(76, 175, 80, 0.8)',
                'rgba(33, 150, 243, 0.8)',
                'rgba(255, 152, 0, 0.8)',
                'rgba(255, 87, 34, 0.8)',
                'rgba(244, 67, 54, 0.8)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\pendidikan\dashboard\index.blade.php ENDPATH**/ ?>