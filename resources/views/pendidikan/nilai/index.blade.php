@extends('layouts.app')

@section('title', 'Rekapitulasi Nilai Ujian')
@section('page-title', 'Rekapitulasi Nilai Ujian')

@section('sidebar-menu')
    @include('pendidikan.partials.sidebar-menu')
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 16px; border: 1px solid #c3e6cb; font-size: 13px;">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 16px; border: 1px solid #f5c6cb; font-size: 13px;">
            ✗ {{ session('error') }}
        </div>
    @endif

    <!-- Header with Filters -->
    <div style="background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%); border-radius: 10px; padding: 16px 24px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(255,152,0,0.25);">
        <!-- Title Row -->
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                    <i data-feather="file-text" style="width: 20px; height: 20px; color: white;"></i>
                </div>
                <div>
                    <h2 style="font-size: 1.1rem; font-weight: 700; color: white; margin: 0 0 2px 0;">Input Nilai Ujian Semester</h2>
                    <p style="color: rgba(255,255,255,0.85); font-size: 0.75rem; margin: 0;">Sistem otomatis menggabungkan dengan ujian mingguan</p>
                </div>
            </div>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('pendidikan.nilai') }}" id="filterForm">
            <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                <!-- Kelas -->
                <div style="display: flex; flex-direction: column; gap: 4px; min-width: 180px;">
                    <label style="font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.9); text-transform: uppercase; letter-spacing: 0.5px; margin: 0; display: flex; align-items: center; gap: 4px;">
                        <i data-feather="users" style="width: 11px; height: 11px;"></i>
                        Kelas
                    </label>
                    <select name="kelas_id" id="kelas_id" required 
                        style="height: 38px; border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; padding: 0 12px; font-size: 13px; background: rgba(255,255,255,0.95); color: #1f2937; font-weight: 500; cursor: pointer;">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Gender -->
                <div style="display: flex; flex-direction: column; gap: 4px; min-width: 130px;">
                    <label style="font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.9); text-transform: uppercase; letter-spacing: 0.5px; margin: 0; display: flex; align-items: center; gap: 4px;">
                        <i data-feather="user-check" style="width: 11px; height: 11px;"></i>
                        Gender
                    </label>
                    <select name="gender" id="gender" 
                        style="height: 38px; border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; padding: 0 12px; font-size: 13px; background: rgba(255,255,255,0.95); color: #1f2937; font-weight: 500; cursor: pointer;">
                        <option value="">Semua</option>
                        <option value="putra" {{ request('gender') == 'putra' ? 'selected' : '' }}>Putra</option>
                        <option value="putri" {{ request('gender') == 'putri' ? 'selected' : '' }}>Putri</option>
                    </select>
                </div>
                
                <!-- Tahun Ajaran -->
                <div style="display: flex; flex-direction: column; gap: 4px; min-width: 140px;">
                    <label style="font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.9); text-transform: uppercase; letter-spacing: 0.5px; margin: 0; display: flex; align-items: center; gap: 4px;">
                        <i data-feather="calendar" style="width: 11px; height: 11px;"></i>
                        Tahun Ajaran
                    </label>
                    <select name="tahun_ajaran" id="tahun_ajaran" required 
                        style="height: 38px; border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; padding: 0 12px; font-size: 13px; background: rgba(255,255,255,0.95); color: #1f2937; font-weight: 500; cursor: pointer;">
                        @foreach($tahunAjaranList as $ta)
                            <option value="{{ $ta }}" {{ request('tahun_ajaran', $tahunAjaran) == $ta ? 'selected' : '' }}>{{ $ta }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Semester -->
                <div style="display: flex; flex-direction: column; gap: 4px; min-width: 130px;">
                    <label style="font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.9); text-transform: uppercase; letter-spacing: 0.5px; margin: 0; display: flex; align-items: center; gap: 4px;">
                        <i data-feather="book-open" style="width: 11px; height: 11px;"></i>
                        Semester
                    </label>
                    <select name="semester" id="semester" required 
                        style="height: 38px; border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; padding: 0 12px; font-size: 13px; background: rgba(255,255,255,0.95); color: #1f2937; font-weight: 500; cursor: pointer;">
                        <option value="1" {{ request('semester', '1') == '1' ? 'selected' : '' }}>Ganjil</option>
                        <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>Genap</option>
                    </select>
                </div>
                
                <!-- Action Button -->
                <div style="display: flex; gap: 8px; margin-left: auto; align-self: flex-end;">
                    <button type="submit"
                        style="height: 38px; padding: 0 20px; display: inline-flex; align-items: center; gap: 6px; background: white; color: #ff9800; border: none; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 6px rgba(0,0,0,0.15);"
                        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.2)';"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 6px rgba(0,0,0,0.15)';">
                        <i data-feather="eye" style="width: 14px; height: 14px;"></i>
                        Tampilkan Data
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Data Container -->
    @if(request('kelas_id'))
        @php
            $kelas = \App\Models\Kelas::find(request('kelas_id'));
            $tahunAjaran = request('tahun_ajaran', $tahunAjaran);
            $semester = request('semester', '1');
            
            // Get all santri in this class
            $santriQuery = \App\Models\Santri::where('kelas_id', request('kelas_id'));
            
            // Filter by gender if specified
            if (request('gender')) {
                $santriQuery->where('gender', request('gender'));
            }
            
            // Eager load nilai
            $santriList = $santriQuery->with(['nilai' => function($q) use ($tahunAjaran, $semester) {
                $q->where('tahun_ajaran', $tahunAjaran)
                  ->where('semester', $semester);
            }])->orderBy('nama_santri')->get();
            
            // Get active subjects for this class
            $displayMapel = $mapelList ?? \App\Models\MataPelajaran::where('is_active', true)->orderBy('nama_mapel')->get();
        @endphp

        <!-- Header -->
        <div style="background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%); color: white; padding: 16px; text-align: center; border-radius: 8px 8px 0 0; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
            <h3 style="margin: 0; font-size: 18px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                NILAI UJIAN SEMESTER - KELAS {{ $kelas->nama_kelas }}
            </h3>
            <p style="margin: 4px 0 0 0; font-size: 13px; opacity: 0.9;">
                Semester {{ $semester == '1' ? 'Ganjil' : 'Genap' }} - {{ $tahunAjaran }}
            </p>
        </div>

        <!-- Info Box -->
        <div style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 12px; margin-bottom: 16px; border-radius: 0 4px 4px 0;">
            <p style="margin: 0; font-size: 12px; color: #856404;">
                <strong>ℹ️ Informasi Sistem Penilaian:</strong><br>
                • Semua nilai ujian semester <strong>WAJIB diisi</strong><br>
                • Sistem otomatis membandingkan dengan ujian mingguan (jika ada) dan memilih nilai terbaik<br>
                • <strong>Nilai Asli</strong> = untuk ranking (bisa < 5) | <strong>Nilai Rapor</strong> = untuk rapor (minimal 5)
            </p>
        </div>

        <!-- Table Form -->
        <form method="POST" action="{{ route('pendidikan.nilai.store-bulk') }}" id="nilaiForm">
            @csrf
            <input type="hidden" name="kelas_id" value="{{ request('kelas_id') }}">
            <input type="hidden" name="tahun_ajaran" value="{{ $tahunAjaran }}">
            <input type="hidden" name="semester" value="{{ $semester }}">
            
            <div style="background: white; border-radius: 0 0 12px 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid #e2e8f0;">

                {{-- Scroll Controls --}}
                <div style="padding: 10px 16px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <button type="button" onclick="scrollTable(-300)" style="background: white; border: 1px solid #cbd5e1; padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; color: #475569; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s;" onmouseover="this.style.borderColor='#94a3b8'; this.style.color='#1e293b'" onmouseout="this.style.borderColor='#cbd5e1'; this.style.color='#475569'">
                        <i data-feather="chevron-left" style="width: 14px; height: 14px;"></i> Geser Kiri
                    </button>
                    
                    <div style="font-size: 12px; color: #64748b; display: flex; align-items: center; gap: 6px;">
                        <i data-feather="move-horizontal" style="width: 14px; height: 14px; color: #94a3b8;"></i>
                        <span style="font-style: italic;">Geser tabel untuk melihat seluruh nilai</span>
                    </div>

                    <button type="button" onclick="scrollTable(300)" style="background: white; border: 1px solid #cbd5e1; padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; color: #475569; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s;" onmouseover="this.style.borderColor='#94a3b8'; this.style.color='#1e293b'" onmouseout="this.style.borderColor='#cbd5e1'; this.style.color='#475569'">
                        Geser Kanan <i data-feather="chevron-right" style="width: 14px; height: 14px;"></i>
                    </button>
                </div>

                {{-- Single Scroll Container --}}
                <style>
                    /* === EXCEL-LIKE TABLE STYLES === */
                    #scrollContainer table th,
                    #scrollContainer table td {
                        box-sizing: border-box;
                        border: 1px solid #b8c4ce;
                    }
                    
                    /* Main Header Row - Dark Blue */
                    .excel-header-main {
                        background: #1e3a5f !important;
                        color: white !important;
                        font-weight: 700;
                        text-transform: uppercase;
                        font-size: 12px;
                    }
                    
                    /* Sub Header Row - Light Gray */
                    .excel-header-sub th {
                        background: #e8ecf0 !important;
                        color: #1e3a5f !important;
                        font-weight: 600;
                        font-size: 10px;
                        text-transform: uppercase;
                    }
                    
                    /* Column Colors */
                    .col-semester { background: #e8ecf0 !important; }
                    .col-mingguan { background: #e8ecf0 !important; }
                    .col-final { background: #d4e5f7 !important; color: #0066cc !important; font-weight: 600; }
                    .col-rapor { background: #f57c00 !important; color: white !important; font-weight: 700; }
                    .col-sumber { background: #d9d9d9 !important; color: #555 !important; }
                    
                    /* Sticky Summary Columns */
                    .sticky-jumlah {
                        width: 70px !important; min-width: 70px !important; max-width: 70px !important;
                        position: sticky !important; right: 140px !important;
                        background: #fff3e0 !important; color: #e65100 !important;
                        font-weight: 700 !important;
                    }
                    .sticky-rata {
                        width: 70px !important; min-width: 70px !important; max-width: 70px !important;
                        position: sticky !important; right: 70px !important;
                        background: #e8f5e9 !important; color: #2e7d32 !important;
                        font-weight: 700 !important;
                    }
                    .sticky-rank {
                        width: 70px !important; min-width: 70px !important; max-width: 70px !important;
                        position: sticky !important; right: 0 !important;
                        background: #ffebee !important; color: #c62828 !important;
                        font-weight: 700 !important;
                    }
                    
                    /* Header Sticky Z-Index */
                    thead .sticky-jumlah, thead .sticky-rata, thead .sticky-rank { z-index: 60 !important; }
                    tbody .sticky-jumlah, tbody .sticky-rata, tbody .sticky-rank { z-index: 30 !important; }
                    tfoot .sticky-jumlah, tfoot .sticky-rata, tfoot .sticky-rank {
                        z-index: 55 !important;
                        background: #1e3a5f !important; color: white !important;
                    }
                    
                    /* Left Sticky Columns */
                    .sticky-no {
                        width: 40px !important; min-width: 40px !important;
                        position: sticky !important; left: 0 !important;
                        background: inherit !important;
                    }
                    .sticky-nama {
                        width: 150px !important; min-width: 150px !important;
                        position: sticky !important; left: 40px !important;
                        background: inherit !important;
                        box-shadow: 3px 0 5px rgba(0,0,0,0.1);
                    }
                    thead .sticky-no, thead .sticky-nama { z-index: 60 !important; background: #1e3a5f !important; }
                    tbody .sticky-no, tbody .sticky-nama { z-index: 30 !important; }
                    tfoot .sticky-no, tfoot .sticky-nama { z-index: 55 !important; background: #1e3a5f !important; }
                    
                    /* Zebra Striping */
                    .row-even { background-color: #ffffff; }
                    .row-odd { background-color: #f5f7fa; }
                    .row-even .sticky-no, .row-even .sticky-nama { background-color: #ffffff !important; }
                    .row-odd .sticky-no, .row-odd .sticky-nama { background-color: #f5f7fa !important; }
                    
                    /* Footer Row */
                    .excel-footer td {
                        background: #1e3a5f !important;
                        color: white !important;
                        font-weight: 700;
                    }
                </style>
                
                <div class="table-container" id="scrollContainer" style="overflow: auto; max-height: 70vh; position: relative;">
                    <table style="width: max-content; border-collapse: collapse; font-size: 11px; min-width: 100%;">
                        <thead>
                            {{-- MAIN HEADER ROW --}}
                            <tr class="excel-header-main">
                                <th rowspan="2" class="sticky-no" style="padding: 10px 6px; text-align: center; position: sticky; top: 0; z-index: 60;">NO</th>
                                <th rowspan="2" class="sticky-nama" style="padding: 10px 8px; text-align: left; position: sticky; top: 0; z-index: 60;">NAMA SANTRI</th>
                                
                                @foreach($displayMapel as $mapel)
                                    <th colspan="5" style="padding: 8px 4px; text-align: center; position: sticky; top: 0; z-index: 50; font-size: 11px;">
                                        {{ $mapel->nama_mapel }}
                                    </th>
                                @endforeach
                                
                                <th rowspan="2" class="sticky-jumlah" style="padding: 8px 4px; text-align: center; position: sticky; top: 0;">JUMLAH</th>
                                <th rowspan="2" class="sticky-rata" style="padding: 8px 4px; text-align: center; position: sticky; top: 0;">RATA²</th>
                                <th rowspan="2" class="sticky-rank" style="padding: 8px 4px; text-align: center; position: sticky; top: 0;">RANK</th>
                            </tr>
                            
                            {{-- SUB HEADER ROW --}}
                            <tr class="excel-header-sub">
                                @foreach($displayMapel as $mapel)
                                    <th class="col-semester" style="padding: 6px 3px; text-align: center; min-width: 65px; position: sticky; top: 38px; z-index: 40;">SEMESTER</th>
                                    <th class="col-mingguan" style="padding: 6px 3px; text-align: center; min-width: 65px; position: sticky; top: 38px; z-index: 40;">MINGGUAN</th>
                                    <th class="col-final" style="padding: 6px 3px; text-align: center; min-width: 55px; position: sticky; top: 38px; z-index: 40;">FINAL</th>
                                    <th class="col-rapor" style="padding: 6px 3px; text-align: center; min-width: 55px; position: sticky; top: 38px; z-index: 40;">RAPOR</th>
                                    <th class="col-sumber" style="padding: 6px 3px; text-align: center; min-width: 55px; position: sticky; top: 38px; z-index: 40;">SUMBER</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($santriList as $index => $santri)
                                <tr class="santri-row {{ $index % 2 == 0 ? 'row-even' : 'row-odd' }}">
                                    {{-- Fixed Left: NO --}}
                                    <td class="sticky-no" style="padding: 6px; text-align: center; font-weight: 500; color: #1e3a5f;">
                                        {{ $index + 1 }}
                                    </td>
                                    {{-- Fixed Left: NAMA --}}
                                    <td class="sticky-nama" style="padding: 6px 8px;">
                                        <input type="hidden" name="santri[{{ $index }}][id]" value="{{ $santri->id }}">
                                        <strong style="color: #1e3a5f; font-size: 11px;">{{ $santri->nama_santri }}</strong>
                                    </td>
                                    
                                    @foreach($displayMapel as $mapel)
                                        @php
                                            $nilai = $santri->nilai->where('mapel_id', $mapel->id)->first();
                                            $metadata = $nilai && $nilai->source_metadata ? $nilai->source_metadata : null;
                                            $weeklyScore = 0;
                                            $weeklyStatus = '-';
                                            $hasWeekly = false;
                                            if(isset($weeklyExamData[$santri->id][$mapel->id])) {
                                                $wData = $weeklyExamData[$santri->id][$mapel->id];
                                                $weeklyScore = $wData['score'];
                                                $weeklyStatus = $wData['status'];
                                                $hasWeekly = true;
                                            } elseif ($metadata && isset($metadata['weekly_score'])) {
                                                $weeklyScore = $metadata['weekly_score'];
                                                $weeklyStatus = $metadata['weekly_status'];
                                                $hasWeekly = true;
                                            }
                                        @endphp
                                        
                                        {{-- Semester Input --}}
                                        <td class="col-semester" style="padding: 4px; text-align: center;">
                                            <input type="number" 
                                                   name="santri[{{ $index }}][mapel][{{ $mapel->id }}]" 
                                                   class="nilai-input inp-sem-{{ $mapel->id }}"
                                                   data-mapel-id="{{ $mapel->id }}"
                                                   data-weekly-score="{{ $weeklyScore }}"
                                                   data-has-weekly="{{ $hasWeekly ? 'true' : 'false' }}"
                                                   value="{{ $nilai ? $nilai->nilai_ujian_semester : '' }}" 
                                                   min="0" max="100" step="0.01" required
                                                   style="width: 50px; padding: 4px; text-align: center; border: 1px solid #ccc; border-radius: 3px; font-weight: 600; font-size: 11px;"
                                                   onfocus="this.style.borderColor='#0066cc'; this.style.background='#fff'"
                                                   onblur="this.style.borderColor='#ccc'; this.style.background='#fff'">
                                        </td>
                                        
                                        {{-- Weekly Score --}}
                                        <td class="col-mingguan" style="padding: 4px; text-align: center; font-size: 11px;">
                                            @if($hasWeekly)
                                                <span class="val-week-{{ $mapel->id }}" style="font-weight: 600; color: #1e3a5f;">{{ number_format($weeklyScore, 0) }}</span>
                                            @else
                                                <span class="val-week-{{ $mapel->id }}" style="color: #999;">-</span>
                                            @endif
                                        </td>
                                        
                                        {{-- FINAL --}}
                                        <td class="asli-cell-{{ $mapel->id }} col-final" style="padding: 4px; text-align: center;">
                                            <strong class="val-final-{{ $mapel->id }}" style="font-size: 11px;">-</strong>
                                        </td>
                                        
                                        {{-- RAPOR --}}
                                        <td class="rapor-cell-{{ $mapel->id }} col-rapor" style="padding: 4px; text-align: center;">
                                            <strong class="val-rapor-{{ $mapel->id }}" style="font-size: 11px;">-</strong>
                                        </td>
                                        
                                        {{-- SUMBER --}}
                                        <td class="source-cell-{{ $mapel->id }} col-sumber" style="padding: 4px; text-align: center;">
                                            <span class="badge-source" style="font-size: 9px; font-weight: 700;">-</span>
                                        </td>
                                    @endforeach
                                    
                                    @php
                                        // Calculate JUMLAH (sum of nilai_asli)
                                        $jumlah = $santri->nilai->sum('nilai_asli');
                                        // Calculate RATA-RATA (average of nilai_asli)
                                        $rataRata = $santri->nilai->count() > 0 ? $jumlah / $santri->nilai->count() : 0;
                                    @endphp
                                    
                                    {{-- JUMLAH Column (Sticky Right) --}}
                                    <td class="jumlah-cell sticky-jumlah" style="padding: 8px; text-align: center; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; font-weight: 700; font-size: 12px;">
                                        {{ number_format($jumlah, 1) }}
                                    </td>
                                    
                                    {{-- RATA-RATA Column (Sticky Right) --}}
                                    <td class="rata-cell sticky-rata" style="padding: 8px; text-align: center; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; font-weight: 700; font-size: 12px;">
                                        {{ number_format($rataRata, 2) }}
                                    </td>
                                    
                                    {{-- RANK Column (Sticky Right) --}}
                                    <td class="rank-cell sticky-rank" style="padding: 8px; text-align: center; border-bottom: 1px solid #e2e8f0; font-weight: 700; font-size: 12px;" data-rata="{{ $rataRata }}" data-santri-id="{{ $santri->id }}">
                                        -
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                        {{-- FOOTER: RATA-RATA KELAS --}}
                        <tfoot style="position: sticky; bottom: 0; z-index: 50;">
                            <tr class="excel-footer">
                                <td colspan="2" class="sticky-no" style="padding: 8px; text-align: right; font-size: 11px; text-transform: uppercase;">
                                    RATA-RATA KELAS
                                </td>
                                @foreach($displayMapel as $mapel)
                                    <td class="footer-avg-sem-{{ $mapel->id }}" style="padding: 6px; text-align: center; font-size: 11px;">0</td>
                                    <td class="footer-avg-week-{{ $mapel->id }}" style="padding: 6px; text-align: center; font-size: 11px; color: #94a3b8;">0</td>
                                    <td class="footer-avg-final-{{ $mapel->id }}" style="padding: 6px; text-align: center; font-size: 11px; color: #60a5fa;">0</td>
                                    <td class="footer-avg-rapor-{{ $mapel->id }}" style="padding: 6px; text-align: center; font-size: 11px; color: #fb923c;">0</td>
                                    <td style="padding: 6px; font-size: 11px;"></td>
                                @endforeach
                                <td class="footer-avg-jumlah sticky-jumlah" style="padding: 6px; text-align: center; font-size: 11px;">0</td>
                                <td class="footer-avg-rata sticky-rata" style="padding: 6px; text-align: center; font-size: 11px;">0</td>
                                <td class="sticky-rank" style="padding: 6px; text-align: center; font-size: 11px;">-</td>
                            </tr>
                        </tfoot>
                    </table>
                </div> <!-- Close scrollContainer -->
                
                
                <div style="padding: 20px; background: white; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <div style="font-size: 12px; color: #64748b;">
                        <strong>Note:</strong> Nilai Final otomatis memilih yang terbaik antara Ujian Mingguan vs Semester (Smart Scoring).
                    </div>
                    <button type="submit" class="btn btn-primary" style="padding: 12px 32px; font-size: 14px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; border-radius: 8px; color: white; font-weight: 600; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.5); cursor: pointer; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 10px 15px -3px rgba(59, 130, 246, 0.5)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(59, 130, 246, 0.5)';">
                        <i data-feather="save" style="width: 16px; height: 16px; margin-right: 8px;"></i>
                        Simpan Nilai
                    </button>
                    
                </div>
            </div>
        </form>
    @else
        <div style="background: white; border-radius: 12px; padding: 60px; text-align: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            <div style="background: #eff6ff; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px auto;">
                <i data-feather="filter" style="width: 40px; height: 40px; color: #3b82f6;"></i>
            </div>
            <h3 style="color: #1e293b; margin: 0 0 8px 0;">Filter Data Diperlukan</h3>
            <p style="color: #64748b; font-size: 15px; margin: 0;">Silakan pilih kelas, tahun ajaran, dan semester untuk memuat data penilaian.</p>
        </div>
    @endif
@endsection

@push('scripts')
<script>
// Main initialization function - called on both DOMContentLoaded and turbo:load
function initializeNilaiCalculations() {
    console.log('🔄 Initializing Nilai Calculations...');
    
    // Replace feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
    
    // --- REAL-TIME CALCULATION ---
    const inputs = document.querySelectorAll('.nilai-input');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            // Find the parent row
            const row = this.closest('tr');
            recalculateRow(row);
            calculateColumnAverages(); // Update footer
        });
    });

    function recalculateRow(row) {
        // Get all inputs in this row
        const rowInputs = row.querySelectorAll('.nilai-input');
        let total = 0;
        let count = 0;
        
        rowInputs.forEach(inp => {
            let semesterVal = parseFloat(inp.value);
            if (isNaN(semesterVal)) semesterVal = 0; // Treat empty as 0 for calculation context
            
            const weeklyVal = parseFloat(inp.getAttribute('data-weekly-score')) || 0;
            const hasWeekly = inp.getAttribute('data-has-weekly') === 'true';
            const mapelId = inp.getAttribute('data-mapel-id');
            
            // 1. CALCULATE PER-SUBJECT AVERAGE (For 'RATA' column)
            // Logic: If has weekly, Avg = (Sem + Week) / 2. If no weekly, Avg = Sem.
            // Removed as per instruction
            
            // 2. SMART SCORING LOGIC CLIENT SIDE (Final Grade)
            let finalScore = semesterVal;
            let source = 'SEM';
            
            if (hasWeekly && weeklyVal > semesterVal) {
                finalScore = weeklyVal;
                source = 'MIN'; // Mingguan Higher
            } else if (hasWeekly && semesterVal >= weeklyVal) {
                finalScore = semesterVal;
                source = 'SEM'; // Semester Higher (or Equal)
            }
            
            // Log for debug
            // console.log(`Mapel ${mapelId}: Sem=${semesterVal}, Week=${weeklyVal}, Final=${finalScore}`);
            
            // Calculate Rapor (Min 5 rule)
            let nilaiRapor = finalScore < 5 ? 5 : finalScore;
            
            // UPDATE DISPLAY CELLS
            // const rataCell = row.querySelector(`.per-mapel-rata-${mapelId} strong`); // Removed
            const asliCell = row.querySelector(`.asli-cell-${mapelId} strong`);
            const raporCell = row.querySelector(`.rapor-cell-${mapelId} strong`);
            const sourceCell = row.querySelector(`.source-cell-${mapelId} .badge-source`);
            
            // if (rataCell) rataCell.textContent = subjectAvg.toFixed(1); // Removed
            if (asliCell) {
                asliCell.textContent = finalScore.toFixed(1);
                asliCell.setAttribute('data-val', finalScore); // Store for footer
            }
            if (raporCell) {
                raporCell.textContent = nilaiRapor.toFixed(1);
                raporCell.setAttribute('data-val', nilaiRapor); // Store for footer
            }
            if (sourceCell) {
                sourceCell.textContent = source;
                if (source === 'SEM') {
                    sourceCell.style.color = '#64748b'; // Gray
                    sourceCell.style.background = '#f1f5f9';
                } else if (source === 'MIN') {
                    sourceCell.style.color = '#059669'; // Green
                    sourceCell.style.background = '#d1fae5';
                }
            }
            
            // Add to total (only if input is not empty OR has weekly)
            if (inp.value !== '' || hasWeekly) {
                 total += finalScore;
                 count++;
            }
        });
        
        // Calculate Avg
        const avg = count > 0 ? total / count : 0;
        
        // Update DOM - JUMLAH & RATA-RATA using class querySelector
        const totalCell = row.querySelector('.jumlah-cell');
        const avgCell = row.querySelector('.rata-cell');
        const rankCell = row.querySelector('.rank-cell');
        
        if(totalCell) {
            totalCell.textContent = total.toFixed(1);
            totalCell.setAttribute('data-val', total);
        }
        if(avgCell) {
            avgCell.textContent = avg.toFixed(2);
            avgCell.setAttribute('data-val', avg);
        }
        
        // Update data attribute for ranking
        if(rankCell) rankCell.setAttribute('data-rata', avg);
        
        // Re-run ranking
        updateRankings();
    }
    
    // Function to calculate vertical averages for the footer
    function calculateColumnAverages() {
        const rows = document.querySelectorAll('tbody tr.santri-row');
        const count = rows.length;
        if (count === 0) return;
        
        // We need to iterate over each Mapel ID
        // The displayMapel IDs are needed. We can get them from the inputs of the first row?
        // Or cleaner: use a list of mapel IDs generated by Blade.
        // We will scan the DOM for mapel columns.
        
        // Find all unique mapel IDs present in the first row inputs
        const firstRowInputs = rows[0].querySelectorAll('.nilai-input');
        
        // Per Mapel Loop
        firstRowInputs.forEach(inp => {
            const mapelId = inp.getAttribute('data-mapel-id');
            
            // ACCUMULATORS
            let sumSem = 0;
            let sumWeek = 0;
            let sumFinal = 0;
            let sumRapor = 0;
            let validSemCount = 0;
            let validWeekCount = 0;
            
            rows.forEach(row => {
                // Semester
                const semInput = row.querySelector(`.inp-sem-${mapelId}`);
                if (semInput && semInput.value !== '') {
                    sumSem += parseFloat(semInput.value);
                    validSemCount++;
                }
                
                // Weekly
                const weekSpan = row.querySelector(`.val-week-${mapelId}`);
                if (weekSpan) {
                     const txt = weekSpan.textContent.trim();
                     if (txt !== '-') {
                        sumWeek += parseFloat(txt.replace(/,/g, ''));
                        validWeekCount++;
                     }
                }
                
                // Final
                const finalEl = row.querySelector(`.val-final-${mapelId}`);
                if (finalEl && finalEl.hasAttribute('data-val')) {
                    sumFinal += parseFloat(finalEl.getAttribute('data-val'));
                }
                
                // Rapor
                const raporEl = row.querySelector(`.val-rapor-${mapelId}`);
                if (raporEl && raporEl.hasAttribute('data-val')) {
                    sumRapor += parseFloat(raporEl.getAttribute('data-val'));
                }
            });
            
            // Calculate Averages
            const avgSem = validSemCount > 0 ? sumSem / validSemCount : 0;
            const avgWeek = validWeekCount > 0 ? sumWeek / validWeekCount : 0;
            const avgFinal = count > 0 ? sumFinal / count : 0; // Avg over all students
            const avgRapor = count > 0 ? sumRapor / count : 0;
            
            // Update Footer Cells
            const footSem = document.querySelector(`.footer-avg-sem-${mapelId}`);
            const footWeek = document.querySelector(`.footer-avg-week-${mapelId}`);
            const footFinal = document.querySelector(`.footer-avg-final-${mapelId}`);
            const footRapor = document.querySelector(`.footer-avg-rapor-${mapelId}`);
            
            if (footSem) footSem.textContent = avgSem.toFixed(1);
            if (footWeek) footWeek.textContent = avgWeek.toFixed(1);
            if (footFinal) footFinal.textContent = avgFinal.toFixed(1);
            if (footRapor) footRapor.textContent = avgRapor.toFixed(1);
        });
        
        // SUMMARY COLUMNS AVERAGE
        let sumJumlah = 0;
        let sumRata = 0;
        rows.forEach(row => {
            const jCell = row.querySelector('.jumlah-cell');
            const rCell = row.querySelector('.rata-cell');
            if(jCell && jCell.hasAttribute('data-val')) sumJumlah += parseFloat(jCell.getAttribute('data-val'));
            if(rCell && rCell.hasAttribute('data-val')) sumRata += parseFloat(rCell.getAttribute('data-val'));
        });
        
        const avgJumlah = count > 0 ? sumJumlah / count : 0;
        const avgRata = count > 0 ? sumRata / count : 0;
        
        const footJumlah = document.querySelector('.footer-avg-jumlah');
        const footRata = document.querySelector('.footer-avg-rata');
        
        if (footJumlah) footJumlah.textContent = avgJumlah.toFixed(1);
        if (footRata) footRata.textContent = avgRata.toFixed(2);
    }
    
    // ====== AUTO-CALCULATE ON PAGE LOAD ======
    const allSantriRows = document.querySelectorAll('tbody tr.santri-row');
    console.log('🔄 Auto-calculating ' + allSantriRows.length + ' santri rows...');
    
    if (allSantriRows.length === 0) {
        console.warn('⚠️ No santri rows found! Check selector: tbody tr.santri-row');
    }
    
    allSantriRows.forEach((row, idx) => {
        try {
            recalculateRow(row);
        } catch (e) {
            console.error('❌ Error calculating row ' + (idx+1) + ':', e);
        }
    });
    
    // Update rankings after all rows calculated
    try {
        updateRankings();
        console.log('🏆 Rankings updated.');
    } catch (e) {
        console.error('❌ Error updating rankings:', e);
    }
    
    // Calculate footer averages
    try {
        calculateColumnAverages();
        console.log('📊 Footer averages calculated.');
    } catch (e) {
        console.error('❌ Error calculating footer:', e);
    }
    
    console.log('✅ Initial calculations complete!');

    // --- FORM VALIDATION ---
    const form = document.getElementById('nilaiForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const inputs = document.querySelectorAll('.nilai-input');
            let hasEmpty = false;
            
            inputs.forEach(input => {
                if (!input.value || input.value === '') {
                    input.style.borderColor = '#ef4444';
                    input.style.background = '#fef2f2';
                    hasEmpty = true;
                }
            });
            
            if (hasEmpty) {
                e.preventDefault();
                alert('⚠️ Semua nilai ujian semester WAJIB diisi!\n\nTidak boleh ada yang kosong.');
                return false;
            }
            
            if (!confirm('Simpan nilai ujian semester?\n\nSistem akan otomatis menggabungkan dengan ujian mingguan (jika ada).')) {
                e.preventDefault();
                return false;
            }
        });
    }
    
    // --- RANKING LOGIC ---
    function updateRankings() {
        const rankCells = document.querySelectorAll('td[data-rata]');
        if (rankCells.length > 0) {
            const students = Array.from(rankCells).map(cell => ({
                cell: cell,
                rata: parseFloat(cell.getAttribute('data-rata')) || 0,
                santriId: cell.getAttribute('data-santri-id')
            }));
            
            // Sort by rata-rata (descending)
            students.sort((a, b) => b.rata - a.rata);
            
            // Assign ranks (UNIQUE)
            students.forEach((student, index) => {
                student.rank = index + 1;
                
                const rankBadge = document.createElement('strong');
                rankBadge.style.fontSize = '14px';
                
                if (student.rank === 1) {
                    rankBadge.innerHTML = '🥇 1';
                } else if (student.rank === 2) {
                    rankBadge.innerHTML = '🥈 2';
                } else if (student.rank === 3) {
                    rankBadge.innerHTML = '🥉 3';
                } else {
                    rankBadge.textContent = student.rank;
                }
                
                student.cell.innerHTML = '';
                student.cell.appendChild(rankBadge);
            });
        }
    }
    
    // Initial ranking calculation
    updateRankings();
    
    console.log('✅ Nilai Calculations Initialized!');
}

// Register event listeners for both Turbo and non-Turbo navigation
document.addEventListener('DOMContentLoaded', initializeNilaiCalculations);
document.addEventListener('turbo:load', initializeNilaiCalculations);

// Manual Scroll Function
function scrollTable(amount) {
    const container = document.getElementById('scrollContainer');
    if (container) {
        container.scrollBy({
            left: amount,
            behavior: 'smooth'
        });
    }
}
</script>
@endpush
