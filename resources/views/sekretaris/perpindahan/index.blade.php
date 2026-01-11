@extends('layouts.app')

@section('title', 'Perpindahan & Rotasi Santri')
@section('page-title', 'Perpindahan & Rotasi Santri')

@section('sidebar-menu')
    <li class="sidebar-menu-item">
        <a href="{{ route('sekretaris.dashboard') }}" class="sidebar-menu-link">
            <i data-feather="home" class="sidebar-menu-icon"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="{{ route('sekretaris.data-santri') }}" class="sidebar-menu-link">
            <i data-feather="users" class="sidebar-menu-icon"></i>
            <span>Data Santri</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="{{ route('sekretaris.mutasi-santri') }}" class="sidebar-menu-link">
            <i data-feather="repeat" class="sidebar-menu-icon"></i>
            <span>Mutasi Santri</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="{{ route('sekretaris.kenaikan-kelas') }}" class="sidebar-menu-link">
            <i data-feather="trending-up" class="sidebar-menu-icon"></i>
            <span>Kenaikan Kelas</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="{{ route('sekretaris.perpindahan') }}" class="sidebar-menu-link active">
            <i data-feather="shuffle" class="sidebar-menu-icon"></i>
            <span>Perpindahan</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="{{ route('sekretaris.laporan') }}" class="sidebar-menu-link">
            <i data-feather="file-text" class="sidebar-menu-icon"></i>
            <span>Laporan</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-menu-link" style="width: 100%; background: none; border: none; cursor: pointer; text-align: left;">
                <i data-feather="log-out" class="sidebar-menu-icon"></i>
                <span>Logout</span>
            </button>
        </form>
    </li>
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
                <i data-feather="shuffle" style="width: 28px; height: 28px; color: white;"></i>
            </div>
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 700; color: white; margin: 0 0 4px 0;">Perpindahan & Rotasi</h2>
                <p style="color: rgba(255,255,255,0.9); font-size: 0.875rem; margin: 0;">Atur perpindahan asrama dan kobong secara massal atau individual</p>
            </div>
        </div>
    </div>

    <!-- Layout Grid -->
    <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 24px;">
        
        <!-- Main Area -->
        <div>
            <!-- Filter Card -->
            <div style="background: white; border-radius: 16px; padding: 20px; margin-bottom: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 16px; align-items: end;">
                    <div>
                        <label style="font-size: 11px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin-bottom: 6px; display: block;">Asrama Saat Ini</label>
                        <select id="filter_asrama" style="width: 100%; height: 42px; border: 2px solid #e5e7eb; border-radius: 8px; padding: 0 12px; font-size: 13px;">
                            <option value="">Semua Asrama</option>
                            @foreach($asramaList as $asrama)
                                <option value="{{ $asrama->id }}">{{ $asrama->nama_asrama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="font-size: 11px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin-bottom: 6px; display: block;">Kelas</label>
                        <select id="filter_kelas" style="width: 100%; height: 42px; border: 2px solid #e5e7eb; border-radius: 8px; padding: 0 12px; font-size: 13px;">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="font-size: 11px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin-bottom: 6px; display: block;">Gender</label>
                        <select id="filter_gender" style="width: 100%; height: 42px; border: 2px solid #e5e7eb; border-radius: 8px; padding: 0 12px; font-size: 13px;">
                            <option value="">Semua</option>
                            <option value="putra">Putra</option>
                            <option value="putri">Putri</option>
                        </select>
                    </div>
                    <button type="button" id="load_santri_btn" style="height: 42px; padding: 0 20px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                        <i data-feather="search" style="width: 16px; height: 16px;"></i>
                        Tampilkan
                    </button>
                </div>
            </div>

            <!-- Santri Table with Per-Row Assignment -->
            <form method="POST" action="{{ route('sekretaris.perpindahan.process') }}" id="perpindahan_form">
                @csrf
                <div style="background: white; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); overflow: hidden;">
                    <div style="padding: 16px 20px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                        <h4 style="font-size: 15px; font-weight: 600; color: #1f2937; margin: 0; display: flex; align-items: center; gap: 12px;">
                            Daftar Santri (<span id="santri_count">0</span>)
                            <span id="checked_counter" style="display: none; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">0 dipilih</span>
                        </h4>
                        <div style="display: flex; gap: 8px;">
                            <button type="button" id="apply_bulk_btn" style="padding: 8px 14px; background: #f3f4f6; border: 1px solid #d1d5db; border-radius: 6px; font-size: 12px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                                <i data-feather="copy" style="width: 14px; height: 14px;"></i>
                                Terapkan ke Terpilih
                            </button>
                        </div>
                    </div>

                    <!-- Bulk Action Row (Hidden) -->
                    <div id="bulk_apply_row" style="display: none; background: #eff6ff; padding: 12px 20px; border-bottom: 1px solid #dbeafe;">
                        <div style="display: flex; gap: 12px; align-items: center;">
                            <span style="font-size: 12px; font-weight: 600; color: #1e40af;">Terapkan Massal:</span>
                            <select id="bulk_asrama" style="height: 36px; border: 1px solid #93c5fd; border-radius: 6px; padding: 0 10px; font-size: 12px; background: white;">
                                <option value="">Pilih Asrama</option>
                                @foreach($asramaList as $asrama)
                                    <option value="{{ $asrama->id }}">{{ $asrama->nama_asrama }}</option>
                                @endforeach
                            </select>
                            <select id="bulk_kobong" style="height: 36px; border: 1px solid #fcd34d; border-radius: 6px; padding: 0 10px; font-size: 12px; background: white;">
                                <option value="">Pilih Kobong</option>
                            </select>
                            <button type="button" id="apply_bulk_confirm" style="padding: 8px 14px; background: #f59e0b; color: white; border: none; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer;">
                                Terapkan
                            </button>
                            <button type="button" id="cancel_bulk" style="padding: 8px 14px; background: white; color: #6b7280; border: 1px solid #d1d5db; border-radius: 6px; font-size: 12px; cursor: pointer;">
                                Batal
                            </button>
                        </div>
                    </div>

                    <div style="max-height: 500px; overflow-y: auto; scrollbar-width: none; -ms-overflow-style: none;" id="santri_scroll_container">
                        <style>#santri_scroll_container::-webkit-scrollbar { display: none; }</style>
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead style="position: sticky; top: 0; z-index: 10;">
                                <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <th style="padding: 12px 16px; text-align: center; font-size: 11px; font-weight: 600; color: white; width: 40px;"><input type="checkbox" id="select_all" style="width: 16px; height: 16px;"></th>
                                    <th style="padding: 12px 8px; text-align: center; font-size: 11px; font-weight: 600; color: white; text-transform: uppercase; width: 40px;">No</th>
                                    <th style="padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: white; text-transform: uppercase;">Santri</th>
                                    <th style="padding: 12px 16px; text-align: center; font-size: 11px; font-weight: 600; color: white; text-transform: uppercase;">Kelas</th>
                                    <th style="padding: 12px 16px; text-align: center; font-size: 11px; font-weight: 600; color: white; text-transform: uppercase;">Lokasi Saat Ini</th>
                                    <th style="padding: 12px 16px; text-align: center; font-size: 11px; font-weight: 600; color: white; text-transform: uppercase; width: 180px;">Asrama Tujuan</th>
                                    <th style="padding: 12px 16px; text-align: center; font-size: 11px; font-weight: 600; color: white; text-transform: uppercase; width: 140px;">Kobong Tujuan</th>
                                </tr>
                            </thead>
                            <tbody id="santri_table_body">
                                <tr>
                                    <td colspan="7" style="padding: 60px; text-align: center; color: #9ca3af;">
                                        <i data-feather="users" style="width: 40px; height: 40px; margin-bottom: 12px; opacity: 0.4;"></i>
                                        <p style="margin: 0; font-size: 13px;">Gunakan filter di atas untuk menampilkan santri</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Submit Button -->
                    <div id="submit_section" style="display: none; padding: 20px; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-top: 1px solid #86efac;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="font-size: 14px; color: #166534;">
                                <strong id="changed_count">0</strong> santri akan dipindahkan
                            </div>
                            <button type="submit" style="display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 14px 32px; border-radius: 10px; font-weight: 600; font-size: 15px; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(67, 233, 123, 0.35);">
                                <i data-feather="check-circle" style="width: 20px; height: 20px;"></i>
                                Proses Perpindahan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Statistics Sidebar -->
        <div>
            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); overflow: hidden; position: sticky; top: 20px;">
                <div style="padding: 16px 20px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <h4 style="font-size: 14px; font-weight: 600; color: white; margin: 0; display: flex; align-items: center; gap: 8px;">
                        <i data-feather="bar-chart-2" style="width: 16px; height: 16px;"></i>
                        Statistik Kobong
                    </h4>
                    <p style="font-size: 11px; color: rgba(255,255,255,0.9); margin: 4px 0 0 0;">Untuk bantu pemerataan per kelas</p>
                </div>
                
                <div style="padding: 16px;">
                    <div style="margin-bottom: 12px;">
                        <label style="font-size: 11px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin-bottom: 6px; display: block;">Pilih Asrama</label>
                        <select id="stats_asrama" style="width: 100%; height: 38px; border: 2px solid #e5e7eb; border-radius: 8px; padding: 0 10px; font-size: 13px;">
                            <option value="">Pilih Asrama</option>
                            @foreach($asramaList as $asrama)
                                <option value="{{ $asrama->id }}">{{ $asrama->nama_asrama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="stats_container" style="max-height: 400px; overflow-y: auto;">
                        <div style="text-align: center; padding: 40px 20px; color: #9ca3af;">
                            <i data-feather="pie-chart" style="width: 32px; height: 32px; margin-bottom: 8px; opacity: 0.4;"></i>
                            <p style="font-size: 12px; margin: 0;">Pilih asrama untuk melihat statistik</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function initPerpindahan() {
        // Data passed from controller
        const asramaList = @json($asramaList);
        const kobongData = {}; 
        let santriData = [];

        // API Routes
        const routeSantriFiltered = "{{ route('sekretaris.api.santri-filtered') }}";
        const routeKobongByAsrama = "{{ route('sekretaris.api.kobong-by-asrama', ':id') }}";
        const routeKobongStats = "{{ route('sekretaris.api.kobong-stats', ':id') }}";

        // Load santri based on filter
        const loadBtn = document.getElementById('load_santri_btn');
        if (loadBtn) {
            loadBtn.addEventListener('click', loadSantri);
        } else {
            console.error('Button load_santri_btn not found');
        }

        function loadSantri() {
            const asrama = document.getElementById('filter_asrama').value;
            const kelas = document.getElementById('filter_kelas').value;
            const gender = document.getElementById('filter_gender').value;

            const params = new URLSearchParams();
            if (asrama) params.append('asrama_id', asrama);
            if (kelas) params.append('kelas_id', kelas);
            if (gender) params.append('gender', gender);

            // Show loading state
            loadBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
            loadBtn.disabled = true;

            const url = routeSantriFiltered + '?' + params.toString();
            console.log('Fetching:', url);

            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    santriData = data;
                    renderSantriTable(data);
                    document.getElementById('santri_count').textContent = data.length;
                    const submitSection = document.getElementById('submit_section');
                    if (submitSection) submitSection.style.display = data.length > 0 ? 'block' : 'none';
                    if (typeof feather !== 'undefined') feather.replace();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal mengambil data santri: ' + error.message);
                })
                .finally(() => {
                    loadBtn.innerHTML = '<i data-feather="search" style="width: 16px; height: 16px;"></i> Tampilkan';
                    loadBtn.disabled = false;
                    if (typeof feather !== 'undefined') feather.replace();
                });
        }

        function renderSantriTable(data) {
            const tbody = document.getElementById('santri_table_body');
            
            if (data.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" style="padding: 60px; text-align: center; color: #9ca3af;">
                            <p style="margin: 0; font-size: 13px;">Tidak ada santri ditemukan</p>
                        </td>
                    </tr>
                `;
                return;
            }

            let html = '';
            data.forEach((santri, index) => {
                const asramaOptions = asramaList.map(a => 
                    `<option value="${a.id}" ${santri.asrama_id == a.id ? 'selected' : ''}>${a.nama_asrama}</option>`
                ).join('');

                const currentKelas = santri.kelas ? santri.kelas.nama_kelas : '-';
                const currentAsrama = santri.asrama ? santri.asrama.nama_asrama : '-';
                const currentKobong = santri.kobong ? santri.kobong.nomor_kobong : '-';
                const kobongId = santri.kobong_id || '';

                html += `
                    <tr style="border-bottom: 1px solid #f3f4f6;" data-santri-id="${santri.id}" data-original-asrama="${santri.asrama_id}" data-original-kobong="${kobongId}">
                        <td style="padding: 10px 16px; text-align: center;"><input type="checkbox" class="santri-checkbox" value="${santri.id}" style="width: 16px; height: 16px;"></td>
                        <td style="padding: 10px 8px; text-align: center; font-size: 12px; font-weight: 600; color: #6b7280;">${index + 1}</td>
                        <td style="padding: 10px 16px;">
                            <div style="font-size: 13px; font-weight: 600; color: #1f2937;">${santri.nama_santri}</div>
                            <div style="font-size: 11px; color: #6b7280;">${santri.nis}</div>
                        </td>
                        <td style="padding: 10px 16px; text-align: center;">
                            <span style="font-size: 11px; padding: 4px 10px; background: #f3f4f6; border-radius: 12px; color: #374151;">
                                ${currentKelas}
                            </span>
                        </td>
                        <td style="padding: 10px 16px; text-align: center;">
                            <div style="font-size: 12px; color: #374151;">${currentAsrama}</div>
                            <div style="font-size: 11px; color: #6b7280;">Kobong ${currentKobong}</div>
                        </td>
                        <td style="padding: 10px 16px;">
                            <select name="assignments[${santri.id}][asrama_id]" class="asrama-select" data-santri-id="${santri.id}" style="width: 100%; height: 36px; border: 1px solid #e5e7eb; border-radius: 6px; padding: 0 8px; font-size: 12px;">
                                ${asramaOptions}
                            </select>
                        </td>
                        <td style="padding: 10px 16px;">
                            <select name="assignments[${santri.id}][kobong_id]" class="kobong-select" data-santri-id="${santri.id}" style="width: 100%; height: 36px; border: 1px solid #e5e7eb; border-radius: 6px; padding: 0 8px; font-size: 12px;">
                                <option value="${kobongId}">${kobongId ? 'Kobong ' + currentKobong : '-'}</option>
                            </select>
                        </td>
                    </tr>
                `;
            });
            
            tbody.innerHTML = html;

            // Add event listeners to asrama selects
            document.querySelectorAll('.asrama-select').forEach(select => {
                select.addEventListener('change', function() {
                    loadKobongForRow(this.dataset.santriId, this.value);
                    updateChangedCount();
                });
            });

            document.querySelectorAll('.kobong-select').forEach(select => {
                select.addEventListener('change', updateChangedCount);
            });

            // Re-attach checkbox event listener logic if needed
            // (Delegated listener on document handles clicks, but we need to update "select all" state if needed)
            updateChangedCount();
        }

        function loadKobongForRow(santriId, asramaId) {
            const kobongSelect = document.querySelector(`.kobong-select[data-santri-id="${santriId}"]`);
            
            if (kobongData[asramaId]) {
                populateKobongSelect(kobongSelect, kobongData[asramaId]);
            } else {
                fetch(routeKobongByAsrama.replace(':id', asramaId))
                    .then(response => response.json())
                    .then(data => {
                        kobongData[asramaId] = data;
                        populateKobongSelect(kobongSelect, data);
                    });
            }
        }

        function populateKobongSelect(select, kobongs) {
            select.innerHTML = '<option value="">Pilih Kobong</option>' + 
                kobongs.map(k => `<option value="${k.id}">Kobong ${k.nomor_kobong}</option>`).join('');
        }

        function updateChangedCount() {
            let count = 0;
            document.querySelectorAll('#santri_table_body tr[data-santri-id]').forEach(row => {
                const originalAsrama = row.dataset.originalAsrama;
                const originalKobong = row.dataset.originalKobong;
                const asramaSelect = row.querySelector('.asrama-select');
                const kobongSelect = row.querySelector('.kobong-select');
                
                // Safety check if elements exist
                if (!asramaSelect || !kobongSelect) return;

                const newAsrama = asramaSelect.value;
                const newKobong = kobongSelect.value;

                // Simple loose comparison
                if (newAsrama != originalAsrama || (newKobong && newKobong != originalKobong)) {
                    row.style.background = '#fef3c7';
                    count++;
                } else {
                    row.style.background = 'white';
                }
            });
            const countEl = document.getElementById('changed_count');
            if (countEl) countEl.textContent = count;
        }

        // Select all checkbox
        const selectAll = document.getElementById('select_all');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                document.querySelectorAll('.santri-checkbox').forEach(cb => cb.checked = this.checked);
                updateCheckedCounter();
            });
        }

        // Update checked counter (Event Delegation)
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('santri-checkbox')) {
                updateCheckedCounter();
            }
        });

        function updateCheckedCounter() {
            const checked = document.querySelectorAll('.santri-checkbox:checked').length;
            const counter = document.getElementById('checked_counter');
            if (counter) {
                if (checked > 0) {
                    counter.textContent = checked + ' dipilih';
                    counter.style.display = 'inline-block';
                } else {
                    counter.style.display = 'none';
                }
            }
        }

        // Bulk apply button
        const applyBulkBtn = document.getElementById('apply_bulk_btn');
        if (applyBulkBtn) {
            applyBulkBtn.addEventListener('click', function() {
                const checked = document.querySelectorAll('.santri-checkbox:checked').length;
                if (checked === 0) {
                    alert('Pilih santri terlebih dahulu');
                    return;
                }
                const bulkRow = document.getElementById('bulk_apply_row');
                if (bulkRow) bulkRow.style.display = 'block';
            });
        }

        const cancelBulk = document.getElementById('cancel_bulk');
        if (cancelBulk) {
            cancelBulk.addEventListener('click', function() {
                document.getElementById('bulk_apply_row').style.display = 'none';
            });
        }

        // Bulk asrama change
        const bulkAsrama = document.getElementById('bulk_asrama');
        if (bulkAsrama) {
            bulkAsrama.addEventListener('change', function() {
                const asramaId = this.value;
                const kobongSelect = document.getElementById('bulk_kobong');
                
                if (!asramaId) {
                    kobongSelect.innerHTML = '<option value="">Pilih Kobong</option>';
                    return;
                }

                if (kobongData[asramaId]) {
                    populateKobongSelect(kobongSelect, kobongData[asramaId]);
                } else {
                    fetch(routeKobongByAsrama.replace(':id', asramaId))
                        .then(response => response.json())
                        .then(data => {
                            kobongData[asramaId] = data;
                            populateKobongSelect(kobongSelect, data);
                        });
                }
            });
        }

        // Apply bulk confirm
        const applyBulkConfirm = document.getElementById('apply_bulk_confirm');
        if (applyBulkConfirm) {
            applyBulkConfirm.addEventListener('click', function() {
                const asramaId = document.getElementById('bulk_asrama').value;
                const kobongId = document.getElementById('bulk_kobong').value;

                if (!asramaId || !kobongId) {
                    alert('Pilih asrama dan kobong tujuan');
                    return;
                }

                document.querySelectorAll('.santri-checkbox:checked').forEach(cb => {
                    const santriId = cb.value;
                    const asramaSelect = document.querySelector(`.asrama-select[data-santri-id="${santriId}"]`);
                    const kobongSelect = document.querySelector(`.kobong-select[data-santri-id="${santriId}"]`);

                    if (asramaSelect && kobongSelect) {
                        asramaSelect.value = asramaId;
                        populateKobongSelect(kobongSelect, kobongData[asramaId] || []);
                        // Wait for population? synchronous here if data exists
                        setTimeout(() => {
                             kobongSelect.value = kobongId;
                             updateChangedCount(); // Update after value set
                        }, 50);
                    }
                });

                document.getElementById('bulk_apply_row').style.display = 'none';
                // Trigger change event implies
                updateChangedCount();
            });
        }

        // Statistics
        const statsAsrama = document.getElementById('stats_asrama');
        if (statsAsrama) {
            statsAsrama.addEventListener('change', function() {
                const asramaId = this.value;
                if (!asramaId) {
                    document.getElementById('stats_container').innerHTML = `
                        <div style="text-align: center; padding: 40px 20px; color: #9ca3af;">
                            <p style="font-size: 12px; margin: 0;">Pilih asrama untuk melihat statistik</p>
                        </div>
                    `;
                    return;
                }

                fetch(routeKobongStats.replace(':id', asramaId))
                    .then(response => response.json())
                    .then(data => renderStats(data))
                    .catch(e => console.error("Stat error", e));
            });
        }

        function renderStats(data) {
            const container = document.getElementById('stats_container');
            
            if (data.length === 0) {
                container.innerHTML = '<p style="text-align: center; color: #9ca3af; font-size: 12px;">Tidak ada data</p>';
                return;
            }

            let html = '';
            data.forEach(kobong => {
                const total = Object.values(kobong.kelas_counts).reduce((a, b) => a + b, 0);
                
                html += `
                    <div style="background: #f9fafb; border-radius: 10px; padding: 12px; margin-bottom: 10px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <span style="font-weight: 600; font-size: 13px; color: #1f2937;">Kobong ${kobong.nomor_kobong}</span>
                            <span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2px 10px; border-radius: 12px; font-size: 11px; font-weight: 600;">${total} santri</span>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                `;
                
                for (const [kelas, count] of Object.entries(kobong.kelas_counts)) {
                    if (count > 0) {
                        html += `<span style="font-size: 10px; padding: 3px 8px; background: #e0e7ff; color: #4338ca; border-radius: 8px;">${kelas}: ${count}</span>`;
                    }
                }
                
                html += `
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
        }
    }
    
    // Support both standard load and Turbo Drive
    document.addEventListener('DOMContentLoaded', initPerpindahan);
    document.addEventListener('turbo:load', initPerpindahan);
</script>
@endpush
