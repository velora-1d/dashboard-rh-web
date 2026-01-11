@extends('layouts.app')

@section('title', 'Cek Tunggakan')
@section('page-title', 'Cek Tunggakan Santri')

@section('sidebar-menu')
    @include('bendahara.partials.sidebar-menu')
@endsection

@section('content')
<style>
    .tunggakan-filter-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 24px;
        color: white;
        margin-bottom: 24px;
    }
    .tunggakan-filter-card label {
        color: rgba(255,255,255,0.9);
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: block;
    }
    .tunggakan-filter-card select {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        padding: 10px 14px;
        border-radius: 10px;
        width: 100%;
        font-size: 14px;
    }
    .tunggakan-filter-card select option {
        color: #333;
        background: white;
    }
    .tunggakan-filter-card .filter-btn {
        background: white;
        color: #667eea;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }
    .tunggakan-filter-card .filter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border-left: 4px solid #667eea;
    }
    .stat-card.danger { border-left-color: #ef4444; }
    .stat-card.warning { border-left-color: #f59e0b; }
    .stat-card .stat-value {
        font-size: 28px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 4px;
    }
    .stat-card .stat-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
    }
    .tunggakan-table {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .tunggakan-table table {
        width: 100%;
        border-collapse: collapse;
    }
    .tunggakan-table th {
        background: #f8fafc;
        padding: 16px;
        text-align: left;
        font-weight: 600;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .tunggakan-table td {
        padding: 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }
    .tunggakan-table tr:hover {
        background: #f8fafc;
    }
    .badge-tunggakan {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }
    .btn-detail {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-detail:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(102, 126, 234, 0.4);
    }
    @media print {
        @page { size: A4 landscape; margin: 1cm; }
        body { background: white; -webkit-print-color-adjust: exact !important; }
        .sidebar, .page-header, .no-print, .tunggakan-filter-card { display: none !important; }
        .main-content { margin: 0 !important; padding: 0 !important; }
        .tunggakan-table { box-shadow: none !important; border: 1px solid #ddd !important; }
    }
</style>

<div class="container-fluid" style="padding: 20px;">
    <!-- Page Header -->
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 28px; font-weight: 800; color: #1e293b; margin-bottom: 8px;">
            <i class="fas fa-file-invoice-dollar" style="color: #667eea; margin-right: 12px;"></i>
            Cek Tunggakan Santri
        </h1>
        <p style="color: #64748b; font-size: 15px;">Pantau status pembayaran Syahriah seluruh santri secara realtime.</p>
    </div>

    <!-- Blast WA Card -->
    <div style="background: linear-gradient(to right, #4f46e5, #4338ca); border-radius: 16px; box-shadow: 0 10px 30px rgba(79, 70, 229, 0.2); overflow: hidden; color: white; display: flex; align-items: center; justify-content: space-between; padding: 24px; position: relative; margin-bottom: 24px;">
        <div style="position: relative; z-index: 2;">
            <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 8px;">📢 Blast Tagihan WA</h3>
            <p style="opacity: 0.9; margin-bottom: 16px; max-width: 600px; font-size: 0.9rem;">Kirim notifikasi tagihan otomatis ke seluruh wali santri yang memiliki tunggakan. Sistem akan mengirim pesan satu per satu dengan jeda aman (Anti-Banned).</p>
            <button onclick="startBillingProcess()" type="button" style="background: white; color: #4338ca; padding: 10px 20px; border-radius: 10px; font-weight: 700; border: none; display: flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(0,0,0,0.1);" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                <i data-feather="send" style="width: 16px; height: 16px;"></i>
                Mulai Proses Penagihan
            </button>
        </div>
        <div style="position: absolute; right: -20px; top: -30px; opacity: 0.1;">
            <i data-feather="message-circle" style="width: 200px; height: 200px;"></i>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="tunggakan-filter-card no-print">
        <form action="{{ route('bendahara.cek-tunggakan') }}" method="GET">
            <div class="row" style="display: flex; gap: 16px; flex-wrap: wrap; align-items: flex-end;">
                <div style="flex: 1; min-width: 180px;">
                    <label>Asrama</label>
                    <select name="asrama_id">
                        <option value="">Semua Asrama</option>
                        @foreach($asramaList as $asrama)
                            <option value="{{ $asrama->id }}" {{ request('asrama_id') == $asrama->id ? 'selected' : '' }}>{{ $asrama->nama_asrama }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="flex: 1; min-width: 180px;">
                    <label>Kelas</label>
                    <select name="kelas_id">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="flex: 1; min-width: 180px;">
                    <label>Gender</label>
                    <select name="gender">
                        <option value="">Semua Gender</option>
                        <option value="putra" {{ request('gender') == 'putra' ? 'selected' : '' }}>Putra</option>
                        <option value="putri" {{ request('gender') == 'putri' ? 'selected' : '' }}>Putri</option>
                    </select>
                </div>
                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="filter-btn">
                        <i class="fas fa-filter" style="margin-right: 6px;"></i> Terapkan Filter
                    </button>
                    @if(request()->anyFilled(['kelas_id', 'asrama_id', 'gender']))
                        <a href="{{ route('bendahara.cek-tunggakan') }}" style="background: rgba(255,255,255,0.2); color: white; padding: 12px 16px; border-radius: 10px; text-decoration: none; font-weight: 600;">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Summary Stats -->
    <div class="row mb-4" style="display: flex; gap: 16px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 200px;">
            <div class="stat-card">
                <div class="stat-value">{{ $totalSantriMenunggak }}</div>
                <div class="stat-label">Santri Menunggak</div>
            </div>
        </div>
        <div style="flex: 1; min-width: 200px;">
            <div class="stat-card warning">
                <div class="stat-value">{{ $grandTotalBulan }}</div>
                <div class="stat-label">Total Bulan Tunggakan</div>
            </div>
        </div>
        <div style="flex: 1; min-width: 200px;">
            <div class="stat-card danger">
                <div class="stat-value" style="color: #dc2626;">Rp {{ number_format($grandTotalRupiah, 0, ',', '.') }}</div>
                <div class="stat-label">Total Nominal Tunggakan</div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="tunggakan-table">
        <div style="padding: 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h4 style="font-size: 18px; font-weight: 700; color: #1e293b; margin: 0;">Daftar Santri Yang Menunggak</h4>
                <small style="color: #64748b;">Biaya Syahriah: Rp {{ number_format($biayaBulanan, 0, ',', '.') }}/bulan</small>
            </div>
            <a href="{{ route('bendahara.cek-tunggakan.export', request()->query()) }}" target="_blank" class="no-print" style="background: #0f172a; color: white; padding: 10px 20px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block;">
                <i class="fas fa-file-export" style="margin-right: 6px;"></i> Cetak Masal (Excel)
            </a>
        </div>
        <table>
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center;">No</th>
                    <th>NIS</th>
                    <th>Nama Santri</th>
                    <th>Kelas</th>
                    <th style="text-align: center;">Tunggakan</th>
                    <th style="text-align: right;">Total (Rp)</th>
                    <th style="text-align: center; width: 100px;" class="no-print">Cetak</th>
                </tr>
            </thead>
            <tbody>
                @forelse($santriWithArrearsPaginated as $index => $item)
                    <tr>
                        <td style="text-align: center;">{{ $santriWithArrearsPaginated->firstItem() + $index }}</td>
                        <td style="font-weight: 500;">{{ $item['santri']->nis }}</td>
                        <td style="font-weight: 600; color: #1e293b;">{{ $item['santri']->nama_santri }}</td>
                        <td>{{ $item['santri']->kelas->nama_kelas ?? '-' }}</td>
                        <td style="text-align: center;">
                            <span class="badge-tunggakan">{{ $item['unpaid_months'] }} bulan</span>
                        </td>
                        <td style="text-align: right; color: #dc2626; font-weight: 700;">
                            Rp {{ number_format($item['total_arrears'], 0, ',', '.') }}
                        </td>
                        <td style="text-align: center;" class="no-print">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                @if($item['santri']->no_hp_ortu_wali)
                                @php
                                    $phone = $item['santri']->no_hp_ortu_wali;
                                    $phone = preg_replace('/[^0-9]/', '', $phone);
                                    if (substr($phone, 0, 1) === '0') {
                                        $phone = '62' . substr($phone, 1);
                                    } elseif (substr($phone, 0, 2) !== '62') {
                                        $phone = '62' . $phone;
                                    }
                                    $msg = "Assalamu'alaikum Wr. Wb.\n\nYth. Wali dari Ananda *{$item['santri']->nama_santri}*\nNIS: {$item['santri']->nis}\nKelas: " . ($item['santri']->kelas->nama_kelas ?? '-') . "\n\nKami informasikan bahwa terdapat *tunggakan Syahriah* sebanyak {$item['unpaid_months']} bulan.\n\n💰 *Total Tunggakan:* Rp " . number_format($item['total_arrears'], 0, ',', '.') . "\n\nMohon dapat melunasi melalui Bendahara PP Riyadlul Huda.\n\nJazakumullahu Khairan.\n_Bendahara PP Riyadlul Huda_";
                                    $waUrl = "https://wa.me/{$phone}?text=" . urlencode($msg);
                                @endphp
                                <a href="{{ $waUrl }}" target="_blank" style="background: linear-gradient(135deg, #25D366 0%, #128C7E 100%); color: white; border: none; padding: 8px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 4px; text-decoration: none;" title="Kirim Tagihan via WhatsApp">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    WA
                                </a>
                                @endif
                                <form action="{{ route('bendahara.cek-tunggakan.process') }}" method="POST" style="display: inline;" data-turbo="false" target="_blank">
                                    @csrf
                                    <input type="hidden" name="santri_id" value="{{ $item['santri']->id }}">
                                    <input type="hidden" name="biaya_bulanan" value="{{ $biayaBulanan }}">
                                    <button type="submit" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; border: none; padding: 8px 14px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px;" title="Cetak Laporan Santri Ini">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                                        Cetak
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 60px;">
                            <div style="display: flex; flex-direction: column; align-items: center;">
                                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px; color: #16a34a; margin-bottom: 16px;">
                                    <i class="fas fa-check-double"></i>
                                </div>
                                <h4 style="font-size: 20px; font-weight: 700; color: #1e293b; margin-bottom: 8px;">Alhamdulillah!</h4>
                                <p style="color: #64748b; margin: 0;">Tidak ada santri yang memiliki tunggakan.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Pagination -->
        @if($santriWithArrearsPaginated->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <span style="color: #64748b; font-size: 14px;">
                Menampilkan {{ $santriWithArrearsPaginated->firstItem() }} - {{ $santriWithArrearsPaginated->lastItem() }} dari {{ $santriWithArrearsPaginated->total() }} santri
            </span>
            <div style="display: flex; gap: 8px;">
                @if($santriWithArrearsPaginated->onFirstPage())
                    <span style="padding: 8px 14px; background: #f1f5f9; color: #94a3b8; border-radius: 8px; font-size: 14px;">← Sebelumnya</span>
                @else
                    <a href="{{ $santriWithArrearsPaginated->previousPageUrl() }}" style="padding: 8px 14px; background: #667eea; color: white; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600;">← Sebelumnya</a>
                @endif
                
                @if($santriWithArrearsPaginated->hasMorePages())
                    <a href="{{ $santriWithArrearsPaginated->nextPageUrl() }}" style="padding: 8px 14px; background: #667eea; color: white; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600;">Berikutnya →</a>
                @else
                    <span style="padding: 8px 14px; background: #f1f5f9; color: #94a3b8; border-radius: 8px; font-size: 14px;">Berikutnya →</span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
    <!-- Billing Progress Modal -->
    <div id="billing-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(5px);">
        <div style="background: white; padding: 32px; border-radius: 20px; width: 500px; max-width: 90%; box-shadow: 0 20px 50px rgba(0,0,0,0.2);">
            <div style="text-align: center; margin-bottom: 24px;">
                <div style="width: 64px; height: 64px; background: #eef2ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i data-feather="loader" id="billing-spinner" class="spin-icon" style="width: 32px; height: 32px; color: #4f46e5;"></i>
                    <i data-feather="check-circle" id="billing-success-icon" style="width: 32px; height: 32px; color: #10b981; display: none;"></i>
                </div>
                <h3 id="billing-status-title" style="font-size: 1.25rem; font-weight: 800; color: #1e2937; margin-bottom: 8px;">Menyiapkan Data...</h3>
                <p id="billing-status-desc" style="color: #64748b;">Mohon tunggu, sedang mengambil daftar tunggakan.</p>
            </div>

            <!-- Progress Bar -->
            <div style="background: #f1f5f9; height: 12px; border-radius: 6px; overflow: hidden; margin-bottom: 24px;">
                <div id="billing-progress" style="background: #4f46e5; height: 100%; width: 0%; transition: width 0.3s ease;"></div>
            </div>

            <!-- Log Area -->
            <div id="billing-log" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; height: 150px; overflow-y: auto; padding: 12px; font-size: 0.85rem; color: #475569; margin-bottom: 24px; font-family: monospace;">
                <!-- Logs here -->
            </div>

            <button onclick="closeBillingModal()" id="btn-close-billing" style="display: none; width: 100%; background: #4f46e5; color: white; padding: 12px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer;">Selesai & Tutup</button>
        </div>
    </div>

    <style>
        @keyframes spin { 100% { transform: rotate(360deg); } }
        .spin-icon { animation: spin 1s linear infinite; }
    </style>
@endsection

@push('scripts')
<script>
    // Billing Blast Logic
    let billingTargets = [];
    let billingIndex = 0;
    let stopBilling = false;

    function startBillingProcess() {
        Swal.fire({
            title: 'Mulai Penagihan Massal?',
            text: "Sistem akan mencari santri yang menunggak dan mengirim pesan WA satu per satu.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Mulai!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetchTargets();
            }
        });
    }

    function fetchTargets() {
        // Show Modal
        document.getElementById('billing-modal').style.display = 'flex';
        document.getElementById('billing-log').innerHTML = '';
        document.getElementById('billing-progress').style.width = '0%';
        
        logBilling('Mengambil data tunggakan...');

        fetch("{{ route('bendahara.billing.targets') }}")
            .then(response => response.json())
            .then(data => {
                if (data.count === 0) {
                    logBilling('❌ Tidak ada tunggakan ditemukan.');
                    document.getElementById('billing-status-title').innerText = 'Selesai';
                    document.getElementById('billing-status-desc').innerText = 'Tidak ada santri yang perlu ditagih.';
                    document.getElementById('btn-close-billing').style.display = 'block';
                    return;
                }

                billingTargets = data.targets;
                billingIndex = 0;
                stopBilling = false;
                
                logBilling(`✅ Ditemukan ${data.count} santri dengan tunggakan.`);
                processNextBilling();
            })
            .catch(error => {
                logBilling('❌ Error fetching data: ' + error);
            });
    }

    function processNextBilling() {
        if (stopBilling || billingIndex >= billingTargets.length) {
            finishBilling();
            return;
        }

        const target = billingTargets[billingIndex];
        const progress = Math.round(((billingIndex + 1) / billingTargets.length) * 100);
        
        document.getElementById('billing-progress').style.width = `${progress}%`;
        document.getElementById('billing-status-title').innerText = `Mengirim ${billingIndex + 1} dari ${billingTargets.length}`;
        document.getElementById('billing-status-desc').innerText = `Mengirim ke: ${target.nama}`;

        // Send Request
        fetch("{{ route('bendahara.billing.send') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(target)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                logBilling(`✅ [${billingIndex+1}/${billingTargets.length}] Terkirim: ${target.nama}`);
            } else {
                logBilling(`❌ [${billingIndex+1}/${billingTargets.length}] Gagal: ${target.nama}`);
            }
        })
        .catch(error => {
            logBilling(`❌ [${billingIndex+1}/${billingTargets.length}] Error: ${target.nama}`);
        })
        .finally(() => {
            billingIndex++;
            // Random Delay 3 - 8 seconds
            const delay = Math.floor(Math.random() * (8000 - 3000 + 1) + 3000);
            logBilling(`⏳ Jeda ${delay/1000} detik...`);
            
            setTimeout(processNextBilling, delay);
        });
    }

    function finishBilling() {
        document.getElementById('billing-status-title').innerText = 'Selesai!';
        document.getElementById('billing-status-desc').innerText = 'Proses penagihan telah selesai.';
        document.getElementById('billing-spinner').style.display = 'none';
        document.getElementById('billing-success-icon').style.display = 'block';
        document.getElementById('btn-close-billing').style.display = 'block';
        logBilling('🏁 Proses selesai.');
    }

    function logBilling(msg) {
        const logDiv = document.getElementById('billing-log');
        const div = document.createElement('div');
        div.innerText = `[${new Date().toLocaleTimeString()}] ${msg}`;
        div.style.marginBottom = '4px';
        logDiv.appendChild(div);
        logDiv.scrollTop = logDiv.scrollHeight;
    }

    function closeBillingModal() {
        document.getElementById('billing-modal').style.display = 'none';
        window.location.reload(); // Reload to refresh page
    }
</script>
@endpush
