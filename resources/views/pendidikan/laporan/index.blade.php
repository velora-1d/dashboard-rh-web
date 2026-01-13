@extends('layouts.app')

@section('title', 'Laporan Akademik')
@section('page-title', 'Laporan Akademik')

@section('sidebar-menu')
    @include('pendidikan.partials.sidebar-menu')
@endsection

@section('content')
    <!-- Page Header -->
    <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 12px; padding: 24px 28px; margin-bottom: 24px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i data-feather="file-text" style="width: 24px; height: 24px; color: white;"></i>
            </div>
            <div>
                <h2 style="font-size: 24px; font-weight: 700; color: white; margin: 0;">Laporan Akademik</h2>
                <p style="font-size: 14px; color: rgba(255,255,255,0.9); margin: 4px 0 0 0;">Kelola dan export berbagai laporan akademik santri</p>
            </div>
        </div>
    </div>

    <!-- Export Rapor Santri -->
    <div style="background: white; border-radius: 10px; padding: 0; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid rgba(16,185,129,0.1); overflow: hidden;">
        <div style="padding: 16px 20px; background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border-bottom: 2px solid #10b981;">
            <h3 style="font-size: 16px; font-weight: 600; margin: 0; color: #065f46; display: flex; align-items: center; gap: 8px;">
                <i data-feather="user-check" style="width: 18px; height: 18px;"></i>
                Export Rapor Santri
            </h3>
        </div>
        <div style="padding: 20px;">
            <form method="GET" action="{{ route('pendidikan.laporan.export-rapor') }}">
                
                <!-- Filter Helper -->
                <div style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); padding: 16px; border-radius: 8px; margin-bottom: 20px; border: 1.5px solid #bbf7d0;">
                    <p style="margin-bottom: 12px; font-size: 13px; font-weight: 600; color: #166534; display: flex; align-items: center; gap: 6px;">
                        <i data-feather="filter" style="width: 14px; height: 14px;"></i>
                        Filter Pencarian Santri
                    </p>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="form-group">
                            <label class="form-label" style="font-size: 12px; font-weight: 600; color: #374151;">Filter Kelas</label>
                            <select id="filterKelasHelper" class="form-select" style="font-size: 13px; border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px;">
                                <option value="all">Semua Kelas</option>
                                @foreach($kelasList as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-size: 12px; font-weight: 600; color: #374151;">Filter Gender</label>
                            <select id="filterGenderHelper" class="form-select" style="font-size: 13px; border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px;">
                                <option value="all">Semua Gender</option>
                                <option value="putra">Putra</option>
                                <option value="putri">Putri</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3" style="gap: 16px; margin-bottom: 20px;">
                    <div class="form-group">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">Pilih Santri</label>
                        <select name="santri_id" id="santriSelect" class="form-select" required style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px;">
                            <option value="">-- Cari Santri --</option>
                            @foreach($santriList as $s)
                                <option value="{{ $s->id }}" data-kelas="{{ $s->kelas_id }}" data-gender="{{ $s->gender }}" data-search="{{ strtolower($s->nama_santri) }}">
                                    {{ $s->nis }} - {{ $s->nama_santri }}
                                </option>
                            @endforeach
                        </select>
                        <small id="santriCountInfo" style="display: block; margin-top: 6px; color: #64748b; font-size: 12px;"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">
                            Tahun Ajaran
                            @if(auth()->user()->role !== 'rois')
                            <button type="button" onclick="openTahunAjaranModal()" style="border: none; background: none; color: #3b82f6; cursor: pointer; font-size: 11px; margin-left: 4px; text-decoration: underline;">
                                (Kelola)
                            </button>
                            @endif
                        </label>
                        <select name="tahun_ajaran" class="form-select" required style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px;">
                            <option value="all">Semua</option>
                            @foreach($tahunAjaranList as $ta)
                                <option value="{{ $ta }}" {{ $ta == '2024/2025' ? 'selected' : '' }}>{{ $ta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">Semester</label>
                        <select name="semester" class="form-select" required style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px;">
                            <option value="1">Semester 1</option>
                            <option value="2">Semester 2</option>
                        </select>
                    </div>
                </div>
                <button type="submit" style="padding: 10px 20px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px;"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(16,185,129,0.3)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    <i data-feather="printer" style="width: 16px; height: 16px;"></i>
                    Export Rapor
                </button>

                <button type="submit" name="download" value="1" style="margin-left: 8px; padding: 10px 20px; background: white; color: #10b981; border: 1.5px solid #10b981; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px;"
                    onmouseover="this.style.background='#f0fdf4'; this.style.transform='translateY(-2px)';"
                    onmouseout="this.style.background='white'; this.style.transform='translateY(0)';"
                    title="Simpan sebagai file PDF">
                    <i data-feather="download" style="width: 16px; height: 16px;"></i>
                    Unduh PDF
                </button>
            </form>

            <script>
                // Initialize filter function
                function initSantriFilter() {
                    const filterKelas = document.getElementById('filterKelasHelper');
                    const filterGender = document.getElementById('filterGenderHelper');
                    const santriSelect = document.getElementById('santriSelect');
                    const infoText = document.getElementById('santriCountInfo');
                    
                    if (!filterKelas || !santriSelect) return;

                    // Use server-side data as source of truth
                    const santriData = @json($santriDataForFilter);

                    function applyFilter() {
                        const selectedKelas = filterKelas.value;
                        const selectedGender = filterGender.value;
                        
                        // Clear existing options
                        santriSelect.innerHTML = '<option value="">-- Cari Santri --</option>';
                        
                        // Filter data
                        const filtered = santriData.filter(s => {
                            const matchKelas = selectedKelas === 'all' || s.kelas == selectedKelas;
                            const matchGender = selectedGender === 'all' || s.gender == selectedGender;
                            return matchKelas && matchGender;
                        });
                        
                        // Rebuild options
                        filtered.forEach(s => {
                            const newOption = new Option(s.text, s.value);
                            newOption.setAttribute('data-kelas', s.kelas);
                            newOption.setAttribute('data-gender', s.gender);
                            santriSelect.add(newOption);
                        });
                        
                        if (infoText) {
                            infoText.textContent = `Menampilkan ${filtered.length} santri dari total ${santriData.length}.`;
                        }
                    }

                    // Attach events
                    filterKelas.addEventListener('change', applyFilter);
                    filterGender.addEventListener('change', applyFilter);
                    
                    // Initial state
                    if (infoText) {
                        infoText.textContent = `Menampilkan ${santriData.length} santri.`;
                    }
                }
                
                // Support both standard load and Turbo Drive
                document.addEventListener('DOMContentLoaded', initSantriFilter);
                document.addEventListener('turbo:load', initSantriFilter);
            </script>
        </div>
    </div>

    <!-- Cetak Rapor Massal Per Kelas -->
    <div style="background: white; border-radius: 10px; padding: 0; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid rgba(147,51,234,0.1); overflow: hidden;">
        <div style="padding: 16px 20px; background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%); border-bottom: 2px solid #9333ea;">
            <h3 style="font-size: 16px; font-weight: 600; margin: 0; color: #6b21a8; display: flex; align-items: center; gap: 8px;">
                <i data-feather="printer" style="width: 18px; height: 18px;"></i>
                Cetak Rapor Massal Per Kelas
                <span style="background: linear-gradient(135deg, #9333ea 0%, #7c3aed 100%); color: white; padding: 2px 10px; border-radius: 12px; font-size: 11px; font-weight: 600;">BARU</span>
            </h3>
        </div>
        <div style="padding: 20px;">
            <div style="background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%); padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; border: 1px solid #e9d5ff;">
                <p style="margin: 0; font-size: 13px; color: #6b21a8; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="info" style="width: 16px; height: 16px;"></i>
                    Cetak rapor seluruh santri dalam satu kelas sekaligus. Ideal untuk persiapan pembagian rapor.
                </p>
            </div>
            <form method="GET" action="{{ route('pendidikan.laporan.export-rapor-kelas') }}">
                <div class="grid grid-cols-2" style="gap: 16px; margin-bottom: 16px;">
                    <div class="form-group">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">Pilih Kelas</label>
                        <select name="kelas_id" class="form-select" required style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px; font-size: 13px;">
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">Filter Gender</label>
                        <select name="gender" class="form-select" style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px; font-size: 13px;">
                            <option value="all">Semua Gender</option>
                            <option value="putra">Putra</option>
                            <option value="putri">Putri</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2" style="gap: 16px; margin-bottom: 16px;">
                    <div class="form-group">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">Tahun Ajaran</label>
                        <select name="tahun_ajaran" class="form-select" required style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px; font-size: 13px;">
                            @foreach($tahunAjaranList as $ta)
                                <option value="{{ $ta }}" {{ $ta == '2024/2025' ? 'selected' : '' }}>{{ $ta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">Semester</label>
                        <select name="semester" class="form-select" required style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px; font-size: 13px;">
                            <option value="1">Semester 1</option>
                            <option value="2">Semester 2</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; gap: 12px;">
                    <button type="submit" style="flex: 1; padding: 12px; background: linear-gradient(135deg, #9333ea 0%, #7c3aed 100%); color: white; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 12px rgba(147,51,234,0.25);"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(147,51,234,0.35)';"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(147,51,234,0.25)';">
                        <i data-feather="printer" style="width: 18px; height: 18px;"></i>
                        Cetak Semua
                    </button>
                    
                    <button type="submit" name="download" value="1" style="flex: 1; padding: 12px; background: white; color: #9333ea; border: 2px solid #9333ea; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center; gap: 8px;"
                        onmouseover="this.style.background='#f5f3ff'; this.style.transform='translateY(-2px)';"
                        onmouseout="this.style.background='white'; this.style.transform='translateY(0)';"
                        title="Simpan seluruh rapor kelas sebagai satu file PDF">
                        <i data-feather="download-cloud" style="width: 18px; height: 18px;"></i>
                        Unduh Semua (PDF)
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer Credit -->
    <div style="margin-top: 40px; text-align: center; color: #94a3b8; font-size: 13px; padding-bottom: 20px;">
        <p>Dibuat oleh Mahin Utsman Nawawi, S.H</p>
    </div>

    <!-- Modal Kelola Tahun Ajaran -->
    <div id="tahunAjaranModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 50; align-items: center; justify-content: center;">
        <div style="background: white; border-radius: 12px; width: 400px; max-width: 90%; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <div style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
                <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;">Kelola Tahun Ajaran</h3>
                <button onclick="closeTahunAjaranModal()" style="border: none; background: none; cursor: pointer; color: #64748b;">
                    <i data-feather="x" style="width: 20px; height: 20px;"></i>
                </button>
            </div>
            <div style="padding: 20px;">
                @if(auth()->user()->role !== 'rois')
                <!-- Add Form -->
                <form action="{{ route('pendidikan.tahun-ajaran.store') }}" method="POST" style="margin-bottom: 20px; display: flex; gap: 10px;">
                    @csrf
                    <input type="text" name="nama" placeholder="Contoh: 2025/2026" required 
                           style="flex: 1; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px;">
                    <button type="submit" style="background: #3b82f6; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-size: 14px; font-weight: 500; cursor: pointer;">
                        Tambah
                    </button>
                </form>
                @endif

                <!-- List -->
                <div style="max-height: 300px; overflow-y: auto; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                        <thead style="background: #f1f5f9;">
                            <tr>
                                <th style="padding: 8px 12px; text-align: left; font-weight: 600; color: #475569; width: 40px;">No</th>
                                <th style="padding: 8px 12px; text-align: left; font-weight: 600; color: #475569;">Tahun Ajaran</th>
                                <th style="padding: 8px 12px; text-align: right; font-weight: 600; color: #475569;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($tahunAjaranObjects))
                                @foreach($tahunAjaranObjects as $index => $ta)
                                <tr>
                                    <td style="padding: 8px 12px; border-bottom: 1px solid #f1f5f9; color: #64748b;">{{ $index + 1 }}</td>
                                    <td style="padding: 8px 12px; border-bottom: 1px solid #f1f5f9; color: #1e293b; font-weight: 500;">{{ $ta->nama }}</td>
                                    <td style="padding: 8px 12px; border-bottom: 1px solid #f1f5f9; text-align: right;">
                                        @if(auth()->user()->role !== 'rois')
                                        <form action="{{ route('pendidikan.tahun-ajaran.destroy', $ta->id) }}" method="POST" onsubmit="return confirm('Hapus tahun ajaran {{ $ta->nama }}?');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="border: none; background: none; cursor: pointer; color: #ef4444; padding: 4px;" title="Hapus">
                                                <i data-feather="trash-2" style="width: 16px; height: 16px;"></i>
                                            </button>
                                        </form>
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openTahunAjaranModal() {
            document.getElementById('tahunAjaranModal').style.display = 'flex';
        }
        function closeTahunAjaranModal() {
            document.getElementById('tahunAjaranModal').style.display = 'none';
        }
        
        // Close on click outside
        document.getElementById('tahunAjaranModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeTahunAjaranModal();
            }
        });
    </script>

    <!-- Grid Menu Laporan -->
    <div class="grid grid-cols-2" style="gap: 20px; margin-bottom: 20px;">
        <!-- Daftar Nilai -->
        <div style="background: white; border-radius: 10px; padding: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid rgba(59,130,246,0.1); overflow: hidden;">
            <div style="padding: 16px 20px; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-bottom: 2px solid #3b82f6;">
                <h3 style="font-size: 16px; font-weight: 600; margin: 0; color: #1e40af; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="list" style="width: 18px; height: 18px;"></i>
                    Daftar Nilai per Kelas
                </h3>
            </div>
            <div style="padding: 20px;">
                <form method="GET" action="{{ route('pendidikan.laporan.export-daftar-nilai') }}" target="_blank">
                    <div class="grid grid-cols-2 gap-4" style="margin-bottom: 12px;">
                        <div class="form-group">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">Kelas</label>
                            <select name="kelas_id" class="form-select" required style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px; font-size: 13px;">
                                @foreach($kelasList as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">Gender</label>
                            <select name="gender" class="form-select" required style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px; font-size: 13px;">
                                <option value="putra">Putra</option>
                                <option value="putri">Putri</option>
                                <option value="all">Semua</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4" style="margin-bottom: 16px;">
                        <div class="form-group">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">Tahun Ajaran</label>
                            <select name="tahun_ajaran" class="form-select" required style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px; font-size: 13px;">
                                <option value="all">Semua</option>
                                @foreach($tahunAjaranList as $ta)
                                    <option value="{{ $ta }}" {{ $ta == '2024/2025' ? 'selected' : '' }}>{{ $ta }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">Semester</label>
                            <select name="semester" class="form-select" required style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px; font-size: 13px;">
                                <option value="1">Semester 1</option>
                                <option value="2">Semester 2</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" style="width: 100%; padding: 10px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center; gap: 8px;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(59,130,246,0.3)';"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                        <i data-feather="download" style="width: 16px; height: 16px;"></i>
                        Export Daftar Nilai
                    </button>
                </form>
            </div>
        </div>

        <!-- Statistik Prestasi -->
        <div style="background: white; border-radius: 10px; padding: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid rgba(245,158,11,0.1); overflow: hidden;">
            <div style="padding: 16px 20px; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-bottom: 2px solid #f59e0b;">
                <h3 style="font-size: 16px; font-weight: 600; margin: 0; color: #92400e; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="trending-up" style="width: 18px; height: 18px;"></i>
                    Statistik Prestasi (Top 20)
                </h3>
            </div>
            <div style="padding: 20px;">
                <form method="GET" action="{{ route('pendidikan.laporan.export-statistik') }}" target="_blank">
                    <div class="grid grid-cols-2 gap-4" style="margin-bottom: 12px;">
                        <div class="form-group">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">Tingkat/Kelas</label>
                            <select name="kelas_id" class="form-select" style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px; font-size: 13px;">
                                <option value="">Semua Kelas</option>
                                @foreach($kelasList as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">Gender</label>
                            <select name="gender" class="form-select" required style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px; font-size: 13px;">
                                <option value="putra">Putra</option>
                                <option value="putri">Putri</option>
                                <option value="all">Semua</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4" style="margin-bottom: 16px;">
                        <div class="form-group">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">Tahun Ajaran</label>
                            <select name="tahun_ajaran" class="form-select" required style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px; font-size: 13px;">
                                <option value="all">Semua</option>
                                @foreach($tahunAjaranList as $ta)
                                    <option value="{{ $ta }}" {{ $ta == '2024/2025' ? 'selected' : '' }}>{{ $ta }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">Semester</label>
                            <select name="semester" class="form-select" required style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px; font-size: 13px;">
                                <option value="1">Semester 1</option>
                                <option value="2">Semester 2</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" style="width: 100%; padding: 10px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center; gap: 8px;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(245,158,11,0.3)';"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                        <i data-feather="bar-chart-2" style="width: 16px; height: 16px;"></i>
                        Export Statistik
                    </button>
                </form>
            </div>
        </div>

        <!-- Rekapitulasi Kehadiran -->
        <div style="background: white; border-radius: 10px; padding: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid rgba(139,92,246,0.1); overflow: hidden;">
            <div style="padding: 16px 20px; background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%); border-bottom: 2px solid #8b5cf6;">
                <h3 style="font-size: 16px; font-weight: 600; margin: 0; color: #5b21b6; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="check-circle" style="width: 18px; height: 18px;"></i>
                    Rekapitulasi Kehadiran
                </h3>
            </div>
            <div style="padding: 20px;">
                <form method="GET" action="{{ route('pendidikan.laporan.export-absensi') }}" target="_blank">
                    <div class="grid grid-cols-2 gap-4" style="margin-bottom: 12px;">
                        <div class="form-group">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">Kelas</label>
                            <select name="kelas_id" class="form-select" required style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px; font-size: 13px;">
                                @foreach($kelasList as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">Gender</label>
                            <select name="gender" class="form-select" required style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px; font-size: 13px;">
                                <option value="putra">Putra</option>
                                <option value="putri">Putri</option>
                                <option value="all">Semua</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4" style="margin-bottom: 16px;">
                        <div class="form-group">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">Tahun (Masehi)</label>
                            <select name="tahun" class="form-select" required style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px; font-size: 13px;">
                                @foreach(range(date('Y'), date('Y')-5) as $y)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">Semester</label>
                            <select name="semester" class="form-select" required style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px; font-size: 13px;">
                                <option value="1">Semester 1</option>
                                <option value="2">Semester 2</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" style="width: 100%; padding: 10px; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center; gap: 8px;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(139,92,246,0.3)';"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                        <i data-feather="calendar" style="width: 16px; height: 16px;"></i>
                        Export Rekap Absensi
                    </button>
                </form>
            </div>
        </div>

        <!-- Ranking Kelas -->
        <div style="background: white; border-radius: 10px; padding: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid rgba(239,68,68,0.1); overflow: hidden;">
            <div style="padding: 16px 20px; background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); border-bottom: 2px solid #ef4444;">
                <h3 style="font-size: 16px; font-weight: 600; margin: 0; color: #991b1b; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="award" style="width: 18px; height: 18px;"></i>
                    Ranking Kelas
                </h3>
            </div>
            <div style="padding: 20px;">
                <form method="GET" action="{{ route('pendidikan.laporan.export-ranking') }}" target="_blank">
                    <div class="grid grid-cols-2 gap-4" style="margin-bottom: 12px;">
                        <div class="form-group">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">Kelas</label>
                            <select name="kelas_id" class="form-select" required style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px; font-size: 13px;">
                                @foreach($kelasList as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">Gender</label>
                            <select name="gender" class="form-select" required style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px; font-size: 13px;">
                                <option value="putra">Putra</option>
                                <option value="putri">Putri</option>
                                <option value="all">Semua</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4" style="margin-bottom: 16px;">
                        <div class="form-group">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">Tahun Ajaran</label>
                            <select name="tahun_ajaran" class="form-select" required style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px; font-size: 13px;">
                                <option value="all">Semua</option>
                                @foreach($tahunAjaranList as $ta)
                                    <option value="{{ $ta }}" {{ $ta == '2024/2025' ? 'selected' : '' }}>{{ $ta }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #374151;">Semester</label>
                            <select name="semester" class="form-select" required style="border: 1.5px solid #d1d5db; border-radius: 6px; padding: 8px; font-size: 13px;">
                                <option value="1">Semester 1</option>
                                <option value="2">Semester 2</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" style="width: 100%; padding: 10px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center; gap: 8px;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(239,68,68,0.3)';"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                        <i data-feather="award" style="width: 16px; height: 16px;"></i>
                        Export Ranking
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Quick Actions Bottom -->
    <div style="margin-top: 30px; display: flex; justify-content: center;">
        <a href="{{ route('pendidikan.settings') }}" style="display: flex; align-items: center; gap: 8px; padding: 12px 24px; background: white; border: 1px solid #cbd5e1; border-radius: 50px; color: #475569; font-weight: 500; text-decoration: none; box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: all 0.2s;"
           onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px rgba(0,0,0,0.1)';"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.05)';">
            <i data-feather="settings" style="width: 18px; height: 18px; color: #64748b;"></i>
            Pengaturan Rapor Digital
        </a>
    </div>

@endsection
