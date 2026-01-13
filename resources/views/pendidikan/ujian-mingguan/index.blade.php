@extends('layouts.app')

@section('title', 'Ujian Mingguan')
@section('page-title', 'Ujian Mingguan')

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
    <div style="background: linear-gradient(135deg, #1e3a5f 0%, #0f2744 100%); border-radius: 10px; padding: 16px 24px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(30,58,95,0.25);">
        <!-- Title Row -->
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                    <i data-feather="calendar" style="width: 20px; height: 20px; color: white;"></i>
                </div>
                <div>
                    <h2 style="font-size: 1.1rem; font-weight: 700; color: white; margin: 0 0 2px 0;">Input Ujian Mingguan</h2>
                    <p style="color: rgba(255,255,255,0.85); font-size: 0.75rem; margin: 0;">Kelola nilai ujian mingguan santri (minimal 3 minggu untuk SAH)</p>
                </div>
            </div>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('pendidikan.ujian-mingguan') }}" id="filterForm">
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
                
                <!-- Mata Pelajaran -->
                <div style="display: flex; flex-direction: column; gap: 4px; min-width: 200px;">
                    <label style="font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.9); text-transform: uppercase; letter-spacing: 0.5px; margin: 0; display: flex; align-items: center; gap: 4px;">
                        <i data-feather="book" style="width: 11px; height: 11px;"></i>
                        Mata Pelajaran
                    </label>
                    <select name="mapel_id" id="mapel_id" required 
                        style="height: 38px; border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; padding: 0 12px; font-size: 13px; background: rgba(255,255,255,0.95); color: #1f2937; font-weight: 500; cursor: pointer;">
                        <option value="">-- Pilih Mapel --</option>
                        @foreach($mapelList as $mapel)
                            <option value="{{ $mapel->id }}" {{ request('mapel_id') == $mapel->id ? 'selected' : '' }}>
                                {{ $mapel->nama_mapel }}
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
                        style="height: 38px; padding: 0 20px; display: inline-flex; align-items: center; gap: 6px; background: white; color: #9c27b0; border: none; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 6px rgba(0,0,0,0.15);"
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
    @if(request()->filled(['kelas_id', 'mapel_id']) && $santriList->isNotEmpty())
        @php
            $kelas = \App\Models\Kelas::find(request('kelas_id'));
            $tahunAjaran = request('tahun_ajaran', $tahunAjaran);
            $semester = request('semester', '1');
        @endphp

        <!-- Header -->
        <div style="background: linear-gradient(135deg, #1e3a5f 0%, #0f2744 100%); color: white; padding: 16px; text-align: center; border-radius: 8px 8px 0 0; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
            <h3 style="margin: 0; font-size: 18px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: white;">
                UJIAN MINGGUAN - {{ $selectedMapel->nama_mapel }}
            </h3>
            <p style="margin: 4px 0 0 0; font-size: 13px; color: rgba(255,255,255,0.9);">
                Kelas {{ $kelas->nama_kelas }} - Semester {{ $semester == '1' ? 'Ganjil' : 'Genap' }} - {{ $tahunAjaran }}
            </p>
        </div>

        <!-- Table Form -->
        <form method="POST" action="{{ route('pendidikan.ujian-mingguan.store') }}" id="ujianForm">
            @csrf
            <input type="hidden" name="kelas_id" value="{{ request('kelas_id') }}">
            <input type="hidden" name="mapel_id" value="{{ request('mapel_id') }}">
            <input type="hidden" name="tahun_ajaran" value="{{ $tahunAjaran }}">
            <input type="hidden" name="semester" value="{{ $semester }}">
            
            <div style="background: white; border-radius: 0 0 8px 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                        <thead>
                            <tr style="background: linear-gradient(135deg, #43a047 0%, #2e7d32 100%); color: white;">
                                <th style="padding: 12px 8px; text-align: center; border: 1px solid rgba(255,255,255,0.2); min-width: 40px;">NO</th>
                                <th style="padding: 12px 8px; border: 1px solid rgba(255,255,255,0.2); min-width: 180px;">NAMA SANTRI</th>
                                <th style="padding: 12px 8px; text-align: center; border: 1px solid rgba(255,255,255,0.2); min-width: 80px;">MINGGU 1</th>
                                <th style="padding: 12px 8px; text-align: center; border: 1px solid rgba(255,255,255,0.2); min-width: 80px;">MINGGU 2</th>
                                <th style="padding: 12px 8px; text-align: center; border: 1px solid rgba(255,255,255,0.2); min-width: 80px;">MINGGU 3</th>
                                <th style="padding: 12px 8px; text-align: center; border: 1px solid rgba(255,255,255,0.2); min-width: 80px;">MINGGU 4</th>
                                <th style="padding: 12px 8px; text-align: center; border: 1px solid rgba(255,255,255,0.2); background: rgba(255,193,7,0.3); font-weight: 700;">KEIKUTSERTAAN</th>
                                <th style="padding: 12px 8px; text-align: center; border: 1px solid rgba(255,255,255,0.2); background: rgba(76,175,80,0.3); font-weight: 700;">STATUS</th>
                                <th style="padding: 12px 8px; text-align: center; border: 1px solid rgba(255,255,255,0.2); background: rgba(33,150,243,0.3); font-weight: 700;">NILAI HASIL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($santriList as $index => $santri)
                                @php
                                    $ujian = $santri->ujianMingguan->first();
                                @endphp
                                <tr style="background-color: {{ $index % 2 == 0 ? '#fff9e6' : '#fffbf0' }}; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#fff3cd'" onmouseout="this.style.backgroundColor='{{ $index % 2 == 0 ? '#fff9e6' : '#fffbf0' }}'">
                                    <td style="padding: 10px 8px; text-align: center; border: 1px solid #e0e0e0; font-weight: 600;">
                                        {{ $index + 1 }}
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #e0e0e0;">
                                        <input type="hidden" name="santri[{{ $index }}][id]" value="{{ $santri->id }}">
                                        <strong style="color: #2c3e50;">{{ $santri->nama_santri }}</strong>
                                    </td>
                                    @for($week = 1; $week <= 4; $week++)
                                        <td style="padding: 6px; text-align: center; border: 1px solid #e0e0e0;">
                                            <input type="number" 
                                                   name="santri[{{ $index }}][minggu_{{ $week }}]" 
                                                   class="week-input" 
                                                   data-row="{{ $index }}"
                                                   value="{{ $ujian ? $ujian->{'minggu_' . $week} : '' }}" 
                                                   min="0" 
                                                   max="100"
                                                   step="0.01"
                                                   placeholder="-"
                                                   @if(auth()->user()->role === 'rois') disabled style="width: 70px; padding: 6px; font-size: 13px; text-align: center; border: 2px solid #e0e0e0; border-radius: 4px; transition: all 0.2s; background-color: #f3f4f6; cursor: not-allowed;" @else style="width: 70px; padding: 6px; font-size: 13px; text-align: center; border: 2px solid #e0e0e0; border-radius: 4px; transition: all 0.2s;" @endif
                                                   onfocus="this.style.borderColor='#9c27b0'; this.style.boxShadow='0 0 0 3px rgba(156,39,176,0.1)'"
                                                   onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'">
                                        </td>
                                    @endfor
                                    <td style="padding: 10px 8px; text-align: center; border: 1px solid #e0e0e0; background-color: #fff8e1;">
                                        <strong id="keikutsertaan-{{ $index }}" style="font-size: 14px; color: #f57c00;">
                                            {{ $ujian ? $ujian->jumlah_keikutsertaan : 0 }}
                                        </strong>
                                    </td>
                                    <td style="padding: 10px 8px; text-align: center; border: 1px solid #e0e0e0; background-color: #e8f5e9;">
                                        <span id="status-{{ $index }}" class="status-badge" style="padding: 4px 12px; border-radius: 12px; font-size: 11px; font-weight: 600; {{ $ujian && $ujian->status == 'SAH' ? 'background: #4caf50; color: white;' : 'background: #f44336; color: white;' }}">
                                            {{ $ujian ? $ujian->status : 'TIDAK SAH' }}
                                        </span>
                                    </td>
                                    <td style="padding: 10px 8px; text-align: center; border: 1px solid #e0e0e0; background-color: #e3f2fd;">
                                        <strong id="nilai-hasil-{{ $index }}" style="font-size: 14px; color: #1976d2;">
                                            {{ $ujian && $ujian->nilai_hasil_mingguan !== null ? number_format((float)$ujian->nilai_hasil_mingguan, 2) : '-' }}
                                        </strong>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div style="padding: 20px; background: #f8f9fa; border-top: 2px solid #e0e0e0;">
                    @if(auth()->user()->role !== 'rois')
                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                        <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-size: 14px; background: linear-gradient(135deg, #9c27b0 0%, #7b1fa2 100%); border: none; border-radius: 6px; color: white; font-weight: 600; box-shadow: 0 4px 12px rgba(156,39,176,0.3);">
                            <i data-feather="save" style="width: 16px; height: 16px;"></i>
                            Simpan Data Ujian Mingguan
                        </button>
                        <button type="button" onclick="clearAll()" class="btn btn-secondary" style="padding: 10px 24px; font-size: 14px; background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%); border: none; border-radius: 6px; color: white; font-weight: 600;">
                            <i data-feather="x-circle" style="width: 16px; height: 16px;"></i>
                            Reset Semua
                        </button>
                    </div>
                    @else
                    <div style="padding: 12px; background: #e2e8f0; color: #475569; border-radius: 8px; font-weight: 600; text-align: center;">
                        Mode Baca Saja (Read-Only)
                    </div>
                    @endif
                    
                    <div style="margin-top: 16px; padding: 12px; background: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px;">
                        <p style="margin: 0; font-size: 12px; color: #856404;">
                            <strong>ℹ️ Informasi:</strong> Santri harus mengikuti minimal <strong>3 minggu ujian</strong> agar status menjadi <strong>SAH</strong>. Nilai hasil mingguan dihitung dari rata-rata minggu yang diikuti.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    @elseif(request()->filled(['kelas_id', 'mapel_id']))
        <div style="background: white; border-radius: 8px; padding: 60px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <i data-feather="alert-circle" style="width: 80px; height: 80px; color: #ff9800; margin-bottom: 20px;"></i>
            <p style="color: #777; font-size: 16px; margin: 0;">Tidak ada santri ditemukan untuk kelas dan filter yang dipilih</p>
        </div>
    @else
        <div style="background: white; border-radius: 8px; padding: 60px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <i data-feather="info" style="width: 80px; height: 80px; color: #bbb; margin-bottom: 20px;"></i>
            <p style="color: #777; font-size: 16px; margin: 0;">Silakan pilih kelas, mata pelajaran, tahun ajaran, dan semester untuk menampilkan data</p>
        </div>
    @endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeWeekInputs();
    
    // Replace feather icons
    setTimeout(() => feather.replace(), 100);
});

function initializeWeekInputs() {
    const weekInputs = document.querySelectorAll('.week-input');
    
    weekInputs.forEach(input => {
        input.addEventListener('input', function() {
            const row = this.dataset.row;
            calculateRowStats(row);
        });
    });

    // Trigger calculations on load for existing data
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach((row, index) => {
        calculateRowStats(index);
    });
}

function calculateRowStats(row) {
    const inputs = document.querySelectorAll(`input[data-row="${row}"]`);
    let count = 0;
    let total = 0;
    
    inputs.forEach(input => {
        const value = parseFloat(input.value);
        if (!isNaN(value) && input.value !== '') {
            count++;
            total += value;
        }
    });
    
    // Update keikutsertaan
    const keikutsertaanEl = document.getElementById(`keikutsertaan-${row}`);
    if (keikutsertaanEl) {
        keikutsertaanEl.textContent = count;
    }
    
    // Update status
    const statusEl = document.getElementById(`status-${row}`);
    if (statusEl) {
        if (count >= 3) {
            statusEl.textContent = 'SAH';
            statusEl.style.background = '#4caf50';
            statusEl.style.color = 'white';
        } else {
            statusEl.textContent = 'TIDAK SAH';
            statusEl.style.background = '#f44336';
            statusEl.style.color = 'white';
        }
    }
    
    // Update nilai hasil
    const nilaiHasilEl = document.getElementById(`nilai-hasil-${row}`);
    if (nilaiHasilEl) {
        if (count >= 3) {
            const avg = total / count;
            nilaiHasilEl.textContent = avg.toFixed(2);
        } else {
            nilaiHasilEl.textContent = '-';
        }
    }
}

function clearAll() {
    if (confirm('Yakin ingin menghapus semua input nilai ujian mingguan?')) {
        document.querySelectorAll('.week-input').forEach(input => input.value = '');
        document.querySelectorAll('[id^="keikutsertaan-"]').forEach(el => el.textContent = '0');
        document.querySelectorAll('[id^="status-"]').forEach(el => {
            el.textContent = 'TIDAK SAH';
            el.style.background = '#f44336';
            el.style.color = 'white';
        });
        document.querySelectorAll('[id^="nilai-hasil-"]').forEach(el => el.textContent = '-');
    }
}
</script>
@endpush
