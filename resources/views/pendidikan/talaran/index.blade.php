@extends('layouts.app')

@section('title', 'Sistem Talaran Santri')
@section('page-title', 'Sistem Talaran Santri')

@section('sidebar-menu')
    @include('pendidikan.partials.sidebar-menu')
@endsection

@section('content')
<style>
    /* Disable main-content scroll - only table should scroll */
    .main-content {
        overflow-y: hidden !important;
        max-height: 100vh !important;
    }
    
    /* Hide Scrollbars */
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
    
    /* Modern Elegant Table Styles */
    :root {
        --color-period-1: #2563eb; /* Modern Royal Blue */
        --color-period-1-light: #eff6ff; 
        --color-period-2: #059669; /* Modern Emerald */
        --color-period-2-light: #ecfdf5;
        --border-color: #e5e7eb;
        --text-color: #1f2937;
        --text-muted: #6b7280;
    }

    .modern-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        padding: 24px;
        margin-bottom: 24px;
        border: 1px solid rgba(0,0,0,0.02);
    }

    /* Filter Section */
    .filter-wrapper {
        display: flex;
        gap: 20px;
        align-items: flex-end;
        flex-wrap: wrap;
    }
    
    .filter-group label {
        display: block;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
        margin-bottom: 6px;
    }
    
    .modern-select, .modern-input {
        padding: 10px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 0.875rem;
        color: var(--text-color);
        background-color: #f9fafb;
        transition: all 0.2s;
        min-width: 140px;
    }
    
    .modern-select:focus, .modern-input:focus {
        outline: none;
        border-color: var(--color-period-1);
        background-color: white;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    /* Table Styling */
    .modern-table-container {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.03);
    }

    .modern-table {
        width: 100%;
        border-collapse: separate; /* Allows sticky headers to work better */
        border-spacing: 0;
        font-size: 0.85rem;
    }

    .modern-table th {
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 12px 8px;
        border-bottom: 1px solid var(--border-color);
        border-right: 1px solid var(--border-color);
        text-align: center;
        position: sticky; /* Make headers sticky */
        top: 0;
        z-index: 30;
    }

    .modern-table td {
        padding: 8px;
        border-bottom: 1px solid var(--border-color);
        border-right: 1px solid var(--border-color);
        vertical-align: middle;
        color: var(--text-color);
        text-align: center;
    }

    /* Column Specific Styles */
    .th-period-1 {
        background: linear-gradient(to bottom, #3b82f6, #2563eb);
        color: white;
        border-bottom: none !important;
        /* Sticky properties inherited from th, top: 0 is correct */
    }
    
    .th-period-2 {
        background: linear-gradient(to bottom, #10b981, #059669);
        color: white;
        border-bottom: none !important;
        /* Sticky properties inherited from th, top: 0 is correct */
    }

    .th-sub {
        background-color: #f8fafc;
        color: var(--text-muted);
        font-size: 0.7rem;
        top: 48px !important; /* Offset for second row of headers */
        z-index: 30;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05); /* Small shadow for depth */
    }
    
    .th-sticky-no {
        position: sticky;
        left: 0;
        top: 0;
        z-index: 40; /* Highest priority (corner) */
        background-color: #f8fafc;
        width: 50px;
        border-right: 2px solid var(--border-color) !important;
        border-bottom: 1px solid var(--border-color); /* Ensure border exists */
    }
    
    .th-sticky-name {
        position: sticky;
        left: 50px;
        top: 0;
        z-index: 40; /* Highest priority (corner) */
        background-color: #f8fafc;
        width: 200px;
        text-align: left !important;
        padding-left: 16px !important;
        border-right: 2px solid var(--border-color) !important;
        box-shadow: 4px 0 6px -4px rgba(0,0,0,0.1);
        border-bottom: 1px solid var(--border-color);
    }
    
    .td-sticky-no {
        position: sticky;
        left: 0;
        z-index: 20;
        background-color: white;
        border-right: 2px solid var(--border-color) !important;
        font-weight: 500;
        color: var(--text-muted);
    }
    
    .td-sticky-name {
        position: sticky;
        left: 50px;
        z-index: 20;
        background-color: white;
        text-align: left !important;
        padding-left: 16px !important;
        border-right: 2px solid var(--border-color) !important;
        box-shadow: 4px 0 6px -4px rgba(0,0,0,0.05);
    }
    
    .name-primary {
        font-weight: 600;
        color: #111827;
        margin-bottom: 2px;
    }
    
    .name-secondary {
        font-size: 0.7rem;
        color: #9ca3af;
    }

    /* Inputs */
    .cell-input {
        width: 100%;
        max-width: 50px;
        padding: 6px 0;
        border: 1px solid transparent;
        border-radius: 6px;
        text-align: center; /* CENTERED INPUT TEXT */
        font-weight: 500;
        background-color: transparent;
        transition: all 0.2s;
    }
    
    .cell-input:hover {
        background-color: rgba(0,0,0,0.02);
        border-color: #e5e7eb;
    }
    
    .cell-input:focus {
        background-color: white;
        border-color: var(--color-period-1);
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
        outline: none;
    }

    .cell-input-tamat {
        background-color: rgba(245, 158, 11, 0.1);
        color: #d97706;
    }
    
    .cell-input-alfa {
        background-color: rgba(239, 68, 68, 0.05);
        color: #ef4444;
    }

    .text-sum { font-weight: 700; color: var(--color-period-1); }
    .text-sum-2 { font-weight: 700; color: var(--color-period-2); }
    
    .text-total {
        font-size: 0.75rem;
        font-weight: 500;
        color: #4b5563;
        white-space: nowrap;
    }
    
    .text-alfa-display {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #ef4444;
    }

    /* Action Button */
    .btn-save {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background-color: #eff6ff;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-save:hover {
        background-color: #2563eb;
        color: white;
        transform: scale(1.1);
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.3);
    }
    
    /* Alternating rows override for aesthetics */
    tr:hover td {
        background-color: #f8fafc !important; 
    }
    
    /* Ensure inputs on hover row get white bg if needed, but transparent is fine */

    .btn-print {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        border: 1px solid transparent;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-print-white {
        background: white;
        border: 1px solid #e5e7eb;
        color: #374151;
    }
    .btn-print-white:hover { border-color: #d1d5db; background: #f9fafb; }
    
    .btn-print-primary {
        background: var(--color-period-1);
        color: white;
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
    }
    .btn-print-primary:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

</style>

<div style="width: 100%; box-sizing: border-box;">
    <!-- Single Compact Sticky Header with Filter -->
    <div style="position: sticky; top: 0; z-index: 100; background: white; margin-bottom: 20px; padding: 0 30px;">
        <!-- Blue Gradient Header Row with All Elements -->
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 16px 24px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 10px; box-shadow: 0 4px 12px rgba(37,99,235,0.25);">
            <!-- Left: Title & Subtitle -->
            <div style="flex-shrink: 0;">
                <h2 style="font-size: 1.1rem; font-weight: 700; color: white; margin: 0 0 2px 0; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="book-open" style="width: 18px; height: 18px;"></i>
                    Sistem Talaran Santri
                </h2>
                <p style="color: rgba(255,255,255,0.85); font-size: 0.75rem; margin: 0;">Kelola hafalan mingguan santri dengan mudah</p>
            </div>
            
            <!-- Right: Print Buttons -->
            <div style="display: flex; gap: 6px; flex-shrink: 0;">
                <a href="{{ route('talaran.cetak.1-2', request()->all()) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 5px; padding: 7px 14px; font-size: 11px; font-weight: 600; color: #2563eb; background: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-decoration: none; white-space: nowrap; transition: all 0.2s;">
                    <i data-feather="printer" style="width: 13px; height: 13px;"></i>
                    M1-2
                </a>
                <a href="{{ route('talaran.cetak.3-4', request()->all()) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 5px; padding: 7px 14px; font-size: 11px; font-weight: 600; color: #2563eb; background: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-decoration: none; white-space: nowrap; transition: all 0.2s;">
                    <i data-feather="printer" style="width: 13px; height: 13px;"></i>
                    M3-4
                </a>
                <a href="{{ route('talaran.cetak.full', request()->all()) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 5px; padding: 7px 14px; font-size: 11px; font-weight: 600; color: white; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none; border-radius: 6px; box-shadow: 0 2px 6px rgba(16,185,129,0.4); text-decoration: none; white-space: nowrap; transition: all 0.2s;">
                    <i data-feather="file-text" style="width: 13px; height: 13px;"></i>
                    Laporan Full
                </a>
            </div>
        </div>
        
        <!-- White Filter Row Below Header -->
        <div style="display: flex; align-items: center; gap: 12px; padding: 12px 24px; background: white; border-radius: 0 0 10px 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); margin-top: -10px; padding-top: 16px;">
            <form action="{{ route('talaran.index') }}" method="GET" style="display: flex; align-items: center; gap: 10px; width: 100%;">
                <!-- Filter Label -->
                <div style="display: flex; align-items: center; gap: 5px;">
                    <i data-feather="filter" style="width: 14px; height: 14px; color: #2563eb;"></i>
                    <span style="font-size: 10px; font-weight: 700; color: #2563eb; text-transform: uppercase; letter-spacing: 0.3px; white-space: nowrap;">Filter Data</span>
                </div>
                
                <!-- Kelas Filter -->
                <div style="display: flex; align-items: center; gap: 6px;">
                    <label style="font-size: 10px; font-weight: 600; color: #6b7280; text-transform: uppercase; white-space: nowrap;">Kelas</label>
                    <select name="kelas_id" style="padding: 6px 10px; font-size: 11px; border: 1px solid #d1d5db; border-radius: 6px; outline: none; transition: all 0.2s; background: white;" onchange="this.form.submit()" onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 0 0 2px rgba(37,99,235,0.1)'" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ $kelasId == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Bulan Filter -->
                <div style="display: flex; align-items: center; gap: 6px;">
                    <label style="font-size: 10px; font-weight: 600; color: #6b7280; text-transform: uppercase; white-space: nowrap;">Bulan</label>
                    <select name="bulan" style="padding: 6px 10px; font-size: 11px; border: 1px solid #d1d5db; border-radius: 6px; outline: none; transition: all 0.2s; background: white;" onchange="this.form.submit()" onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 0 0 2px rgba(37,99,235,0.1)'" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                
                <!-- Tahun Filter -->
                <div style="display: flex; align-items: center; gap: 6px;">
                    <label style="font-size: 10px; font-weight: 600; color: #6b7280; text-transform: uppercase; white-space: nowrap;">Tahun</label>
                    <input type="number" name="tahun" value="{{ $tahun }}" style="padding: 6px 10px; font-size: 11px; border: 1px solid #d1d5db; border-radius: 6px; width: 70px; outline: none; transition: all 0.2s;" onchange="this.form.submit()" onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 0 0 2px rgba(37,99,235,0.1)'" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
                </div>
                
                <!-- Info Badge -->
                <div style="margin-left: auto; display: flex; align-items: center; gap: 5px; padding: 6px 12px; background: rgba(37,99,235,0.08); border-radius: 6px; border: 1px solid rgba(37,99,235,0.15);">
                    <i data-feather="info" style="width: 13px; height: 13px; color: #2563eb;"></i>
                    <span style="font-size: 10px; color: #2563eb; font-weight: 600;">
                        {{ \Carbon\Carbon::create()->month((int)$bulan)->translatedFormat('F') }} {{ $tahun }}
                    </span>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; color: #065f46; padding: 16px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px; border: 1px solid #a7f3d0;">
            <i data-feather="check-circle" style="width: 20px;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Main Table -->
    <div class="modern-table-container">
        <div style="overflow-x: auto; overflow-y: auto; max-height: 70vh;">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th class="th-sticky-no" rowspan="2">No</th>
                        <th class="th-sticky-name" rowspan="2">Nama Santri</th>
                        
                        <th colspan="7" class="th-period-1">PERIODE MINGGU 1-2</th>
                        <th colspan="7" class="th-period-2">PERIODE MINGGU 3-4</th>
                        
                        <th rowspan="2" style="background: white; border-bottom: 1px solid #e5e7eb; min-width: 60px;">Aksi</th>
                    </tr>
                    <tr>
                        <!-- Sub Headers M1-2 -->
                        <th class="th-sub">M1</th>
                        <th class="th-sub">M2</th>
                        <th class="th-sub">JML</th>
                        <th class="th-sub">TAMAT</th>
                        <th class="th-sub">ALFA</th>
                        <th class="th-sub" style="min-width: 80px;">TOTAL</th>
                        <th class="th-sub">KET</th>
                        
                        <!-- Sub Headers M3-4 -->
                        <th class="th-sub">M3</th>
                        <th class="th-sub">M4</th>
                        <th class="th-sub">JML</th>
                        <th class="th-sub">TAMAT</th>
                        <th class="th-sub">ALFA</th>
                        <th class="th-sub" style="min-width: 80px;">TOTAL</th>
                        <th class="th-sub">KET</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($santriList as $index => $santri)
                        @php
                            $talaran = $talaranRecords->get($santri->id);
                        @endphp
                        <tr>
                            <form action="{{ $talaran ? route('talaran.update', $talaran->id) : route('talaran.store') }}" method="POST">
                                @csrf
                                @if($talaran) @method('PUT') @endif
                                
                                <input type="hidden" name="santri_id" value="{{ $santri->id }}">
                                <input type="hidden" name="bulan" value="{{ $bulan }}">
                                <input type="hidden" name="tahun" value="{{ $tahun }}">

                                <td class="td-sticky-no">{{ $index + 1 }}</td>
                                <td class="td-sticky-name">
                                    <div class="name-primary">{{ $santri->nama_santri }}</div>
                                    <div class="name-secondary">{{ $santri->kelas->nama_kelas ?? '' }}</div>
                                </td>

                                <!-- Period 1 -->
                                <td><input type="number" name="minggu_1" value="{{ $talaran->minggu_1 ?? 0 }}" class="cell-input" min="0" @if(auth()->user()->role === 'rois') disabled style="background:#f3f4f6; cursor:not-allowed;" @endif></td>
                                <td><input type="number" name="minggu_2" value="{{ $talaran->minggu_2 ?? 0 }}" class="cell-input" min="0" @if(auth()->user()->role === 'rois') disabled style="background:#f3f4f6; cursor:not-allowed;" @endif></td>
                                <td class="text-sum">{{ $talaran->jumlah_1_2 ?? 0 }}</td>
                                <td><input type="number" name="tamat_1_2" value="{{ $talaran->tamat_1_2 ?? 0 }}" class="cell-input cell-input-tamat" min="0" @if(auth()->user()->role === 'rois') disabled style="background:#f3f4f6; cursor:not-allowed;" @endif></td>
                                <td><input type="number" name="alfa_1_2" value="{{ $talaran->alfa_1_2 ?? 0 }}" class="cell-input cell-input-alfa" min="0" @if(auth()->user()->role === 'rois') disabled style="background:#f3f4f6; cursor:not-allowed;" @endif></td>
                                <td class="text-total">{{ $talaran->total_1_2 ?? '-' }}</td>
                                <td class="text-alfa-display">
                                    @if(($talaran->alfa_1_2 ?? 0) > 0) ALFA {{ $talaran->alfa_1_2 }} @endif
                                </td>

                                <!-- Period 2 -->
                                <td><input type="number" name="minggu_3" value="{{ $talaran->minggu_3 ?? 0 }}" class="cell-input" min="0" @if(auth()->user()->role === 'rois') disabled style="background:#f3f4f6; cursor:not-allowed;" @endif></td>
                                <td><input type="number" name="minggu_4" value="{{ $talaran->minggu_4 ?? 0 }}" class="cell-input" min="0" @if(auth()->user()->role === 'rois') disabled style="background:#f3f4f6; cursor:not-allowed;" @endif></td>
                                <td class="text-sum-2">{{ $talaran->jumlah_3_4 ?? 0 }}</td>
                                <td><input type="number" name="tamat" value="{{ $talaran->tamat ?? 0 }}" class="cell-input cell-input-tamat" min="0" @if(auth()->user()->role === 'rois') disabled style="background:#f3f4f6; cursor:not-allowed;" @endif></td>
                                <td><input type="number" name="alfa" value="{{ $talaran->alfa ?? 0 }}" class="cell-input cell-input-alfa" min="0" @if(auth()->user()->role === 'rois') disabled style="background:#f3f4f6; cursor:not-allowed;" @endif></td>
                                <td class="text-total">{{ $talaran->total_3_4 ?? '-' }}</td>
                                <td class="text-alfa-display">
                                    @if(($talaran->alfa ?? 0) > 0) ALFA {{ $talaran->alfa }} @endif
                                </td>

                                <td>
                                    @if(auth()->user()->role !== 'rois')
                                    <button type="submit" class="btn-save" title="Simpan Perubahan">
                                        <i data-feather="save" style="width: 16px;"></i>
                                    </button>
                                    @else
                                    <span style="font-size: 10px; color: #ccc;">-</span>
                                    @endif
                                </td>
                            </form>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="17" style="padding: 40px; text-align: center; color: #9ca3af;">
                                <i data-feather="inbox" style="width: 48px; height: 48px; margin-bottom: 12px; color: #d1d5db;"></i>
                                <p>Tidak ada data santri ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- Pagination --}}
    @if($santriList->hasPages())
        <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center; padding: 16px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <!-- Showing info -->
            <div style="font-size: 13px; color: #666;">
                Menampilkan <strong>{{ $santriList->firstItem() }}</strong> - <strong>{{ $santriList->lastItem() }}</strong> dari <strong>{{ $santriList->total() }}</strong> santri
            </div>
            
            <!-- Pagination buttons -->
            <div style="display: flex; gap: 8px; align-items: center;">
                {{-- Previous Button --}}
                @if ($santriList->onFirstPage())
                    <span style="padding: 8px 16px; background: #f5f5f5; color: #ccc; border-radius: 6px; font-size: 13px; cursor: not-allowed; display: inline-flex; align-items: center; gap: 6px;">
                        <i data-feather="chevron-left" style="width: 16px; height: 16px;"></i>
                        Previous
                    </span>
                @else
                    <a href="{{ $santriList->previousPageUrl() }}" style="padding: 8px 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 500; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(102,126,234,0.4)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
                        <i data-feather="chevron-left" style="width: 16px; height: 16px;"></i>
                        Previous
                    </a>
                @endif

                {{-- Page Numbers --}}
                <div style="display: flex; gap: 4px;">
                    @php
                        $start = max($santriList->currentPage() - 2, 1);
                        $end = min($start + 4, $santriList->lastPage());
                        $start = max($end - 4, 1);
                    @endphp

                    @if($start > 1)
                        <a href="{{ $santriList->url(1) }}" style="min-width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 500; background: #f5f5f5; color: #666; transition: all 0.2s;" onmouseover="this.style.background='#e0e0e0'" onmouseout="this.style.background='#f5f5f5'">
                            1
                        </a>
                        @if($start > 2)
                            <span style="min-width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; color: #999;">...</span>
                        @endif
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        @if ($i == $santriList->currentPage())
                            <span style="min-width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; font-size: 13px; font-weight: 600; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; box-shadow: 0 2px 8px rgba(102,126,234,0.3);">
                                {{ $i }}
                            </span>
                        @else
                            <a href="{{ $santriList->url($i) }}" style="min-width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 500; background: #f5f5f5; color: #666; transition: all 0.2s;" onmouseover="this.style.background='#e0e0e0'" onmouseout="this.style.background='#f5f5f5'">
                                {{ $i }}
                            </a>
                        @endif
                    @endfor

                    @if($end < $santriList->lastPage())
                        @if($end < $santriList->lastPage() - 1)
                            <span style="min-width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; color: #999;">...</span>
                        @endif
                        <a href="{{ $santriList->url($santriList->lastPage()) }}" style="min-width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 500; background: #f5f5f5; color: #666; transition: all 0.2s;" onmouseover="this.style.background='#e0e0e0'" onmouseout="this.style.background='#f5f5f5'">
                            {{ $santriList->lastPage() }}
                        </a>
                    @endif
                </div>

                {{-- Next Button --}}
                @if ($santriList->hasMorePages())
                    <a href="{{ $santriList->nextPageUrl() }}" style="padding: 8px 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 500; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(102,126,234,0.4)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
                        Next
                        <i data-feather="chevron-right" style="width: 16px; height: 16px;"></i>
                    </a>
                @else
                    <span style="padding: 8px 16px; background: #f5f5f5; color: #ccc; border-radius: 6px; font-size: 13px; cursor: not-allowed; display: inline-flex; align-items: center; gap: 6px;">
                        Next
                        <i data-feather="chevron-right" style="width: 16px; height: 16px;"></i>
                    </span>
                @endif
            </div>
        </div>
        
        <script>
            // Replace feather icons after pagination renders
            setTimeout(() => feather.replace(), 100);
        </script>
    @endif
</div>
@endsection
