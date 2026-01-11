

<?php $__env->startSection('title', 'Syahriah'); ?>
<?php $__env->startSection('page-title', 'Syahriah'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('bendahara.partials.sidebar-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Header Banner -->
    <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 20px; padding: 40px; margin-bottom: 32px; box-shadow: 0 20px 40px rgba(16, 185, 129, 0.25); position: relative; overflow: hidden; color: white;">
        <div style="position: absolute; top: -50px; right: -50px; width: 250px; height: 250px; background: rgba(255,255,255,0.1); border-radius: 50%; blur: 40px;"></div>
        <div style="position: absolute; bottom: -30px; left: 20%; width: 150px; height: 150px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        
        <div style="position: relative; z-index: 2; display: flex; align-items: center; gap: 24px;">
            <div style="background: rgba(255,255,255,0.2); width: 72px; height: 72px; border-radius: 18px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.3);">
                <i data-feather="dollar-sign" style="width: 36px; height: 36px; color: white;"></i>
            </div>
            <div>
                <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 6px; letter-spacing: -0.025em;">Pembayaran Syahriah</h2>
                <p style="font-size: 1.1rem; opacity: 0.95; font-weight: 400;">Manajemen iuran bulanan santri secara digital, transparan, dan akuntabel.</p>
            </div>
        </div>
        <div style="position: absolute; right: 40px; bottom: -20px; opacity: 0.15;">
            <i data-feather="dollar-sign" style="width: 180px; height: 180px; transform: rotate(-15deg);"></i>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div style="background: #ecfdf5; border-left: 4px solid #10b981; color: #065f46; padding: 16px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <i data-feather="check-circle" style="width: 20px; height: 20px;"></i>
            <span style="font-weight: 500;"><?php echo e(session('success')); ?></span>
        </div>
    <?php endif; ?>

    <?php if(session('warning')): ?>
        <div style="background: #fffbeb; border-left: 4px solid #f59e0b; color: #92400e; padding: 16px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: flex-start; gap: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <i data-feather="alert-triangle" style="width: 20px; height: 20px; flex-shrink: 0; margin-top: 2px;"></i>
            <span style="font-weight: 500;"><?php echo e(session('warning')); ?></span>
        </div>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: 1fr; gap: 32px;">
        <div style="background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; overflow: hidden;">
            <div style="padding: 24px 32px; border-bottom: 1px solid #f1f5f9; background: linear-gradient(to right, #f8fafc, white); display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; background: #ecfdf5; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i data-feather="plus-circle" style="width: 20px; height: 20px; color: #10b981;"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 800; color: #1e2937;">Catat Pembayaran Baru</h3>
                </div>
                <div style="font-size: 0.875rem; color: #64748b; font-weight: 500;">Isi detail transaksi di bawah ini</div>
            </div>
            <div style="padding: 28px;">
                <form method="POST" action="<?php echo e(route('bendahara.syahriah.store')); ?>">
                    <?php echo csrf_field(); ?>
                    
                    <!-- Filter Santri - Glassmorphism Card -->
                    <div style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(5, 150, 105, 0.05) 100%); border-radius: 20px; padding: 24px; margin-bottom: 28px; border: 1px solid rgba(16, 185, 129, 0.2); backdrop-filter: blur(10px);">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                                <i data-feather="search" style="width: 18px; height: 18px; color: white;"></i>
                            </div>
                            <div>
                                <h4 style="margin: 0; font-size: 1rem; font-weight: 700; color: #1e293b;">Filter Santri</h4>
                                <p style="margin: 0; font-size: 0.75rem; color: #64748b;">Pilih kriteria untuk mempersempit pilihan santri</p>
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                            <div>
                                <label style="display: flex; align-items: center; gap: 6px; font-size: 0.75rem; font-weight: 700; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i data-feather="users" style="width: 12px; height: 12px; color: #10b981;"></i> Gender
                                </label>
                                <select id="filter-gender" style="width: 100%; padding: 14px 16px; border-radius: 12px; border: 2px solid #e2e8f0; font-size: 0.9rem; background: white; transition: all 0.2s; cursor: pointer;" onfocus="this.style.borderColor='#10b981'; this.style.boxShadow='0 0 0 4px rgba(16, 185, 129, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                                    <option value="">Semua Gender</option>
                                    <option value="putra">👦 Putra</option>
                                    <option value="putri">👧 Putri</option>
                                </select>
                            </div>
                            <div>
                                <label style="display: flex; align-items: center; gap: 6px; font-size: 0.75rem; font-weight: 700; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i data-feather="home" style="width: 12px; height: 12px; color: #10b981;"></i> Asrama
                                </label>
                                <select id="filter-asrama" style="width: 100%; padding: 14px 16px; border-radius: 12px; border: 2px solid #e2e8f0; font-size: 0.9rem; background: white; transition: all 0.2s; cursor: pointer;" onfocus="this.style.borderColor='#10b981'; this.style.boxShadow='0 0 0 4px rgba(16, 185, 129, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                                    <option value="">Semua Asrama</option>
                                    <?php $__currentLoopData = $asramaList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asrama): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($asrama->id); ?>">🏠 <?php echo e($asrama->nama_asrama); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div>
                                <label style="display: flex; align-items: center; gap: 6px; font-size: 0.75rem; font-weight: 700; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i data-feather="grid" style="width: 12px; height: 12px; color: #10b981;"></i> Kobong
                                </label>
                                <select id="filter-kobong" style="width: 100%; padding: 14px 16px; border-radius: 12px; border: 2px solid #e2e8f0; font-size: 0.9rem; background: white; transition: all 0.2s; cursor: pointer;" onfocus="this.style.borderColor='#10b981'; this.style.boxShadow='0 0 0 4px rgba(16, 185, 129, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                                    <option value="">Semua Kobong</option>
                                    <?php $__currentLoopData = $kobongList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kobong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($kobong->id); ?>" data-asrama="<?php echo e($kobong->asrama_id); ?>">
                                            🚪 K<?php echo e($kobong->nomor_kobong); ?> - <?php echo e($kobong->asrama->nama_asrama); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Row 1: Santri, Bulan, Tahun -->
                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: flex; align-items: center; gap: 6px; font-size: 0.8rem; font-weight: 700; color: #334155; margin-bottom: 10px;">
                                <span style="width: 20px; height: 20px; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                    <i data-feather="user" style="width: 11px; height: 11px; color: white;"></i>
                                </span>
                                Pilih Santri <span style="color: #ef4444;">*</span>
                            </label>
                            <select name="santri_id" id="santri-select" style="width: 100%; padding: 14px 16px; border-radius: 12px; border: 2px solid #e2e8f0; font-size: 0.95rem; background: white; transition: all 0.2s; font-weight: 500;" onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';" required>
                                <option value="">Pilih Santri</option>
                                <?php $__currentLoopData = $santriList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($s->id); ?>" 
                                            data-gender="<?php echo e($s->gender); ?>" 
                                            data-asrama="<?php echo e($s->asrama_id); ?>" 
                                            data-kobong="<?php echo e($s->kobong_id); ?>">
                                        <?php echo e($s->nis); ?> - <?php echo e($s->nama_santri); ?> (<?php echo e(ucfirst($s->gender)); ?>, <?php echo e($s->asrama->nama_asrama ?? '-'); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div>
                            <label style="display: flex; align-items: center; gap: 6px; font-size: 0.8rem; font-weight: 700; color: #334155; margin-bottom: 10px;">
                                <span style="width: 20px; height: 20px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                    <i data-feather="calendar" style="width: 11px; height: 11px; color: white;"></i>
                                </span>
                                Bulan <span style="color: #ef4444;">*</span>
                            </label>
                            <select name="bulan" style="width: 100%; padding: 14px 16px; border-radius: 12px; border: 2px solid #e2e8f0; font-size: 0.95rem; background: white; transition: all 0.2s; font-weight: 500;" onfocus="this.style.borderColor='#f59e0b'; this.style.boxShadow='0 0 0 4px rgba(245, 158, 11, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';" required>
                                <?php for($i = 1; $i <= 12; $i++): ?>
                                    <option value="<?php echo e($i); ?>" <?php echo e(date('n') == $i ? 'selected' : ''); ?>><?php echo e(date('F', mktime(0, 0, 0, $i, 1))); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div>
                            <label style="display: flex; align-items: center; gap: 6px; font-size: 0.8rem; font-weight: 700; color: #334155; margin-bottom: 10px;">
                                <span style="width: 20px; height: 20px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                    <i data-feather="hash" style="width: 11px; height: 11px; color: white;"></i>
                                </span>
                                Tahun <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="number" name="tahun" style="width: 100%; padding: 14px 16px; border-radius: 12px; border: 2px solid #e2e8f0; font-size: 0.95rem; font-weight: 500; transition: all 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 4px rgba(59, 130, 246, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';" value="<?php echo e(date('Y')); ?>" required>
                        </div>
                    </div>

                    <!-- Row 2: Nominal, Status, Tanggal + Button -->
                    <div style="display: grid; grid-template-columns: 1.5fr 1fr 1fr auto; gap: 20px; align-items: flex-end;">
                        <div>
                            <label style="display: flex; align-items: center; gap: 6px; font-size: 0.8rem; font-weight: 700; color: #334155; margin-bottom: 10px;">
                                <span style="width: 20px; height: 20px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                    <i data-feather="dollar-sign" style="width: 11px; height: 11px; color: white;"></i>
                                </span>
                                Nominal <span style="color: #ef4444;">*</span>
                            </label>
                            <div style="position: relative;">
                                <span style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #64748b; font-weight: 700; font-size: 0.9rem;">Rp</span>
                                <input type="text" name="nominal" class="format-rupiah" style="width: 100%; padding: 14px 16px 14px 48px; border-radius: 12px; border: 2px solid #e2e8f0; font-size: 0.95rem; font-weight: 600; transition: all 0.2s;" onfocus="this.style.borderColor='#10b981'; this.style.boxShadow='0 0 0 4px rgba(16, 185, 129, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';" placeholder="0" required>
                            </div>
                        </div>
                        <div>
                            <label style="display: flex; align-items: center; gap: 6px; font-size: 0.8rem; font-weight: 700; color: #334155; margin-bottom: 10px;">
                                <span style="width: 20px; height: 20px; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                    <i data-feather="check-circle" style="width: 11px; height: 11px; color: white;"></i>
                                </span>
                                Status
                            </label>
                            <select name="is_lunas" style="width: 100%; padding: 14px 16px; border-radius: 12px; border: 2px solid #e2e8f0; font-size: 0.95rem; background: white; transition: all 0.2s; font-weight: 500;" onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 4px rgba(139, 92, 246, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';" required>
                                <option value="1">✅ Lunas</option>
                                <option value="0">⏳ Belum Lunas</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: flex; align-items: center; gap: 6px; font-size: 0.8rem; font-weight: 700; color: #334155; margin-bottom: 10px;">
                                <span style="width: 20px; height: 20px; background: linear-gradient(135deg, #ec4899 0%, #db2777 100%); border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                    <i data-feather="clock" style="width: 11px; height: 11px; color: white;"></i>
                                </span>
                                Tanggal Bayar
                            </label>
                            <input type="date" name="tanggal_bayar" style="width: 100%; padding: 14px 16px; border-radius: 12px; border: 2px solid #e2e8f0; font-size: 0.95rem; font-weight: 500; transition: all 0.2s;" onfocus="this.style.borderColor='#ec4899'; this.style.boxShadow='0 0 0 4px rgba(236, 72, 153, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';" value="<?php echo e(date('Y-m-d')); ?>">
                        </div>
                        <button type="submit" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 14px 28px; border-radius: 12px; font-weight: 700; border: none; display: flex; align-items: center; gap: 10px; cursor: pointer; transition: all 0.3s; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3); white-space: nowrap;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 28px rgba(16, 185, 129, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(16, 185, 129, 0.3)';">
                            <i data-feather="save" style="width: 18px; height: 18px;"></i>
                            Simpan Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Filter & Search Card -->
        <div style="background: white; border-radius: 20px; padding: 24px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03); border: 1px solid #f1f5f9; margin-bottom: 32px;">
            <form method="GET" action="<?php echo e(route('bendahara.syahriah')); ?>">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; color: #334155; font-weight: 800; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">
                    <div style="width: 28px; height: 28px; background: #eef2ff; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                        <i data-feather="filter" style="width: 14px; height: 14px; color: #4f46e5;"></i>
                    </div>
                    Filter Data Syahriah
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; align-items: flex-end;">
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; margin-bottom: 8px; text-transform: uppercase;">Tahun</label>
                        <input type="number" name="tahun" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 0.9rem; font-weight: 600; color: #1e2937; transition: all 0.2s;" onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 3px rgba(79, 70, 229, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';" value="<?php echo e(request('tahun', date('Y'))); ?>">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; margin-bottom: 8px; text-transform: uppercase;">Bulan</label>
                        <select name="bulan" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 0.9rem; font-weight: 600; color: #1e2937; transition: all 0.2s;" onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 3px rgba(79, 70, 229, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                            <option value="">Semua Bulan</option>
                            <?php for($i = 1; $i <= 12; $i++): ?>
                                <option value="<?php echo e($i); ?>" <?php echo e(request('bulan') == $i ? 'selected' : ''); ?>>
                                    <?php echo e(date('F', mktime(0, 0, 0, $i, 1))); ?>

                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; margin-bottom: 8px; text-transform: uppercase;">Status</label>
                        <select name="is_lunas" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 0.9rem; font-weight: 600; color: #1e2937; transition: all 0.2s;" onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 3px rgba(79, 70, 229, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                            <option value="">Semua Status</option>
                            <option value="1" <?php echo e(request('is_lunas') == '1' ? 'selected' : ''); ?>>Lunas</option>
                            <option value="0" <?php echo e(request('is_lunas') == '0' ? 'selected' : ''); ?>>Belum Lunas</option>
                        </select>
                    </div>
                    
                    <div style="display: flex; gap: 10px;">
                        <button type="submit" style="flex: 1; height: 46px; background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%); color: white; border-radius: 10px; font-weight: 700; border: none; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 15px rgba(79, 70, 229, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(79, 70, 229, 0.25)';">
                            <i data-feather="filter" style="width: 16px; height: 16px;"></i>
                            Terapkan
                        </button>
                        <a href="<?php echo e(route('bendahara.syahriah')); ?>" style="height: 46px; width: 46px; background: #f8fafc; color: #64748b; border-radius: 10px; display: flex; align-items: center; justify-content: center; transition: all 0.2s; border: 1px solid #e2e8f0;" onmouseover="this.style.background='#f1f5f9'; this.style.color='#1e2937';" onmouseout="this.style.background='#f8fafc'; this.style.color='#64748b';">
                            <i data-feather="refresh-cw" style="width: 16px; height: 16px;"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Data Table Card -->
        <div style="background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03); border: 1px solid #f1f5f9; overflow: hidden;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 2px solid #f1f5f9;">
                            <th style="text-align: left; padding: 16px 24px; font-size: 0.875rem; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.025em;">Santri</th>
                            <th style="text-align: left; padding: 16px 24px; font-size: 0.875rem; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.025em;">Periode</th>
                            <th style="text-align: right; padding: 16px 24px; font-size: 0.875rem; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.025em;">Nominal</th>
                            <th style="text-align: center; padding: 16px 24px; font-size: 0.875rem; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.025em;">Status</th>
                            <th style="text-align: left; padding: 16px 24px; font-size: 0.875rem; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.025em;">Tanggal</th>
                            <th style="text-align: center; padding: 16px 24px; font-size: 0.875rem; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.025em;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.9375rem;">
                        <?php $__empty_1 = true; $__currentLoopData = $syahriah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr id="row-<?php echo e($s->id); ?>" style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;">
                                <td style="padding: 16px 24px;">
                                    <div style="font-weight: 700; color: #1e2937;"><?php echo e($s->santri->nama_santri ?? '-'); ?></div>
                                    <div style="font-size: 0.8125rem; color: #64748b;"><?php echo e($s->santri->nis ?? '-'); ?> • <?php echo e($s->santri->asrama->nama_asrama ?? '-'); ?></div>
                                </td>
                                <td style="padding: 16px 24px; color: #475569;">
                                    <?php echo e(date('F', mktime(0, 0, 0, $s->bulan, 1))); ?> <?php echo e($s->tahun); ?>

                                </td>
                                <td style="padding: 16px 24px; text-align: right; color: #1e2937; font-weight: 700;">
                                    Rp <?php echo e(number_format($s->nominal, 0, ',', '.')); ?>

                                </td>
                                <td style="padding: 16px 24px; text-align: center;">
                                    <span style="display: inline-block; padding: 6px 12px; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; <?php echo e($s->is_lunas ? 'background: #ecfdf5; color: #059669;' : 'background: #fff1f2; color: #e11d48;'); ?>">
                                        <?php echo e($s->is_lunas ? 'Lunas' : 'Tertunggak'); ?>

                                    </span>
                                </td>
                                <td style="padding: 16px 24px; color: #64748b; font-size: 0.875rem;">
                                    <?php echo e($s->tanggal_bayar ? $s->tanggal_bayar->format('d/m/Y') : '-'); ?>

                                </td>
                                <td style="padding: 16px 24px; text-align: center;">
                                    <div style="display: flex; justify-content: center; gap: 8px;">
                                        <button onclick="toggleEdit(<?php echo e($s->id); ?>)" style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 6px; color: #475569; cursor: pointer; transition: all 0.2s;">
                                            <i data-feather="edit-2" style="width: 16px; height: 16px;"></i>
                                        </button>
                                        <form method="POST" action="<?php echo e(route('bendahara.syahriah.destroy', $s->id)); ?>" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" style="background: white; border: 1px solid #fee2e2; border-radius: 8px; padding: 6px; color: #ef4444; cursor: pointer; transition: all 0.2s;">
                                                <i data-feather="trash-2" style="width: 16px; height: 16px;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <!-- Edit Row (Slide Down effect handled by JS) -->
                            <tr id="edit-<?php echo e($s->id); ?>" style="display: none; background: #f8fafc;">
                                <td colspan="6" style="padding: 24px; border-bottom: 1px solid #e2e8f0;">
                                    <form method="POST" action="<?php echo e(route('bendahara.syahriah.update', $s->id)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 20px;">
                                            <div>
                                                <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; margin-bottom: 6px; text-transform: uppercase;">Status Pembayaran</label>
                                                <select name="is_lunas" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.875rem;" required>
                                                    <option value="1" <?php echo e($s->is_lunas ? 'selected' : ''); ?>>Lunas</option>
                                                    <option value="0" <?php echo e(!$s->is_lunas ? 'selected' : ''); ?>>Belum Lunas</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; margin-bottom: 6px; text-transform: uppercase;">Tanggal Bayar</label>
                                                <input type="date" name="tanggal_bayar" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.875rem;" value="<?php echo e($s->tanggal_bayar ? $s->tanggal_bayar->format('Y-m-d') : ''); ?>">
                                            </div>
                                            <div style="grid-column: span 2;">
                                                <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; margin-bottom: 6px; text-transform: uppercase;">Keterangan Tambahan</label>
                                                <input type="text" name="keterangan" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.875rem;" value="<?php echo e($s->keterangan ?? ''); ?>" placeholder="Contoh: Pembayaran titipan, dll.">
                                            </div>
                                        </div>
                                        <div style="display: flex; justify-content: flex-end; gap: 12px;">
                                            <button type="button" onclick="toggleEdit(<?php echo e($s->id); ?>)" style="background: white; border: 1px solid #e2e8f0; color: #475569; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer;">Batal</button>
                                            <button type="submit" style="background: #10b981; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                                                <i data-feather="check" style="width: 16px; height: 16px;"></i>
                                                Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" style="padding: 48px; text-align: center; color: #94a3b8;">
                                    <i data-feather="database" style="width: 48px; height: 48px; display: block; margin: 0 auto 16px; opacity: 0.5;"></i>
                                    <div style="font-size: 1rem; font-weight: 500;">Tidak ada data syahriah ditemukan</div>
                                    <p style="font-size: 0.875rem; margin-top: 4px;">Coba ubah filter atau tambah data baru.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if($syahriah->hasPages()): ?>
                <div style="padding: 24px; border-top: 1px solid #f1f5f9; display: flex; justify-content: center;">
                    <?php echo e($syahriah->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Filter santri based on Gender, Asrama, and Kobong
function filterSantri() {
    const filterGender = document.getElementById('filter-gender').value;
    const filterAsrama = document.getElementById('filter-asrama').value;
    const filterKobong = document.getElementById('filter-kobong').value;
    const santriSelect = document.getElementById('santri-select');
    const options = santriSelect.querySelectorAll('option');
    
    let visibleCount = 0;
    
    options.forEach((option, index) => {
        if (index === 0) return; // Skip "Pilih Santri" option
        
        const gender = option.getAttribute('data-gender');
        const asrama = option.getAttribute('data-asrama');
        const kobong = option.getAttribute('data-kobong');
        
        let show = true;
        
        if (filterGender && gender !== filterGender) show = false;
        if (filterAsrama && asrama !== filterAsrama) show = false;
        if (filterKobong && kobong !== filterKobong) show = false;
        
        if (show) {
            option.style.display = '';
            visibleCount++;
        } else {
            option.style.display = 'none';
        }
    });
    
    // Update first option text with count
    options[0].textContent = visibleCount > 0 
        ? `Pilih Santri (${visibleCount} santri)` 
        : 'Tidak ada santri yang sesuai filter';
}

// Filter kobong based on asrama
function updateKobongOptions() {
    const asramaValue = document.getElementById('filter-asrama').value;
    const kobongSelect = document.getElementById('filter-kobong');
    const kobongOptions = kobongSelect.querySelectorAll('option');
    
    kobongOptions.forEach((option, index) => {
        if (index === 0) return; // Skip "Semua Kobong"
        
        const kobongAsrama = option.getAttribute('data-asrama');
        
        if (!asramaValue || kobongAsrama === asramaValue) {
            option.style.display = '';
        } else {
            option.style.display = 'none';
        }
    });
    
    // Reset kobong selection if current selection is hidden
    if (kobongSelect.selectedIndex > 0 && 
        kobongOptions[kobongSelect.selectedIndex].style.display === 'none') {
        kobongSelect.selectedIndex = 0;
    }
}

// Initialize filters
function initSyahriahFilters() {
    const genderSelect = document.getElementById('filter-gender');
    const asramaSelect = document.getElementById('filter-asrama');
    const kobongSelect = document.getElementById('filter-kobong');
    
    if (genderSelect) genderSelect.addEventListener('change', filterSantri);
    if (asramaSelect) asramaSelect.addEventListener('change', function() {
        updateKobongOptions();
        filterSantri();
    });
    if (kobongSelect) kobongSelect.addEventListener('change', filterSantri);
    
    // Run initial filter
    filterSantri();
}

// Event listeners - support both DOMContentLoaded and Turbo
document.addEventListener('DOMContentLoaded', initSyahriahFilters);
document.addEventListener('turbo:load', initSyahriahFilters);

// Toggle edit form
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
    
    // Re-render feather icons
    feather.replace();
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\bendahara\syahriah\index.blade.php ENDPATH**/ ?>