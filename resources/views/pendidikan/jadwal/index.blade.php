@extends('layouts.app')

@section('title', 'Jadwal Pelajaran')
@section('page-title', 'Jadwal Pelajaran')

@section('sidebar-menu')
    @include('pendidikan.partials.sidebar-menu')
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 16px; border: 1px solid #c3e6cb; font-size: 13px;">
            ✓ {{ session('success') }}
        </div>
    @endif

    <!-- Compact Gradient Header -->
    <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 10px; padding: 16px 24px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(59,130,246,0.25);">
        <div style="display: flex; align-items: center; gap: 10px;">
            <div style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                <i data-feather="calendar" style="width: 20px; height: 20px; color: white;"></i>
            </div>
            <div>
                <h2 style="font-size: 1.1rem; font-weight: 700; color: white; margin: 0 0 2px 0;">Jadwal Pelajaran</h2>
                <p style="color: rgba(255,255,255,0.85); font-size: 0.75rem; margin: 0;">Kelola jadwal pelajaran per kelas</p>
            </div>
        </div>
    </div>


    @if(auth()->user()->role !== 'rois')
    <!-- Add Form with Modern Compact Design -->
    <div style="background: white; border-radius: 10px; padding: 20px 24px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid rgba(59,130,246,0.1);">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
            <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <i data-feather="plus-circle" style="width: 18px; height: 18px; color: white;"></i>
            </div>
            <h3 style="font-size: 16px; font-weight: 600; margin: 0; color: #1f2937;">Tambah Jadwal Baru</h3>
        </div>
        
        <form method="POST" action="{{ route('pendidikan.jadwal.store') }}">
            @csrf
            <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: end;">
                <!-- Kelas -->
                <div style="min-width: 140px; flex: 1;">
                    <label style="font-size: 11px; margin-bottom: 4px; display: block; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.3px;">Kelas</label>
                    <select name="kelas_id" class="form-select" required 
                        style="height: 36px; padding: 0 10px; font-size: 13px; border: 1.5px solid #e5e7eb; border-radius: 6px; background: #f9fafb; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#3b82f6'; this.style.background='white';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb';">
                        <option value="">Pilih Kelas</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Mata Pelajaran -->
                <div style="min-width: 160px; flex: 1.2;">
                    <label style="font-size: 11px; margin-bottom: 4px; display: block; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.3px;">Mata Pelajaran</label>
                    <select name="mapel_id" class="form-select" required 
                        style="height: 36px; padding: 0 10px; font-size: 13px; border: 1.5px solid #e5e7eb; border-radius: 6px; background: #f9fafb; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#3b82f6'; this.style.background='white';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb';">
                        <option value="">Pilih Mapel</option>
                        @foreach($mapelList as $mapel)
                            <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Hari -->
                <div style="min-width: 100px;">
                    <label style="font-size: 11px; margin-bottom: 4px; display: block; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.3px;">Hari</label>
                    <select name="hari" class="form-select" required 
                        style="height: 36px; padding: 0 10px; font-size: 13px; border: 1.5px solid #e5e7eb; border-radius: 6px; background: #f9fafb; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#3b82f6'; this.style.background='white';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb';">
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                    </select>
                </div>
                
                <!-- Jam Mulai -->
                <div style="min-width: 85px;">
                    <label style="font-size: 11px; margin-bottom: 4px; display: block; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.3px;">Jam Mulai</label>
                    <input type="text" name="jam_mulai" class="form-input" placeholder="07:00" pattern="[0-9]{2}:[0-9]{2}" required 
                        style="height: 36px; padding: 0 10px; font-size: 13px; border: 1.5px solid #e5e7eb; border-radius: 6px; background: #f9fafb; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#3b82f6'; this.style.background='white';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb';">
                </div>
                
                <!-- Jam Selesai -->
                <div style="min-width: 85px;">
                    <label style="font-size: 11px; margin-bottom: 4px; display: block; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.3px;">Jam Selesai</label>
                    <input type="text" name="jam_selesai" class="form-input" placeholder="08:00" pattern="[0-9]{2}:[0-9]{2}" required 
                        style="height: 36px; padding: 0 10px; font-size: 13px; border: 1.5px solid #e5e7eb; border-radius: 6px; background: #f9fafb; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#3b82f6'; this.style.background='white';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb';">
                </div>
                
                <!-- Ruangan -->
                <div style="min-width: 95px;">
                    <label style="font-size: 11px; margin-bottom: 4px; display: block; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.3px;">Ruangan</label>
                    <input type="text" name="ruangan" class="form-input" placeholder="Ruang A" 
                        style="height: 36px; padding: 0 10px; font-size: 13px; border: 1.5px solid #e5e7eb; border-radius: 6px; background: #f9fafb; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#3b82f6'; this.style.background='white';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb';">
                </div>
                
                <!-- Tahun Ajaran -->
                <div style="min-width: 105px;">
                    <label style="font-size: 11px; margin-bottom: 4px; display: block; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.3px;">Tahun Ajaran</label>
                    <select name="tahun_ajaran" class="form-select" required 
                        style="height: 36px; padding: 0 10px; font-size: 13px; border: 1.5px solid #e5e7eb; border-radius: 6px; background: #f9fafb; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#3b82f6'; this.style.background='white';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb';">
                        @foreach($tahunAjaranList as $ta)
                            <option value="{{ $ta }}" {{ $ta == '2024/2025' ? 'selected' : '' }}>{{ $ta }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Semester -->
                <div style="min-width: 85px;">
                    <label style="font-size: 11px; margin-bottom: 4px; display: block; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.3px;">Semester</label>
                    <select name="semester" class="form-select" required 
                        style="height: 36px; padding: 0 10px; font-size: 13px; border: 1.5px solid #e5e7eb; border-radius: 6px; background: #f9fafb; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#3b82f6'; this.style.background='white';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb';">
                        <option value="1">Sem 1</option>
                        <option value="2">Sem 2</option>
                    </select>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" 
                    style="height: 36px; padding: 0 20px; display: inline-flex; align-items: center; gap: 6px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 6px rgba(59,130,246,0.3);"
                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 10px rgba(59,130,246,0.4)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 6px rgba(59,130,246,0.3)';">
                    <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                    Tambah Jadwal
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Jadwal Table -->
    <!-- Jadwal Table Grouped by Kelas -->
    @php
        $groupedJadwal = $jadwal->groupBy(function($item) {
            return $item->kelas->nama_kelas ?? 'Tanpa Kelas';
        });
    @endphp

    @forelse($groupedJadwal as $namaKelas => $items)
        @php $kelas = $items->first()->kelas; @endphp
        <div style="background: white; border-radius: 10px; padding: 0; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid rgba(59,130,246,0.1); overflow: hidden;">
            <div style="padding: 14px 20px; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-bottom: 2px solid #3b82f6;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <h3 style="font-size: 15px; font-weight: 600; margin: 0; color: #1e40af; display: flex; align-items: center; gap: 8px;">
                        <i data-feather="users" style="width: 16px; height: 16px;"></i>
                        {{ $namaKelas }}
                    </h3>
                    <span style="padding: 4px 12px; background: #3b82f6; color: white; border-radius: 12px; font-size: 11px; font-weight: 600;">{{ $items->count() }} Jadwal</span>
                </div>
                <!-- Dual Wali Kelas Inputs -->
                <div style="display: flex; gap: 20px; margin-top: 12px; flex-wrap: wrap;">
                    @if(auth()->user()->role !== 'rois')
                    <!-- Wali Kelas Putra -->
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span style="font-weight: 500; color: #1e40af; font-size: 12px;">👨 Wali Putra:</span>
                        <input type="text" 
                            id="wali-putra-{{ $kelas->id }}" 
                            value="{{ $kelas->wali_kelas_putra ?? '' }}" 
                            placeholder="Nama wali kelas putra"
                            style="height: 28px; padding: 0 8px; font-size: 12px; border: 1.5px solid #e5e7eb; border-radius: 4px; background: white; transition: all 0.2s; min-width: 140px;"
                            onfocus="this.style.borderColor='#3b82f6'; this.style.background='#f0f9ff';"
                            onblur="this.style.borderColor='#e5e7eb'; this.style.background='white';">
                    </div>
                    <!-- Wali Kelas Putri -->
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span style="font-weight: 500; color: #db2777; font-size: 12px;">👩 Wali Putri:</span>
                        <input type="text" 
                            id="wali-putri-{{ $kelas->id }}" 
                            value="{{ $kelas->wali_kelas_putri ?? '' }}" 
                            placeholder="Nama wali kelas putri"
                            style="height: 28px; padding: 0 8px; font-size: 12px; border: 1.5px solid #e5e7eb; border-radius: 4px; background: white; transition: all 0.2s; min-width: 140px;"
                            onfocus="this.style.borderColor='#db2777'; this.style.background='#fdf2f8';"
                            onblur="this.style.borderColor='#e5e7eb'; this.style.background='white';">
                    </div>
                    <button onclick="updateWaliKelasDual({{ $kelas->id }})" 
                        style="height: 28px; padding: 0 14px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; border-radius: 4px; font-size: 11px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 4px;"
                        onmouseover="this.style.transform='scale(1.05)';"
                        onmouseout="this.style.transform='scale(1)';">
                        <i data-feather="save" style="width: 11px; height: 11px;"></i>
                        Simpan Wali Kelas
                    </button>
                    @else
                    <!-- Read Only Wali Kelas -->
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span style="font-weight: 500; color: #1e40af; font-size: 12px;">👨 Wali Putra:</span>
                            <span style="font-size: 12px; color: #4b5563;">{{ $kelas->wali_kelas_putra ?? '-' }}</span>
                        </div>
                        <div style="width: 1px; height: 16px; background: #cbd5e1;"></div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span style="font-weight: 500; color: #db2777; font-size: 12px;">👩 Wali Putri:</span>
                            <span style="font-size: 12px; color: #4b5563;">{{ $kelas->wali_kelas_putri ?? '-' }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div style="overflow-x: auto;">
                <table class="table" style="font-size: 12px; margin: 0; width: 100%; border-collapse: separate; border-spacing: 0;">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white;">
                            <th style="padding: 12px 10px; text-align: left; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Hari</th>
                            <th style="padding: 12px 10px; text-align: left; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Mulai</th>
                            <th style="padding: 12px 10px; text-align: left; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Selesai</th>
                            <th style="padding: 12px 10px; text-align: left; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Mata Pelajaran</th>
                            <th style="padding: 12px 10px; text-align: left; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Guru</th>
                            <th style="padding: 12px 10px; text-align: left; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Guru Badal</th>
                            <th style="padding: 12px 10px; text-align: left; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Ruangan</th>
                            <th style="padding: 12px 10px; text-align: left; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Tahun Ajaran</th>
                            <th style="padding: 12px 10px; text-align: center; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Sem</th>
                            <th style="padding: 12px 10px; text-align: center; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Group items by day and sort by jam_mulai
                            $hariOrder = ['Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6];
                            $groupedByHari = $items->groupBy('hari')->sortBy(fn($g, $h) => $hariOrder[$h] ?? 99);
                            
                            $hariColors = [
                                'Senin' => 'background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);',
                                'Selasa' => 'background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);',
                                'Rabu' => 'background: linear-gradient(135deg, #10b981 0%, #059669 100%);',
                                'Kamis' => 'background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);',
                                'Jumat' => 'background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);',
                                'Sabtu' => 'background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);',
                            ];
                        @endphp
                        
                        @foreach($groupedByHari as $hari => $jadwalPerHari)
                            @php $sortedJadwal = $jadwalPerHari->sortBy('jam_mulai'); @endphp
                            @foreach($sortedJadwal as $idx => $j)
                                <tr style="border-bottom: 1px solid #f0f0f0; transition: all 0.2s;"
                                    onmouseover="this.style.background='#f9fafb';"
                                    onmouseout="this.style.background='white';">
                                    @if($idx === 0)
                                        <td rowspan="{{ $jadwalPerHari->count() }}" style="padding: 10px; vertical-align: middle; background: #fafafa; border-right: 2px solid #e5e7eb;">
                                            <span style="display: inline-block; padding: 6px 14px; {{ $hariColors[$hari] ?? 'background: #6b7280;' }} color: white; border-radius: 8px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">{{ $hari }}</span>
                                        </td>
                                    @endif
                                    <td style="padding: 10px; color: #6b7280; font-weight: 500;">{{ substr($j->jam_mulai, 0, 5) }}</td>
                                    <td style="padding: 10px; color: #6b7280; font-weight: 500;">{{ substr($j->jam_selesai, 0, 5) }}</td>
                                    <td style="padding: 10px; color: #1f2937; font-weight: 500;">{{ $j->mapel->nama_mapel ?? '-' }}</td>
                                    <td style="padding: 10px; color: #6b7280;">{{ $j->mapel->guru_pengampu ?? '-' }}</td>
                                    <td style="padding: 10px; color: #6b7280;">{{ $j->guru_badal ?? '-' }}</td>
                                    <td style="padding: 10px; color: #6b7280;">{{ $j->ruangan ?? '-' }}</td>
                                    <td style="padding: 10px; color: #6b7280; font-size: 11px;">{{ $j->tahun_ajaran }}</td>
                                    <td style="padding: 10px; text-align: center;">
                                        <span style="display: inline-block; padding: 4px 8px; background: #e0f2fe; color: #0369a1; border-radius: 12px; font-size: 11px; font-weight: 600;">{{ $j->semester }}</span>
                                    </td>
                                    <td style="padding: 10px; text-align: center;">
                                        @if(auth()->user()->role !== 'rois')
                                        <div style="display: flex; gap: 4px; justify-content: center;">
                                            <button type="button" onclick="editJadwal({{ $j->id }}, {{ $j->kelas_id }}, {{ $j->mapel_id }}, '{{ $j->hari }}', '{{ $j->jam_mulai }}', '{{ $j->jam_selesai }}', '{{ $j->ruangan }}', '{{ $j->tahun_ajaran }}', {{ $j->semester }}, '{{ $j->guru_badal }}')" 
                                                style="padding: 6px 10px; background: white; color: #3b82f6; border: 1.5px solid #3b82f6; border-radius: 4px; font-size: 11px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 4px;"
                                                onmouseover="this.style.background='#3b82f6'; this.style.color='white';"
                                                onmouseout="this.style.background='white'; this.style.color='#3b82f6';">
                                                <i data-feather="edit-2" style="width: 12px; height: 12px;"></i>
                                                Edit
                                            </button>
                                            <form method="POST" action="{{ route('pendidikan.jadwal.destroy', $j->id) }}" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    style="padding: 6px 10px; background: white; color: #ef4444; border: 1.5px solid #ef4444; border-radius: 4px; font-size: 11px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 4px;"
                                                    onmouseover="this.style.background='#ef4444'; this.style.color='white';"
                                                    onmouseout="this.style.background='white'; this.style.color='#ef4444';">
                                                    <i data-feather="trash-2" style="width: 12px; height: 12px;"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                        @else
                                        <span class="badge bg-secondary" style="font-size: 10px; padding: 4px 8px; color: #64748b; background: #f1f5f9; border-radius: 4px;">Read-Only</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="card" style="padding: 32px; text-align: center; color: #999;">
            <i data-feather="calendar" style="width: 48px; height: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
            <p>Belum ada jadwal pelajaran yang ditambahkan</p>
        </div>
    @endforelse

    @empty
        <div class="card" style="padding: 32px; text-align: center; color: #999;">
            <i data-feather="calendar" style="width: 48px; height: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
            <p>Belum ada jadwal pelajaran yang ditambahkan</p>
        </div>
    @endforelse

@endsection

@endsection

<!-- Edit Jadwal Modal -->
<div id="editJadwalModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div class="card" style="width: 100%; max-width: 500px; margin: 20px; max-height: 90vh; overflow-y: auto;">
        <h3 class="card-header">Edit Jadwal</h3>
        <form id="editJadwalForm" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div class="form-group">
                    <label class="form-label">Kelas</label>
                    <select name="kelas_id" id="editKelas" class="form-select" required>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Mata Pelajaran</label>
                    <select name="mapel_id" id="editMapel" class="form-select" required>
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-group">
                    <label class="form-label">Hari</label>
                    <select name="hari" id="editHari" class="form-select" required>
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $h)
                            <option value="{{ $h }}">{{ $h }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Ruangan</label>
                    <input type="text" name="ruangan" id="editRuangan" class="form-input">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Guru Badal</label>
                <input type="text" name="guru_badal" id="editGuruBadal" class="form-input" placeholder="Nama guru badal (opsional)">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-group">
                    <label class="form-label">Jam Mulai <small style="color: #666; font-weight: normal;">(Format 07:00)</small></label>
                    <input type="text" name="jam_mulai" id="editJamMulai" class="form-input" placeholder="07:00" pattern="[0-9]{2}:[0-9]{2}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jam Selesai <small style="color: #666; font-weight: normal;">(Format 08:30)</small></label>
                    <input type="text" name="jam_selesai" id="editJamSelesai" class="form-input" placeholder="08:30" pattern="[0-9]{2}:[0-9]{2}" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-group">
                    <label class="form-label">Tahun Ajaran</label>
                    <input type="text" name="tahun_ajaran" id="editTahunAjaran" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Semester</label>
                    <select name="semester" id="editSemester" class="form-select" required>
                        <option value="1">Ganjil</option>
                        <option value="2">Genap</option>
                    </select>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 8px; margin-top: 16px;">
                <button type="button" onclick="closeEditModal()" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function editJadwal(id, kelasId, mapelId, hari, jamMulai, jamSelesai, ruangan, tahunAjaran, semester, guruBadal = '') {
    const modal = document.getElementById('editJadwalModal');
    const form = document.getElementById('editJadwalForm');
    
    // Set form action
    form.action = `/pendidikan/jadwal/${id}`;
    
    // Set values
    document.getElementById('editKelas').value = kelasId;
    document.getElementById('editMapel').value = mapelId;
    document.getElementById('editHari').value = hari;
    document.getElementById('editJamMulai').value = jamMulai.substring(0, 5);
    document.getElementById('editJamSelesai').value = jamSelesai.substring(0, 5);
    document.getElementById('editRuangan').value = ruangan;
    document.getElementById('editGuruBadal').value = guruBadal || '';
    document.getElementById('editTahunAjaran').value = tahunAjaran;
    document.getElementById('editSemester').value = semester;
    
    // Show modal
    modal.style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editJadwalModal').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('editJadwalModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

// Update Guru Badal for Jadwal
function updateGuruBadalJadwal(id) {
    const input = document.getElementById('guru-badal-jadwal-' + id);
    const guruBadal = input.value;
    
    fetch(`/pendidikan/jadwal/${id}/update-guru-badal`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ guru_badal: guruBadal })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success feedback
            input.style.borderColor = '#3b82f6';
            input.style.background = '#dbeafe';
            setTimeout(() => {
                input.style.borderColor = '#e5e7eb';
                input.style.background = '#f9fafb';
            }, 1500);
        } else {
            alert('Gagal menyimpan guru badal');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan');
    });
}

// Update Wali Kelas (Legacy - single mode)
function updateWaliKelas(kelasId) {
    const input = document.getElementById('wali-kelas-' + kelasId);
    const waliKelas = input.value;
    
    fetch(`/pendidikan/kelas/${kelasId}/update-wali-kelas`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ wali_kelas: waliKelas })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            input.style.borderColor = '#3b82f6';
            input.style.background = '#dbeafe';
            setTimeout(() => {
                input.style.borderColor = '#e5e7eb';
                input.style.background = 'white';
            }, 1500);
        } else {
            alert('Gagal menyimpan wali kelas');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan');
    });
}

// Update Wali Kelas DUAL (Putra & Putri)
function updateWaliKelasDual(kelasId) {
    const inputPutra = document.getElementById('wali-putra-' + kelasId);
    const inputPutri = document.getElementById('wali-putri-' + kelasId);
    const waliPutra = inputPutra.value;
    const waliPutri = inputPutri.value;
    
    fetch(`/pendidikan/kelas/${kelasId}/update-wali-kelas-dual`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ 
            wali_kelas_putra: waliPutra,
            wali_kelas_putri: waliPutri
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success feedback on both inputs
            inputPutra.style.borderColor = '#10b981';
            inputPutra.style.background = '#d1fae5';
            inputPutri.style.borderColor = '#10b981';
            inputPutri.style.background = '#d1fae5';
            setTimeout(() => {
                inputPutra.style.borderColor = '#e5e7eb';
                inputPutra.style.background = 'white';
                inputPutri.style.borderColor = '#e5e7eb';
                inputPutri.style.background = 'white';
            }, 1500);
        } else {
            alert('Gagal menyimpan wali kelas: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan');
    });
}

function toggleKitabEdit(kelasId, semester) {
    const row = document.getElementById(`kitab-row-${kelasId}-${semester}`);
    const editRow = document.getElementById(`kitab-edit-${kelasId}-${semester}`);
    
    if (editRow.style.display === 'none') {
        editRow.style.display = 'table-row';
        row.style.backgroundColor = '#f5f5f5';
    } else {
        editRow.style.display = 'none';
        row.style.backgroundColor = '';
    }
    
    feather.replace();
}

// Global Kitab Edit Toggle (unused now, kept for compatibility)
function toggleKitabEditGlobal(semester) {
    const row = document.getElementById(`kitab-row-global-${semester}`);
    const editRow = document.getElementById(`kitab-edit-global-${semester}`);
    
    if (editRow && row) {
        if (editRow.style.display === 'none') {
            editRow.style.display = 'table-row';
            row.style.backgroundColor = '#f5f5f5';
        } else {
            editRow.style.display = 'none';
            row.style.backgroundColor = '';
        }
    }
    
    feather.replace();
}

// Kitab Modal Functions
function showKitabModal(kelasId, semester, currentValue) {
    // Set hidden fields
    document.getElementById('kitabKelasId').value = kelasId;
    document.getElementById('kitabSemester').value = semester;
    document.getElementById('kitabNamaInput').value = currentValue || '';
    
    // Set semester label
    const semesterName = semester == 1 ? 'Ganjil' : 'Genap';
    const semesterColor = semester == 1 ? '#2196f3' : '#ff9800';
    const labelEl = document.getElementById('kitabSemesterLabel');
    labelEl.textContent = 'Semester ' + semester + ' (' + semesterName + ')';
    labelEl.style.backgroundColor = semesterColor;
    
    // Show modal
    const modal = document.getElementById('kitabModal');
    modal.style.display = 'flex';
    
    // Focus input
    setTimeout(() => {
        document.getElementById('kitabNamaInput').focus();
    }, 100);
    
    feather.replace();
}

function closeKitabModal() {
    document.getElementById('kitabModal').style.display = 'none';
}

// Form submit handler
document.getElementById('kitabForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const kelasId = document.getElementById('kitabKelasId').value;
    const semester = document.getElementById('kitabSemester').value;
    const namaKitab = document.getElementById('kitabNamaInput').value;
    
    if (namaKitab.trim() === '') {
        alert('Nama kitab tidak boleh kosong');
        return;
    }
    
    saveKitab(kelasId, semester, namaKitab);
});

function saveKitab(kelasId, semester, namaKitab) {
    fetch('/pendidikan/jadwal/kitab/' + kelasId, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            kelas_id: kelasId,
            semester: semester,
            nama_kitab: namaKitab
        })
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        // Update DOM directly without reloading
        const displaySpan = document.getElementById('kitab-display-' + kelasId + '-' + semester);
        if (displaySpan) {
            displaySpan.textContent = namaKitab;
            displaySpan.style.color = '#2c3e50';
            displaySpan.style.fontWeight = '600';
        }
        closeKitabModal();
        
        // Show success toast
        showToast('Kitab berhasil disimpan!', 'success');
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal menyimpan kitab. Silakan coba lagi.');
    });
}

function deleteKitab(kelasId) {
    if (!confirm('Yakin ingin menghapus kitab untuk kelas ini di kedua semester?')) {
        return;
    }
    
    // Delete both semester entries
    fetch('/pendidikan/jadwal/kitab/delete-by-kelas/' + kelasId, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        // Update DOM directly without reloading
        const display1 = document.getElementById('kitab-display-' + kelasId + '-1');
        const display2 = document.getElementById('kitab-display-' + kelasId + '-2');
        if (display1) {
            display1.textContent = '-';
            display1.style.color = '#999';
            display1.style.fontWeight = 'normal';
        }
        if (display2) {
            display2.textContent = '-';
            display2.style.color = '#999';
            display2.style.fontWeight = 'normal';
        }
        
        // Show success toast
        showToast('Kitab berhasil dihapus!', 'success');
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal menghapus kitab. Silakan coba lagi.');
    });
}

// Simple toast notification
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 12px 24px;
        background: ${type === 'success' ? '#10b981' : '#ef4444'};
        color: white;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 9999;
        transition: opacity 0.3s;
    `;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>
@endpush
