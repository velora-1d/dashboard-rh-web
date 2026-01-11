<?php
    use Illuminate\Support\Facades\Cache;
?>



<?php $__env->startSection('title', 'Dashboard Admin'); ?>
<?php $__env->startSection('page-title', 'Dashboard Admin - Pusat Kontrol Sistem'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <li class="sidebar-menu-item">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-menu-link active">
            <i data-feather="home" class="sidebar-menu-icon"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="<?php echo e(route('sekretaris.dashboard')); ?>" class="sidebar-menu-link">
            <i data-feather="users" class="sidebar-menu-icon"></i>
            <span>Sekretaris</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="<?php echo e(route('bendahara.dashboard')); ?>" class="sidebar-menu-link">
            <i data-feather="dollar-sign" class="sidebar-menu-icon"></i>
            <span>Bendahara</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="<?php echo e(route('pendidikan.dashboard')); ?>" class="sidebar-menu-link">
            <i data-feather="book-open" class="sidebar-menu-icon"></i>
            <span>Pendidikan</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="<?php echo e(route('admin.pengaturan')); ?>" class="sidebar-menu-link">
            <i data-feather="settings" class="sidebar-menu-icon"></i>
            <span>Pengaturan</span>
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


<?php echo $__env->make('components.bottom-nav', ['active' => 'dashboard', 'context' => 'admin'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


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

<?php $__env->startPush('styles'); ?>
<style>
    /* Prevent layout shift on initial load */
    .main-content {
        min-height: 100vh;
        will-change: transform;
    }
    
    /* Optimize grid rendering */
    .dashboard-grid {
        contain: layout style paint;
    }
    
    /* Smooth transitions */
    .dashboard-card {
        will-change: transform;
        transform: translateZ(0);
        backface-visibility: hidden;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Premium Welcome Banner -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px; padding: 40px; margin-bottom: 32px; box-shadow: 0 20px 60px rgba(102, 126, 234, 0.4); position: relative; overflow: hidden;">
        <!-- Decorative Elements -->
        <div style="position: absolute; top: -40px; right: -40px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -30px; left: 20%; width: 150px; height: 150px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        <div style="position: absolute; top: 30%; left: -30px; width: 80px; height: 80px; background: rgba(255,255,255,0.08); border-radius: 16px; transform: rotate(25deg);"></div>
        
        <div style="display: flex; align-items: center; gap: 24px; position: relative; z-index: 1; color: white;">
            <div style="background: rgba(255,255,255,0.2); width: 80px; height: 80px; border-radius: 20px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px); border: 2px solid rgba(255,255,255,0.3); box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                <i data-feather="shield" style="width: 40px; height: 40px; color: white;"></i>
            </div>
            <div style="flex: 1;">
                <h1 style="font-size: 2.25rem; font-weight: 900; margin: 0 0 8px 0; letter-spacing: -0.025em; text-shadow: 0 2px 10px rgba(0,0,0,0.2);">
                    Selamat Datang, Administrator! 👋
                </h1>
                <p style="opacity: 0.95; font-size: 1.125rem; font-weight: 400; margin: 0; text-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    Pusat Kontrol Dashboard Riyadlul Huda - Kelola seluruh sistem pesantren dengan mudah dan efisien.
                </p>
            </div>
            <div style="background: rgba(255,255,255,0.15); padding: 16px 24px; border-radius: 12px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 4px;">Tanggal</div>
                <div style="font-size: 1.25rem; font-weight: 700;"><?php echo e(date('d M Y')); ?></div>
            </div>
        </div>
    </div>

    <!-- Quick Access Modules -->
    <div class="dashboard-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 32px;">

        <!-- Sekretaris Module -->
        <a href="<?php echo e(route('sekretaris.dashboard')); ?>" style="text-decoration: none;">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 28px; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3); transition: all 0.3s ease; cursor: pointer; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 40px rgba(102, 126, 234, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(102, 126, 234, 0.3)';">
                <div style="position: absolute; top: -20px; right: -20px; width: 120px; height: 120px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: relative; z-index: 1;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                        <div style="background: rgba(255,255,255,0.2); width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                            <i data-feather="users" style="width: 28px; height: 28px; color: white;"></i>
                        </div>
                        <i data-feather="arrow-right" style="width: 20px; height: 20px; color: rgba(255,255,255,0.7);"></i>
                    </div>
                    <h3 style="font-size: 1.5rem; font-weight: 800; color: white; margin: 0 0 8px 0;">Sekretaris</h3>
                    <p style="color: rgba(255,255,255,0.85); font-size: 0.875rem; margin: 0;">Kelola Data Santri & Asrama</p>
                </div>
            </div>
        </a>

        <!-- Bendahara Module -->
        <a href="<?php echo e(route('bendahara.dashboard')); ?>" style="text-decoration: none;">
            <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 16px; padding: 28px; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3); transition: all 0.3s ease; cursor: pointer; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 40px rgba(16, 185, 129, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(16, 185, 129, 0.3)';">
                <div style="position: absolute; top: -20px; right: -20px; width: 120px; height: 120px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: relative; z-index: 1;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                        <div style="background: rgba(255,255,255,0.2); width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                            <i data-feather="dollar-sign" style="width: 28px; height: 28px; color: white;"></i>
                        </div>
                        <i data-feather="arrow-right" style="width: 20px; height: 20px; color: rgba(255,255,255,0.7);"></i>
                    </div>
                    <h3 style="font-size: 1.5rem; font-weight: 800; color: white; margin: 0 0 8px 0;">Bendahara</h3>
                    <p style="color: rgba(255,255,255,0.85); font-size: 0.875rem; margin: 0;">Kelola Keuangan & Syahriah</p>
                </div>
            </div>
        </a>

        <!-- Pendidikan Module -->
        <a href="<?php echo e(route('pendidikan.dashboard')); ?>" style="text-decoration: none;">
            <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 16px; padding: 28px; box-shadow: 0 10px 30px rgba(240, 147, 251, 0.3); transition: all 0.3s ease; cursor: pointer; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 40px rgba(240, 147, 251, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(240, 147, 251, 0.3)';">
                <div style="position: absolute; top: -20px; right: -20px; width: 120px; height: 120px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: relative; z-index: 1;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                        <div style="background: rgba(255,255,255,0.2); width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                            <i data-feather="book-open" style="width: 28px; height: 28px; color: white;"></i>
                        </div>
                        <i data-feather="arrow-right" style="width: 20px; height: 20px; color: rgba(255,255,255,0.7);"></i>
                    </div>
                    <h3 style="font-size: 1.5rem; font-weight: 800; color: white; margin: 0 0 8px 0;">Pendidikan</h3>
                    <p style="color: rgba(255,255,255,0.85); font-size: 0.875rem; margin: 0;">Kelola Akademik & Nilai</p>
                </div>
            </div>
        </a>
    </div>

    <!-- System Overview KPI Cards -->
    <div class="dashboard-grid" style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 20px; margin-bottom: 32px;">

        <?php
            // Cache dashboard statistics for 5 minutes to improve performance
            $totalSantri = Cache::remember('dashboard.total_santri', 300, function() {
                return \App\Models\Santri::where('is_active', true)->count();
            });
            
            $totalKelas = Cache::remember('dashboard.total_kelas', 300, function() {
                return \App\Models\Kelas::count();
            });
            
            $totalMapel = Cache::remember('dashboard.total_mapel', 300, function() {
                return \App\Models\MataPelajaran::count();
            });
            
            $totalPegawai = Cache::remember('dashboard.total_pegawai', 300, function() {
                return \App\Models\Pegawai::count();
            });
            
            $totalUsers = Cache::remember('dashboard.total_users', 300, function() {
                return \App\Models\User::count();
            });
            
            $saldoDana = Cache::remember('dashboard.saldo_dana', 300, function() {
                return \App\Models\Syahriah::where('is_lunas', true)->sum('nominal') 
                    + \App\Models\Pemasukan::sum('nominal') 
                    - \App\Models\Pengeluaran::sum('nominal') 
                    - \App\Models\GajiPegawai::where('is_dibayar', true)->sum('nominal');
            });
        ?>

        <!-- Total Santri -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 14px; padding: 20px; box-shadow: 0 8px 20px rgba(102, 126, 234, 0.25); transition: transform 0.3s ease; position: relative; overflow: hidden; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)';" onmouseout="this.style.transform='translateY(0)';">
            <div style="position: absolute; top: -10px; right: -10px; width: 70px; height: 70px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="position: relative; z-index: 1;">
                <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; backdrop-filter: blur(10px);">
                    <i data-feather="users" style="width: 20px; height: 20px; color: white;"></i>
                </div>
                <p style="font-size: 0.75rem; color: rgba(255,255,255,0.9); font-weight: 600; margin: 0 0 4px 0; text-transform: uppercase; letter-spacing: 0.5px;">Total Santri</p>
                <h3 style="font-size: 1.75rem; font-weight: 900; color: white; margin: 0;"><?php echo e(number_format($totalSantri)); ?></h3>
            </div>
        </div>

        <!-- Total Kelas -->
        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 14px; padding: 20px; box-shadow: 0 8px 20px rgba(240, 147, 251, 0.25); transition: transform 0.3s ease; position: relative; overflow: hidden; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)';" onmouseout="this.style.transform='translateY(0)';">
            <div style="position: absolute; top: -10px; right: -10px; width: 70px; height: 70px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="position: relative; z-index: 1;">
                <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; backdrop-filter: blur(10px);">
                    <i data-feather="grid" style="width: 20px; height: 20px; color: white;"></i>
                </div>
                <p style="font-size: 0.75rem; color: rgba(255,255,255,0.9); font-weight: 600; margin: 0 0 4px 0; text-transform: uppercase; letter-spacing: 0.5px;">Total Kelas</p>
                <h3 style="font-size: 1.75rem; font-weight: 900; color: white; margin: 0;"><?php echo e(number_format($totalKelas)); ?></h3>
            </div>
        </div>

        <!-- Total Mapel -->
        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 14px; padding: 20px; box-shadow: 0 8px 20px rgba(79, 172, 254, 0.25); transition: transform 0.3s ease; position: relative; overflow: hidden; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)';" onmouseout="this.style.transform='translateY(0)';">
            <div style="position: absolute; top: -10px; right: -10px; width: 70px; height: 70px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="position: relative; z-index: 1;">
                <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; backdrop-filter: blur(10px);">
                    <i data-feather="book-open" style="width: 20px; height: 20px; color: white;"></i>
                </div>
                <p style="font-size: 0.75rem; color: rgba(255,255,255,0.9); font-weight: 600; margin: 0 0 4px 0; text-transform: uppercase; letter-spacing: 0.5px;">Mata Pelajaran</p>
                <h3 style="font-size: 1.75rem; font-weight: 900; color: white; margin: 0;"><?php echo e(number_format($totalMapel)); ?></h3>
            </div>
        </div>

        <!-- Total Pegawai -->
        <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 14px; padding: 20px; box-shadow: 0 8px 20px rgba(67, 233, 123, 0.25); transition: transform 0.3s ease; position: relative; overflow: hidden; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)';" onmouseout="this.style.transform='translateY(0)';">
            <div style="position: absolute; top: -10px; right: -10px; width: 70px; height: 70px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="position: relative; z-index: 1;">
                <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; backdrop-filter: blur(10px);">
                    <i data-feather="briefcase" style="width: 20px; height: 20px; color: white;"></i>
                </div>
                <p style="font-size: 0.75rem; color: rgba(255,255,255,0.9); font-weight: 600; margin: 0 0 4px 0; text-transform: uppercase; letter-spacing: 0.5px;">Total Pegawai</p>
                <h3 style="font-size: 1.75rem; font-weight: 900; color: white; margin: 0;"><?php echo e(number_format($totalPegawai)); ?></h3>
            </div>
        </div>

        <!-- Total Users -->
        <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 14px; padding: 20px; box-shadow: 0 8px 20px rgba(250, 112, 154, 0.25); transition: transform 0.3s ease; position: relative; overflow: hidden; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)';" onmouseout="this.style.transform='translateY(0)';">
            <div style="position: absolute; top: -10px; right: -10px; width: 70px; height: 70px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="position: relative; z-index: 1;">
                <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; backdrop-filter: blur(10px);">
                    <i data-feather="user-check" style="width: 20px; height: 20px; color: white;"></i>
                </div>
                <p style="font-size: 0.75rem; color: rgba(255,255,255,0.9); font-weight: 600; margin: 0 0 4px 0; text-transform: uppercase; letter-spacing: 0.5px;">Total Users</p>
                <h3 style="font-size: 1.75rem; font-weight: 900; color: white; margin: 0;"><?php echo e(number_format($totalUsers)); ?></h3>
            </div>
        </div>

        <!-- Saldo Dana -->
        <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 14px; padding: 20px; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.25); transition: transform 0.3s ease; position: relative; overflow: hidden; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)';" onmouseout="this.style.transform='translateY(0)';">
            <div style="position: absolute; top: -10px; right: -10px; width: 70px; height: 70px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="position: relative; z-index: 1;">
                <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; backdrop-filter: blur(10px);">
                    <i data-feather="dollar-sign" style="width: 20px; height: 20px; color: white;"></i>
                </div>
                <p style="font-size: 0.75rem; color: rgba(255,255,255,0.9); font-weight: 600; margin: 0 0 4px 0; text-transform: uppercase; letter-spacing: 0.5px;">Saldo Dana</p>
                <h3 style="font-size: 1.25rem; font-weight: 900; color: white; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Rp <?php echo e(number_format($saldoDana / 1000, 0)); ?>K</h3>
            </div>
        </div>
    </div>

    <!-- System Information -->
    <div style="background: white; border-radius: 20px; padding: 32px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: 2px solid transparent; background-image: linear-gradient(white, white), linear-gradient(135deg, #667eea 0%, #764ba2 100%); background-origin: border-box; background-clip: padding-box, border-box; margin-bottom: 32px;">
        <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 24px;">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);">
                <i data-feather="info" style="width: 28px; height: 28px; color: white;"></i>
            </div>
            <div>
                <h3 style="font-size: 1.5rem; font-weight: 800; color: #1f2937; margin: 0;">Informasi Sistem</h3>
                <p style="font-size: 0.875rem; color: #6b7280; margin: 4px 0 0 0;">Dashboard Riyadlul Huda v1.0</p>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
            <div style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); padding: 20px; border-radius: 12px; border: 1px solid #bae6fd;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                    <i data-feather="server" style="width: 20px; height: 20px; color: #0284c7;"></i>
                    <span style="font-size: 0.875rem; font-weight: 600; color: #0c4a6e;">Database</span>
                </div>
                <p style="font-size: 1.25rem; font-weight: 700; color: #0369a1; margin: 0;">MySQL</p>
            </div>

            <div style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); padding: 20px; border-radius: 12px; border: 1px solid #bbf7d0;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                    <i data-feather="check-circle" style="width: 20px; height: 20px; color: #16a34a;"></i>
                    <span style="font-size: 0.875rem; font-weight: 600; color: #14532d;">Status</span>
                </div>
                <p style="font-size: 1.25rem; font-weight: 700; color: #15803d; margin: 0;">Online</p>
            </div>

            <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); padding: 20px; border-radius: 12px; border: 1px solid #fcd34d;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                    <i data-feather="code" style="width: 20px; height: 20px; color: #ca8a04;"></i>
                    <span style="font-size: 0.875rem; font-weight: 600; color: #713f12;">Framework</span>
                </div>
                <p style="font-size: 1.25rem; font-weight: 700; color: #a16207; margin: 0;">Laravel 12</p>
            </div>

            <div style="background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%); padding: 20px; border-radius: 12px; border: 1px solid #f9a8d4;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                    <i data-feather="user" style="width: 20px; height: 20px; color: #db2777;"></i>
                    <span style="font-size: 0.875rem; font-weight: 600; color: #831843;">Developer</span>
                </div>
                <p style="font-size: 1rem; font-weight: 700; color: #be185d; margin: 0;">Mahin Utsman Nawawi, S.H</p>
            </div>
        </div>
    </div>

    <!-- Footer Info -->
    <div style="text-align: center; padding: 24px; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-radius: 16px; border: 1px solid #e2e8f0;">
        <p style="color: #64748b; font-size: 0.875rem; margin: 0;">
            <strong style="color: #1e293b;">Dashboard Riyadlul Huda</strong> - Sistem Manajemen Pesantren Terpadu
        </p>
        <p style="color: #94a3b8; font-size: 0.75rem; margin: 8px 0 0 0;">
            © <?php echo e(date('Y')); ?> Pondok Pesantren Riyadlul Huda. All rights reserved.
        </p>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>