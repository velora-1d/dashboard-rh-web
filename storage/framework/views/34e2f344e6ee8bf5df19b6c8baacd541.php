<?php if($kelasId && $mapelId): ?>
    <form action="<?php echo e(route('pendidikan.nilai-mingguan.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="kelas_id" value="<?php echo e($kelasId); ?>">
        <input type="hidden" name="mapel_id" value="<?php echo e($mapelId); ?>">
        <input type="hidden" name="tahun_ajaran" value="<?php echo e($tahunAjaran); ?>">
        <input type="hidden" name="semester" value="<?php echo e($semester); ?>">

        <div style="background: white; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); overflow: hidden;">
            <div style="padding: 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;">
                    Input Ujian Mingguan
                </h3>
                <button type="submit" style="padding: 10px 24px; background: #4f46e5; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="save" style="width: 18px; height: 18px;"></i>
                    Simpan Perubahan
                </button>
            </div>
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                        <tr>
                            <th style="padding: 16px; text-align: left; width: 50px; font-size: 12px; color: #64748b; text-transform: uppercase;">No</th>
                            <th style="padding: 16px; text-align: left; font-size: 12px; color: #64748b; text-transform: uppercase;">Nama Santri</th>
                            <th style="padding: 16px; text-align: center; width: 100px; font-size: 12px; color: #64748b; text-transform: uppercase;">Minggu 1</th>
                            <th style="padding: 16px; text-align: center; width: 100px; font-size: 12px; color: #64748b; text-transform: uppercase;">Minggu 2</th>
                            <th style="padding: 16px; text-align: center; width: 100px; font-size: 12px; color: #64748b; text-transform: uppercase;">Minggu 3</th>
                            <th style="padding: 16px; text-align: center; width: 100px; font-size: 12px; color: #64748b; text-transform: uppercase;">Minggu 4</th>
                            <th style="padding: 16px; text-align: center; width: 100px; font-size: 12px; color: #64748b; text-transform: uppercase;">Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $santriList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $nilai = $existingNilai[$santri->id] ?? null;
                            ?>
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 16px; color: #64748b;"><?php echo e($index + 1); ?></td>
                                <td style="padding: 16px; font-weight: 500; color: #1e293b;"><?php echo e($santri->nama_santri); ?></td>
                                <!-- Inputs M1-M4 -->
                                <?php $__currentLoopData = ['m1' => 'minggu_1', 'm2' => 'minggu_2', 'm3' => 'minggu_3', 'm4' => 'minggu_4']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td style="padding: 10px;">
                                    <input type="number" 
                                           name="nilai[<?php echo e($santri->id); ?>][<?php echo e($key); ?>]" 
                                           value="<?php echo e($nilai ? $nilai->$col : ''); ?>" 
                                           class="mingguan-input"
                                           data-santri="<?php echo e($santri->id); ?>"
                                           min="0" max="100" step="0.1"
                                           style="width: 100%; padding: 8px; text-align: center; border: 1px solid #e2e8f0; border-radius: 6px;">
                                </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <td style="padding: 16px; text-align: center; font-weight: 600; color: #4f46e5;">
                                    <span id="avg-<?php echo e($santri->id); ?>"><?php echo e($nilai ? number_format($nilai->rata_rata, 1) : '-'); ?></span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" style="padding: 40px; text-align: center; color: #94a3b8; font-style: italic;">
                                    Tidak ada santri di kelas ini.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
<?php else: ?>
    <div style="background: #eff6ff; border: 1px solid #dbeafe; border-radius: 12px; padding: 40px; text-align: center;">
        <div style="background: white; width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
            <i data-feather="filter" style="width: 32px; height: 32px; color: #3b82f6;"></i>
        </div>
        <h3 style="margin: 0 0 8px; color: #1e3a8a;">Pilih Kelas dan Mata Pelajaran</h3>
        <p style="margin: 0; color: #64748b;">Silakan pilih kelas dan mata pelajaran (Ujian Mingguan) terlebih dahulu untuk mulai menginput nilai.</p>
    </div>
<?php endif; ?>
<?php /**PATH C:\Users\v\.gemini\antigravity\scratch\dashboard-riyadlul-huda\resources\views\pendidikan\nilai-mingguan\table.blade.php ENDPATH**/ ?>