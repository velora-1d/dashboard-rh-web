{{-- Floating Help/FAQ Button and Modal --}}
@php
    $currentRoute = Route::currentRouteName();
    $userRole = auth()->user()->role ?? 'guest';
    
    // Only show for non-admin roles
    $showHelp = !in_array($userRole, ['admin', 'admin_pusat', 'guest']);
    
    // Determine FAQ context based on route
    $faqContext = 'dashboard';
    if (str_contains($currentRoute, 'nilai')) $faqContext = 'nilai';
    elseif (str_contains($currentRoute, 'rapor') || str_contains($currentRoute, 'laporan')) $faqContext = 'laporan';
    elseif (str_contains($currentRoute, 'jadwal')) $faqContext = 'jadwal';
    elseif (str_contains($currentRoute, 'absensi')) $faqContext = 'absensi';
    elseif (str_contains($currentRoute, 'mapel') || str_contains($currentRoute, 'mata-pelajaran')) $faqContext = 'mapel';
    elseif (str_contains($currentRoute, 'ijazah')) $faqContext = 'ijazah';
    elseif (str_contains($currentRoute, 'kalender')) $faqContext = 'kalender';
    elseif (str_contains($currentRoute, 'talaran')) $faqContext = 'talaran';
    elseif (str_contains($currentRoute, 'ujian-mingguan')) $faqContext = 'ujian-mingguan';
    elseif (str_contains($currentRoute, 'data-santri')) $faqContext = 'data-santri';
    elseif (str_contains($currentRoute, 'mutasi')) $faqContext = 'mutasi';
    elseif (str_contains($currentRoute, 'kenaikan')) $faqContext = 'kenaikan';
    elseif (str_contains($currentRoute, 'perpindahan')) $faqContext = 'perpindahan';
    elseif (str_contains($currentRoute, 'syahriah')) $faqContext = 'syahriah';
    elseif (str_contains($currentRoute, 'tunggakan')) $faqContext = 'tunggakan';
    elseif (str_contains($currentRoute, 'pemasukan')) $faqContext = 'pemasukan';
    elseif (str_contains($currentRoute, 'pengeluaran')) $faqContext = 'pengeluaran';
    elseif (str_contains($currentRoute, 'pegawai')) $faqContext = 'pegawai';
    elseif (str_contains($currentRoute, 'gaji')) $faqContext = 'gaji';
    
    // FAQ Data per Role
    $faqs = [
        'pendidikan' => [
            'dashboard' => [
                ['q' => 'Apa yang ditampilkan di Dashboard?', 'a' => 'Dashboard menampilkan ringkasan data santri, nilai rata-rata, statistik kehadiran, dan grafik prestasi. Gunakan filter di atas untuk melihat data berdasarkan tahun ajaran, semester, atau kelas tertentu.'],
                ['q' => 'Bagaimana cara menggunakan filter?', 'a' => 'Pilih Tahun Ajaran, Semester, Kelas, Gender, dan Mata Pelajaran sesuai kebutuhan, lalu klik tombol "Terapkan Filter" untuk memperbarui data.'],
            ],
            'nilai' => [
                ['q' => 'Bagaimana cara input nilai?', 'a' => 'Pilih Tahun Ajaran, Semester, dan Kelas terlebih dahulu. Kemudian isi nilai pada kolom yang tersedia untuk setiap santri dan mata pelajaran. Nilai akan otomatis tersimpan.'],
                ['q' => 'Apa itu Smart Scoring?', 'a' => 'Smart Scoring memilih nilai tertinggi antara Nilai Semester dan Nilai Mingguan secara otomatis untuk ditampilkan di rapor.'],
                ['q' => 'Kenapa ada kolom "Nilai Asli" dan "Nilai Rapor"?', 'a' => 'Nilai Asli adalah nilai sebenarnya dari ujian. Nilai Rapor adalah nilai yang ditampilkan di rapor (minimal 5 untuk menjaga motivasi santri).'],
            ],
            'laporan' => [
                ['q' => 'Bagaimana cara cetak rapor?', 'a' => 'Pilih Tahun Ajaran, Semester, dan Kelas. Klik "Export Rapor Kelas" untuk mencetak rapor semua santri sekaligus, atau pilih santri tertentu untuk cetak individual.'],
                ['q' => 'Format apa yang tersedia?', 'a' => 'Laporan tersedia dalam format PDF yang siap cetak.'],
            ],
            'absensi' => [
                ['q' => 'Bagaimana cara input absensi?', 'a' => 'Pilih Tahun, Minggu ke, dan Kelas. Kemudian isi jumlah alfa untuk setiap kategori (Sorogan, Menghafal Malam, Subuh, Tahajud) per santri.'],
                ['q' => 'Apa itu Minggu ke-?', 'a' => 'Minggu ke adalah urutan minggu dalam satu tahun (1-52). Digunakan untuk tracking absensi mingguan.'],
            ],
            'jadwal' => [
                ['q' => 'Bagaimana cara mengatur jadwal?', 'a' => 'Klik tombol "Tambah Jadwal" dan isi mata pelajaran, hari, jam mulai/selesai, dan guru pengampu.'],
            ],
            'mapel' => [
                ['q' => 'Bagaimana cara menambah mata pelajaran?', 'a' => 'Klik tombol "Tambah Mapel", isi nama dan kode mapel. Centang "Wajib Ujian Mingguan" jika mapel ini ada ujian mingguannya.'],
            ],
            'ijazah' => [
                ['q' => 'Bagaimana cara cetak ijazah?', 'a' => 'Pilih jenis ijazah (Ibtida/Tsanawi/Ma\'had Aly) dan kelas. Pastikan data nilai sudah lengkap sebelum mencetak.'],
            ],
            'talaran' => [
                ['q' => 'Apa itu Sistem Talaran?', 'a' => 'Sistem Talaran adalah fitur untuk mencatat setoran hafalan santri setiap minggu. Setiap santri memiliki target setoran yang harus dipenuhi.'],
                ['q' => 'Bagaimana cara input setoran hafalan?', 'a' => 'Pilih Kelas dan Minggu ke-. Kemudian isi jumlah halaman/juz yang disetorkan santri pada kolom yang tersedia. Klik simpan setelah selesai.'],
                ['q' => 'Apa yang dimaksud Alfa?', 'a' => 'Alfa berarti santri tidak menyetor hafalan pada minggu tersebut. Jika kolom setoran kosong atau 0, santri dianggap Alfa.'],
                ['q' => 'Bagaimana cara mencetak laporan Talaran?', 'a' => 'Gunakan tombol "Cetak" untuk mencetak rekap setoran hafalan. Tersedia format 1-2 minggu, 3-4 minggu, atau laporan lengkap.'],
                ['q' => 'Apakah data Talaran mempengaruhi nilai rapor?', 'a' => 'Ya, data setoran Talaran dapat digunakan sebagai salah satu komponen penilaian hafalan di rapor santri.'],
            ],
            'ujian-mingguan' => [
                ['q' => 'Apa itu Ujian Mingguan?', 'a' => 'Ujian Mingguan adalah sistem penilaian mingguan untuk mata pelajaran tertentu. Nilai dari 4 minggu akan dirata-rata untuk menentukan status LULUS/TIDAK LULUS.'],
                ['q' => 'Bagaimana cara input nilai ujian mingguan?', 'a' => 'Pilih Kelas dan Mata Pelajaran. Kemudian isi nilai ujian santri pada kolom Minggu 1 sampai Minggu 4. Nilai akan otomatis dihitung rata-ratanya.'],
                ['q' => 'Bagaimana menentukan status kelulusan?', 'a' => 'Santri dinyatakan LULUS jika mengikuti minimal 3 dari 4 minggu ujian dan nilai rata-rata mencapai standar minimal yang ditentukan.'],
                ['q' => 'Apa perbedaan Ujian Mingguan dengan Sistem Talaran?', 'a' => 'Ujian Mingguan untuk menilai pemahaman materi pelajaran dengan skor. Talaran untuk mencatat setoran hafalan Al-Quran/kitab secara mingguan.'],
            ],
        ],
        'sekretaris' => [
            'dashboard' => [
                ['q' => 'Apa fungsi Dashboard Sekretaris?', 'a' => 'Dashboard menampilkan ringkasan jumlah santri, asrama, kelas, dan kobong. Gunakan Quick Actions untuk akses cepat ke fitur utama.'],
            ],
            'data-santri' => [
                ['q' => 'Bagaimana cara menambah santri baru?', 'a' => 'Klik tombol "Tambah Santri", isi formulir dengan data lengkap, pilih kelas dan asrama, lalu simpan.'],
                ['q' => 'Bagaimana cara edit data santri?', 'a' => 'Cari santri di tabel, klik tombol "Edit" (ikon pensil), ubah data yang diperlukan, lalu simpan.'],
                ['q' => 'Bagaimana cara menonaktifkan santri?', 'a' => 'Klik tombol "Hapus" (ikon tempat sampah). Santri tidak benar-benar dihapus, hanya dinonaktifkan (status: tidak aktif).'],
                ['q' => 'Bagaimana cara import data santri?', 'a' => 'Unduh template Excel/CSV terlebih dahulu, isi dengan data santri, lalu upload file tersebut menggunakan fitur Import.'],
            ],
            'mutasi' => [
                ['q' => 'Apa itu Mutasi Santri?', 'a' => 'Mutasi adalah perpindahan santri keluar dari pondok, bisa karena pindah, keluar, atau lulus.'],
                ['q' => 'Bagaimana cara memproses mutasi?', 'a' => 'Pilih santri yang akan dimutasi, pilih jenis mutasi (Pindah/Keluar/Lulus), isi alasan dan tanggal mutasi, lalu simpan.'],
            ],
            'kenaikan' => [
                ['q' => 'Bagaimana cara kenaikan kelas massal?', 'a' => 'Pilih kelas asal, centang santri yang naik kelas, pilih kelas tujuan, lalu klik "Proses Kenaikan Kelas".'],
            ],
            'perpindahan' => [
                ['q' => 'Apa perbedaan Perpindahan dan Mutasi?', 'a' => 'Perpindahan adalah pindah asrama/kobong internal. Mutasi adalah keluar dari pondok.'],
                ['q' => 'Bagaimana cara memindah santri ke asrama lain?', 'a' => 'Pilih santri, pilih asrama dan kobong tujuan, lalu simpan perubahan.'],
            ],
            'laporan' => [
                ['q' => 'Laporan apa saja yang tersedia?', 'a' => 'Tersedia laporan: Daftar Santri, Statistik per Kelas, Statistik per Asrama, dan Riwayat Mutasi.'],
            ],
        ],
        'bendahara' => [
            'dashboard' => [
                ['q' => 'Apa yang ditampilkan di Dashboard?', 'a' => 'Dashboard menampilkan ringkasan keuangan: pemasukan, pengeluaran, saldo, grafik per bulan, dan status syahriah santri.'],
            ],
            'syahriah' => [
                ['q' => 'Apa itu Syahriah?', 'a' => 'Syahriah adalah biaya bulanan santri (SPP). Setiap santri memiliki record syahriah untuk setiap bulan.'],
                ['q' => 'Bagaimana cara mencatat pembayaran?', 'a' => 'Cari santri, klik bulan yang akan dibayar, isi nominal dan tanggal bayar, lalu simpan. Status akan berubah menjadi "Lunas".'],
                ['q' => 'Bagaimana jika santri bayar beberapa bulan sekaligus?', 'a' => 'Input pembayaran satu per satu per bulan, atau gunakan fitur "Bayar Sekaligus" jika tersedia.'],
            ],
            'tunggakan' => [
                ['q' => 'Bagaimana cara cek tunggakan?', 'a' => 'Pilih filter (tahun, bulan, kelas, atau asrama) untuk melihat daftar santri yang masih menunggak.'],
                ['q' => 'Bagaimana cara export laporan tunggakan?', 'a' => 'Setelah memfilter, klik tombol "Export PDF" untuk mencetak daftar tunggakan.'],
            ],
            'pemasukan' => [
                ['q' => 'Apa saja yang termasuk pemasukan?', 'a' => 'Pemasukan meliputi: Syahriah, Infaq, Donasi, dan sumber lainnya.'],
                ['q' => 'Bagaimana cara mencatat pemasukan?', 'a' => 'Klik "Tambah Pemasukan", isi kategori, nominal, tanggal, dan keterangan, lalu simpan.'],
            ],
            'pengeluaran' => [
                ['q' => 'Bagaimana cara mencatat pengeluaran?', 'a' => 'Klik "Tambah Pengeluaran", pilih kategori (Operasional/Pembangunan/Gaji/Lainnya), isi nominal dan keterangan, lalu simpan.'],
            ],
            'pegawai' => [
                ['q' => 'Bagaimana cara menambah pegawai?', 'a' => 'Klik "Tambah Pegawai", isi nama, jabatan, dan gaji pokok, lalu simpan.'],
            ],
            'gaji' => [
                ['q' => 'Bagaimana cara mencatat pembayaran gaji?', 'a' => 'Pilih pegawai, bulan, dan tahun. Isi nominal gaji (bisa berbeda dari gaji pokok jika ada potongan/bonus), lalu simpan.'],
            ],
            'laporan' => [
                ['q' => 'Laporan apa saja yang tersedia?', 'a' => 'Tersedia laporan: Syahriah, Pemasukan, Pengeluaran, Neraca Kas, Gaji Pegawai, dan Laporan Keuangan Lengkap.'],
            ],
        ],
    ];
    
    $currentFaqs = $faqs[$userRole][$faqContext] ?? $faqs[$userRole]['dashboard'] ?? [];
@endphp

@if($showHelp && count($currentFaqs) > 0)
<style>
    .help-fab-container {
        position: fixed;
        bottom: 100px;
        right: 24px;
        z-index: 999;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }
    .help-fab-label {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-size: 11px;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        animation: floatLabel 3s ease-in-out infinite;
    }
    .help-fab {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 6px 25px rgba(102, 126, 234, 0.5);
        transition: all 0.3s ease;
        border: 3px solid rgba(255,255,255,0.3);
        animation: floatButton 3s ease-in-out infinite;
    }
    .help-fab:hover {
        transform: scale(1.15);
        box-shadow: 0 8px 35px rgba(102, 126, 234, 0.6);
    }
    .help-fab svg {
        width: 28px;
        height: 28px;
        fill: white;
    }
    @keyframes floatButton {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
    }
    @keyframes floatLabel {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }
    
    /* Modal Styles */
    .help-modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        backdrop-filter: blur(4px);
    }
    .help-modal {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        width: 90%;
        max-width: 600px;
        max-height: 80vh;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }
    .help-modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .help-modal-title {
        color: white;
        font-size: 18px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .help-modal-close {
        background: rgba(255,255,255,0.2);
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.2s;
    }
    .help-modal-close:hover {
        background: rgba(255,255,255,0.3);
    }
    .help-modal-close i {
        width: 16px;
        height: 16px;
        color: white;
    }
    .help-modal-body {
        padding: 24px;
        max-height: calc(80vh - 80px);
        overflow-y: auto;
    }
    .faq-item {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 12px;
        overflow: hidden;
    }
    .faq-question {
        background: #f8fafc;
        padding: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-weight: 600;
        color: #1f2937;
        transition: background 0.2s;
    }
    .faq-question:hover {
        background: #f1f5f9;
    }
    .faq-question i {
        width: 20px;
        height: 20px;
        color: #6b7280;
        transition: transform 0.3s;
    }
    .faq-question.active i {
        transform: rotate(180deg);
    }
    .faq-answer {
        display: none;
        padding: 16px;
        color: #4b5563;
        line-height: 1.6;
        border-top: 1px solid #e5e7eb;
    }
    .faq-answer.show {
        display: block;
    }
    .help-context-badge {
        background: rgba(255,255,255,0.2);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    /* Mobile responsive - smaller FAQ button */
    @media (max-width: 768px) {
        .help-fab-container {
            bottom: 24px;
            right: 16px;
        }
        .help-fab-label {
            display: none;
        }
        .help-fab {
            width: 44px;
            height: 44px;
            border-width: 2px;
        }
        .help-fab svg {
            width: 20px;
            height: 20px;
        }
        .help-modal {
            width: 95%;
            max-height: 85vh;
        }
        .help-modal-header {
            padding: 16px;
        }
        .help-modal-title {
            font-size: 16px;
        }
        .help-modal-body {
            padding: 16px;
        }
        .faq-question {
            padding: 12px;
            font-size: 14px;
        }
        .faq-answer {
            padding: 12px;
            font-size: 13px;
        }
    }
</style>

<!-- Floating Help Button with Label -->
<div class="help-fab-container">
    <div class="help-fab-label">Bantuan</div>
    <button class="help-fab" onclick="openHelpModal()" title="Bantuan">
        <!-- Robot Icon SVG -->
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2a2 2 0 0 1 2 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 0 1 7 7h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1H2a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h1a7 7 0 0 1 7-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 0 1 2-2M7.5 13A2.5 2.5 0 0 0 5 15.5A2.5 2.5 0 0 0 7.5 18a2.5 2.5 0 0 0 2.5-2.5A2.5 2.5 0 0 0 7.5 13m9 0a2.5 2.5 0 0 0-2.5 2.5a2.5 2.5 0 0 0 2.5 2.5a2.5 2.5 0 0 0 2.5-2.5a2.5 2.5 0 0 0-2.5-2.5Z"/>
        </svg>
    </button>
</div>

<!-- Help Modal -->
<div class="help-modal-overlay" id="helpModalOverlay" onclick="closeHelpModal()">
    <div class="help-modal" onclick="event.stopPropagation()">
        <div class="help-modal-header">
            <div class="help-modal-title">
                <i data-feather="help-circle" style="width: 24px; height: 24px;"></i>
                <span>Bantuan</span>
                <span class="help-context-badge">{{ ucfirst(str_replace('-', ' ', $faqContext)) }}</span>
            </div>
            <button class="help-modal-close" onclick="closeHelpModal()">
                <i data-feather="x"></i>
            </button>
        </div>
        <div class="help-modal-body">
            @foreach($currentFaqs as $index => $faq)
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <span>{{ $faq['q'] }}</span>
                    <i data-feather="chevron-down"></i>
                </div>
                <div class="faq-answer">
                    {{ $faq['a'] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
function openHelpModal() {
    document.getElementById('helpModalOverlay').style.display = 'block';
    document.body.style.overflow = 'hidden';
    if (typeof feather !== 'undefined') feather.replace();
}

function closeHelpModal() {
    document.getElementById('helpModalOverlay').style.display = 'none';
    document.body.style.overflow = '';
}

function toggleFaq(element) {
    const wasActive = element.classList.contains('active');
    
    // Close all
    document.querySelectorAll('.faq-question').forEach(q => q.classList.remove('active'));
    document.querySelectorAll('.faq-answer').forEach(a => a.classList.remove('show'));
    
    // Toggle current
    if (!wasActive) {
        element.classList.add('active');
        element.nextElementSibling.classList.add('show');
    }
}

// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeHelpModal();
});
</script>
@endif
