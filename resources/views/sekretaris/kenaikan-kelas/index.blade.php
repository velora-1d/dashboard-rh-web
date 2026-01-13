@extends('layouts.app')

@section('title', 'Kenaikan Kelas Massal')
@section('page-title', 'Kenaikan Kelas Massal')

@section('sidebar-menu')
    @include('sekretaris.partials.sidebar-menu')
@endsection

@section('content')
    @if(session('success'))
        <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; box-shadow: 0 4px 12px rgba(67, 233, 123, 0.3);">
            <i data-feather="check-circle" style="width: 24px; height: 24px;"></i>
            <span style="font-weight: 600;">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div style="background: linear-gradient(135deg, #ff6a00 0%, #ee0979 100%); color: white; padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; box-shadow: 0 4px 12px rgba(238, 9, 121, 0.3);">
            <i data-feather="alert-circle" style="width: 24px; height: 24px;"></i>
            <span style="font-weight: 600;">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Header with Gradient -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 24px 32px; margin-bottom: 24px; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -30px; right: -30px; width: 120px; height: 120px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
        <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
            <div style="background: rgba(255,255,255,0.2); width: 56px; height: 56px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i data-feather="trending-up" style="width: 28px; height: 28px; color: white;"></i>
            </div>
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 700; color: white; margin: 0 0 4px 0;">Kenaikan Kelas Massal</h2>
                <p style="color: rgba(255,255,255,0.9); font-size: 0.875rem; margin: 0;">Naikkan kelas santri secara massal - bisa loncat kelas jika diperlukan</p>
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 12px; padding: 16px 20px; margin-bottom: 24px;">
        <div style="display: flex; align-items: flex-start; gap: 12px; color: white;">
            <i data-feather="info" style="width: 18px; height: 18px; flex-shrink: 0; margin-top: 2px;"></i>
            <div style="font-size: 13px; line-height: 1.6;">
                <strong>Cara Penggunaan:</strong> Pilih kelas asal → Pilih kelas tujuan (bisa loncat kelas) → Centang santri yang akan <strong>NAIK KELAS</strong> → Proses
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div style="background: white; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); overflow: hidden;">
        <form method="POST" action="{{ route('sekretaris.kenaikan-kelas.process') }}" style="padding: 24px;">
            @csrf
            
            <!-- Kelas & Gender Selection -->
            <div style="display: grid; grid-template-columns: 1fr auto 1fr auto 1fr; gap: 16px; margin-bottom: 24px; align-items: end;">
                <div>
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 600; color: #374151; text-transform: uppercase; margin-bottom: 6px;">
                        <i data-feather="book" style="width: 14px; height: 14px; color: #667eea;"></i>
                        Kelas Asal <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="kelas_asal_id" id="kelas_asal_id" required style="width: 100%; height: 46px; border: 2px solid #e5e7eb; border-radius: 10px; padding: 0 14px; font-size: 14px; color: #1f2937; background: white; cursor: pointer; {{ auth()->user()->role === 'rois' ? 'background-color: #f1f5f9; cursor: not-allowed;' : '' }}" {{ auth()->user()->role === 'rois' ? 'disabled' : '' }}>
                        <option value="">Pilih Kelas Asal</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" data-nama="{{ $kelas->nama_kelas }}">{{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div style="display: flex; align-items: center; justify-content: center; width: 46px; height: 46px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%;">
                    <i data-feather="arrow-right" style="width: 22px; height: 22px; color: white;"></i>
                </div>
                
                <div>
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 600; color: #374151; text-transform: uppercase; margin-bottom: 6px;">
                        <i data-feather="book-open" style="width: 14px; height: 14px; color: #43e97b;"></i>
                        Kelas Tujuan <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="kelas_tujuan_id" id="kelas_tujuan_id" required style="width: 100%; height: 46px; border: 2px solid #e5e7eb; border-radius: 10px; padding: 0 14px; font-size: 14px; color: #1f2937; background: white; cursor: pointer; {{ auth()->user()->role === 'rois' ? 'background-color: #f1f5f9; cursor: not-allowed;' : '' }}" {{ auth()->user()->role === 'rois' ? 'disabled' : '' }}>
                        <option value="">Pilih Kelas Tujuan</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                        @endforeach
                        <option value="LULUS" style="color: #dc2626; font-weight: bold;">🎓 LULUS (Non-aktifkan)</option>
                    </select>
                </div>

                <div>
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 600; color: #374151; text-transform: uppercase; margin-bottom: 6px;">
                        <i data-feather="users" style="width: 14px; height: 14px; color: #f472b6;"></i>
                        Gender
                    </label>
                    <select name="gender" id="gender_filter" style="width: 100%; height: 46px; border: 2px solid #e5e7eb; border-radius: 10px; padding: 0 14px; font-size: 14px; color: #1f2937; background: white; cursor: pointer; {{ auth()->user()->role === 'rois' ? 'background-color: #f1f5f9; cursor: not-allowed;' : '' }}" {{ auth()->user()->role === 'rois' ? 'disabled' : '' }}>
                        <option value="">Semua</option>
                        <option value="putra">Putra</option>
                        <option value="putri">Putri</option>
                    </select>
                </div>
                
                <button type="button" id="load_santri_btn" style="height: 46px; padding: 0 20px; display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 10px; font-weight: 600; font-size: 13px; cursor: pointer; {{ auth()->user()->role === 'rois' ? 'opacity: 0.6; cursor: not-allowed;' : '' }}" {{ auth()->user()->role === 'rois' ? 'disabled' : '' }}>
                    <i data-feather="users" style="width: 18px; height: 18px;"></i>
                    Tampilkan
                </button>
            </div>

            <!-- Suggestion Badge -->
            <div id="suggestion_badge" style="display: none; margin-bottom: 20px;">
                <span style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: #fef3c7; border-radius: 8px; font-size: 12px; color: #92400e;">
                    <i data-feather="info" style="width: 14px; height: 14px;"></i>
                    <span id="suggestion_text">Saran: Kelas tujuan standar adalah...</span>
                </span>
            </div>

            <!-- Santri Table -->
            <div id="santri_container" style="display: none;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <h4 style="font-size: 15px; font-weight: 600; color: #1f2937; margin: 0;">
                        Daftar Santri (<span id="santri_count">0</span>)
                    </h4>
                    <label style="display: flex; align-items: center; gap: 8px; padding: 8px 14px; background: #dcfce7; border-radius: 8px; cursor: pointer; font-size: 12px; color: #166534;">
                        <input type="checkbox" id="select_all_naik" style="width: 16px; height: 16px;" checked>
                        Centang Semua (Naik Kelas)
                    </label>
                </div>

                <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden; margin-bottom: 20px; max-height: 400px; overflow-y: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0;">
                            <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <th style="padding: 12px 16px; text-align: center; font-size: 11px; font-weight: 600; color: white; width: 50px;">No</th>
                                <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: white;">NIS</th>
                                <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: white;">Nama Santri</th>
                                <th style="padding: 12px 16px; text-align: center; font-size: 11px; font-weight: 600; color: white;">Gender</th>
                                <th style="padding: 12px 16px; text-align: center; font-size: 11px; font-weight: 600; color: white; width: 130px;">
                                    <i data-feather="check-circle" style="width: 14px; height: 14px; vertical-align: middle;"></i> Naik?
                                </th>
                            </tr>
                        </thead>
                        <tbody id="santri_table_body">
                            <!-- Populated by JS -->
                        </tbody>
                    </table>
                </div>

                <!-- Summary Row -->
                <div style="display: flex; justify-content: space-between; align-items: center; background: #f9fafb; padding: 16px 20px; border-radius: 12px; margin-bottom: 24px;">
                    <div style="display: flex; gap: 24px;">
                        <div>
                            <span style="font-size: 12px; color: #6b7280; font-weight: 600; text-transform: uppercase;">Naik Kelas</span>
                            <div id="naik_count" style="font-size: 20px; font-weight: 700; color: #16a34a;">0</div>
                        </div>
                        <div>
                            <span style="font-size: 12px; color: #6b7280; font-weight: 600; text-transform: uppercase;">Tinggal Kelas</span>
                            <div id="tinggal_count" style="font-size: 20px; font-weight: 700; color: #dc2626;">0</div>
                        </div>
                    </div>
                </div>

                <div style="text-align: right;">
                    @if(auth()->user()->role !== 'rois')
                    <button type="submit" style="padding: 14px 40px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border: none; border-radius: 12px; font-weight: 600; font-size: 15px; cursor: pointer; box-shadow: 0 4px 12px rgba(67, 233, 123, 0.4); display: inline-flex; align-items: center; gap: 8px;">
                        <i data-feather="check-circle" style="width: 20px; height: 20px;"></i>
                        Proses Kenaikan Kelas
                    </button>
                    <p style="margin: 8px 0 0 0; font-size: 12px; color: #9ca3af;">
                        * Pastikan data sudah benar. Aksi ini tidak dapat dibatalkan dengan mudah.
                    </p>
                    @else
                    <div style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: #f3f4f6; color: #6b7280; border-radius: 12px; font-weight: 600;">
                        <i data-feather="lock" style="width: 18px; height: 18px;"></i>
                        Mode Baca Saja (Read-Only)
                    </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    function initKenaikanKelas() {
        const classMapping = @json($classMapping);
        let santriData = [];
        
        // Define API URL dynamically
        const routeSantriByKelas = "{{ route('sekretaris.api.santri-by-kelas', ':id') }}";

        // Suggest destination class when source class changes
        const kelasAsalSelect = document.getElementById('kelas_asal_id');
        if (kelasAsalSelect) {
            kelasAsalSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const namaKelas = selectedOption.dataset.nama;
                const kelasTujuanSuggested = classMapping[namaKelas];
                
                const badge = document.getElementById('suggestion_badge');
                const tujuanSelect = document.getElementById('kelas_tujuan_id');
                const textEl = document.getElementById('suggestion_text');
                
                if (kelasTujuanSuggested && badge && tujuanSelect) {
                    badge.style.display = 'block';
                    if (textEl) {
                        textEl.textContent = kelasTujuanSuggested === 'LULUS' 
                            ? 'Saran: Kelas ini adalah tingkat akhir → LULUS'
                            : `Saran: Kelas tujuan standar adalah ${kelasTujuanSuggested}`;
                    }
                    
                    // Auto-select the suggested destination
                    if (kelasTujuanSuggested === 'LULUS') {
                        tujuanSelect.value = 'LULUS';
                    } else {
                        // Find and select the matching option
                        for (let opt of tujuanSelect.options) {
                            if (opt.text === kelasTujuanSuggested) {
                                tujuanSelect.value = opt.value;
                                break;
                            }
                        }
                    }
                } else if (badge) {
                    badge.style.display = 'none';
                }
            });
        }

        // Load santri
        const loadBtn = document.getElementById('load_santri_btn');
        if (loadBtn) {
            loadBtn.addEventListener('click', function() {
                const kelasId = document.getElementById('kelas_asal_id').value;
                const kelasTujuanId = document.getElementById('kelas_tujuan_id').value;
                const gender = document.getElementById('gender_filter').value;
                
                if (!kelasId) {
                    alert('Pilih kelas asal terlebih dahulu');
                    return;
                }
                if (!kelasTujuanId) {
                    alert('Pilih kelas tujuan terlebih dahulu');
                    return;
                }

                this.disabled = true;
                this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memuat...';
                if (typeof feather !== 'undefined') feather.replace();

                // Construct URL with query parameters
                // Use the route helper, replacing placeholder
                let url = routeSantriByKelas.replace(':id', kelasId);
                
                if (gender) {
                    url += '?gender=' + gender;
                }

                console.log('Fetching:', url);

                fetch(url)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response not ok: ' + response.statusText);
                        return response.json();
                    })
                    .then(data => {
                        santriData = data;
                        renderSantriTable(data);
                        const container = document.getElementById('santri_container');
                        if (container) container.style.display = 'block';
                        
                        const countEl = document.getElementById('santri_count');
                        if (countEl) countEl.textContent = data.length;
                        
                        updateCounts();
                        if (typeof feather !== 'undefined') feather.replace();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal memuat data santri: ' + error.message);
                    })
                    .finally(() => {
                        this.disabled = false;
                        this.innerHTML = '<i data-feather="users" style="width: 18px; height: 18px;"></i> Tampilkan';
                        if (typeof feather !== 'undefined') feather.replace();
                    });
            });
        }

        function renderSantriTable(data) {
            const tbody = document.getElementById('santri_table_body');
            
            if (data.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" style="padding: 48px; text-align: center; color: #9ca3af;">
                            Tidak ada santri di kelas ini
                        </td>
                    </tr>
                `;
                return;
            }

            let html = '';
            data.forEach((santri, index) => {
                const genderColor = santri.gender === 'putra' 
                    ? 'background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);' 
                    : 'background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);';
                
                // Checked by default implies "Naik"
                html += `
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <td style="padding: 10px 16px; text-align: center; font-size: 12px; color: #6b7280;">${index + 1}</td>
                        <td style="padding: 10px 16px; font-size: 12px; color: #374151;">${santri.nis}</td>
                        <td style="padding: 10px 16px; font-size: 13px; color: #1f2937; font-weight: 600;">${santri.nama_santri}</td>
                        <td style="padding: 10px 16px; text-align: center;">
                            <span style="display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 10px; font-weight: 600; color: white; ${genderColor}">
                                ${santri.gender.charAt(0).toUpperCase() + santri.gender.slice(1)}
                            </span>
                        </td>
                        <td style="padding: 10px 16px; text-align: center;">
                            <input type="checkbox" name="naik_kelas[]" value="${santri.id}" class="naik-checkbox" style="width: 18px; height: 18px; cursor: pointer; accent-color: #16a34a;" checked>
                        </td>
                    </tr>
                `;
            });
            
            tbody.innerHTML = html;
            
            // Add change listener for new checkboxes via delegation or direct attach
            // Using delegation on tbody for efficiency if needed, but direct is fine here since we rebuild
            document.querySelectorAll('.naik-checkbox').forEach(cb => {
                cb.addEventListener('change', updateCounts);
            });

            // Reset "Select All" to checked initially
            const selectAll = document.getElementById('select_all_naik');
            if (selectAll) selectAll.checked = true;
        }

        function updateCounts() {
            const checkboxes = document.querySelectorAll('.naik-checkbox');
            const checkedCount = document.querySelectorAll('.naik-checkbox:checked').length;
            const totalCount = checkboxes.length;
            
            const naikEl = document.getElementById('naik_count');
            const tinggalEl = document.getElementById('tinggal_count');
            
            if (naikEl) naikEl.textContent = checkedCount;
            if (tinggalEl) tinggalEl.textContent = totalCount - checkedCount;
        }

        const selectAllNaik = document.getElementById('select_all_naik');
        if (selectAllNaik) {
            selectAllNaik.addEventListener('change', function() {
                document.querySelectorAll('.naik-checkbox').forEach(cb => cb.checked = this.checked);
                updateCounts();
            });
        }
    }
    
    // Support both standard load and Turbo Drive
    document.addEventListener('DOMContentLoaded', initKenaikanKelas);
    document.addEventListener('turbo:load', initKenaikanKelas);
</script>
<style>
    .spin { animation: spin 1s linear infinite; }
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>
@endpush
