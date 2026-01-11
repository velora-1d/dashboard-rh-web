@extends('layouts.app')

@section('title', 'Hafalan Santri')

@section('sidebar-menu')
    @include('pendidikan.partials.sidebar-menu')
@endsection

@section('content')
<div class="container-fluid">
    
    @if(session('success'))
    <div class="alert alert-success" style="background-color: var(--color-primary-lightest); color: var(--color-primary-dark); padding: var(--spacing-md); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg); border: 1px solid var(--color-primary-light);">
        {{ session('success') }}
    </div>
    @endif

    <!-- Compact Gradient Header with Inline Actions -->
    <div style="background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%); border-radius: 10px; padding: 16px 24px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(76,175,80,0.25);">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                    <i class="fas fa-quran" style="font-size: 20px; color: white;"></i>
                </div>
                <div>
                    <h2 style="font-size: 1.1rem; font-weight: 700; color: white; margin: 0 0 2px 0;">Hafalan Santri</h2>
                    <p style="color: rgba(255,255,255,0.85); font-size: 0.75rem; margin: 0;">Kelola data setoran hafalan Qur'an dan Kitab</p>
                </div>
            </div>
            
            <a href="{{ route('pendidikan.hafalan.create') }}" 
               style="background: white; color: #4caf50; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: all 0.2s;"
               onmouseover="this.style.background='#f0fdf4'; this.style.transform='translateY(-1px)';"
               onmouseout="this.style.background='white'; this.style.transform='translateY(0)';">
                <i class="fas fa-plus"></i> Tambah Hafalan
            </a>
        </div>
        
        <!-- Modern Filter Section -->
        <div style="margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 16px;">
            <form method="GET" action="{{ route('pendidikan.hafalan.index') }}" style="display: flex; align-items: end; gap: 12px; flex-wrap: wrap;">
                <!-- Search -->
                <div style="flex: 1; min-width: 200px;">
                    <label style="font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.9); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; display: block;">Cari Santri</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama / NIS..." 
                        style="width: 100%; height: 38px; border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; padding: 0 12px; font-size: 13px; background: rgba(255,255,255,0.95); color: #1f2937;">
                </div>
                
                <!-- Jenis -->
                <div style="min-width: 140px;">
                    <label style="font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.9); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; display: block;">Jenis Hafalan</label>
                    <select name="jenis" style="width: 100%; height: 38px; border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; padding: 0 12px; font-size: 13px; background: rgba(255,255,255,0.95); color: #1f2937; cursor: pointer;">
                        <option value="">Semua Jenis</option>
                        <option value="Quran" {{ request('jenis') == 'Quran' ? 'selected' : '' }}>Al-Qur'an</option>
                        <option value="Kitab" {{ request('jenis') == 'Kitab' ? 'selected' : '' }}>Kitab</option>
                    </select>
                </div>
                
                <!-- Tanggal Range -->
                <div style="min-width: 140px;">
                    <label style="font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.9); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; display: block;">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" 
                        style="width: 100%; height: 38px; border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; padding: 0 12px; font-size: 13px; background: rgba(255,255,255,0.95); color: #1f2937;">
                </div>
                <div style="min-width: 140px;">
                    <label style="font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.9); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; display: block;">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" 
                        style="width: 100%; height: 38px; border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; padding: 0 12px; font-size: 13px; background: rgba(255,255,255,0.95); color: #1f2937;">
                </div>
                
                <!-- Buttons -->
                <div style="display: flex; gap: 8px;">
                    <button type="submit" style="height: 38px; padding: 0 16px; background: #2e7d32; color: white; border: none; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('pendidikan.hafalan.index') }}" style="height: 38px; padding: 0 16px; background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer; display: flex; align-items: center; gap: 6px; text-decoration: none;">
                        <i class="fas fa-sync"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Table Card -->
    <div style="background: white; border-radius: 10px; padding: 20px; margin-bottom: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid rgba(76,175,80,0.1);">
        <h3 style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-list text-primary"></i> Data Riwayat Hafalan
        </h3>
        
        <div class="table-responsive">
            <table class="table" style="font-size: 13px; width: 100%; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr style="background: #f8fafc; color: #475569;">
                        <th style="padding: 12px 16px; border-bottom: 2px solid #e2e8f0; font-weight: 600; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px;">Tanggal</th>
                        <th style="padding: 12px 16px; border-bottom: 2px solid #e2e8f0; font-weight: 600; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px;">Nama Santri</th>
                        <th style="padding: 12px 16px; border-bottom: 2px solid #e2e8f0; font-weight: 600; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px;">Jenis</th>
                        <th style="padding: 12px 16px; border-bottom: 2px solid #e2e8f0; font-weight: 600; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px;">Hafalan</th>
                        <th style="padding: 12px 16px; border-bottom: 2px solid #e2e8f0; font-weight: 600; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px;">Progress</th>
                        <th style="padding: 12px 16px; border-bottom: 2px solid #e2e8f0; font-weight: 600; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px;">Nilai</th>
                        <th style="padding: 12px 16px; border-bottom: 2px solid #e2e8f0; font-weight: 600; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hafalan as $item)
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                        <td style="padding: 12px 16px; color: #64748b;">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                        <td style="padding: 12px 16px; font-weight: 600; color: #334155;">{{ $item->santri->nama_santri ?? '-' }}</td>
                        <td style="padding: 12px 16px;">
                            @if($item->jenis == 'Quran')
                                <span style="display: inline-block; padding: 4px 10px; background: #dbf4ff; color: #007bff; border-radius: 20px; font-size: 11px; font-weight: 600;">Al-Qur'an</span>
                            @else
                                <span style="display: inline-block; padding: 4px 10px; background: #fff3cd; color: #856404; border-radius: 20px; font-size: 11px; font-weight: 600;">Kitab</span>
                            @endif
                        </td>
                        <td style="padding: 12px 16px; color: #334155;">{{ $item->nama_hafalan }}</td>
                        <td style="padding: 12px 16px; color: #64748b;">{{ $item->progress }}</td>
                        <td style="padding: 12px 16px;">
                            @if($item->nilai)
                                <span style="font-weight: 700; color: {{ $item->nilai >= 70 ? '#10b981' : '#f59e0b' }};">{{ $item->nilai }}</span>
                            @else
                                <span style="color: #94a3b8;">-</span>
                            @endif
                        </td>
                        <td style="padding: 12px 16px;">
                            <div style="display: flex; gap: 6px;">
                                <a href="{{ route('pendidikan.hafalan.edit', $item->id) }}" 
                                   style="padding: 6px 10px; background: #fff; border: 1px solid #e2e8f0; color: #f59e0b; border-radius: 6px; transition: all 0.2s;"
                                   onmouseover="this.style.background='#fef3c7'; this.style.borderColor='#f59e0b';"
                                   onmouseout="this.style.background='#fff'; this.style.borderColor='#e2e8f0';">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('pendidikan.hafalan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        style="padding: 6px 10px; background: #fff; border: 1px solid #e2e8f0; color: #ef4444; border-radius: 6px; transition: all 0.2s;"
                                        onmouseover="this.style.background='#fee2e2'; this.style.borderColor='#ef4444';"
                                        onmouseout="this.style.background='#fff'; this.style.borderColor='#e2e8f0';">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data hafalan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $hafalan->links() }}
        </div>
    </div>

    <!-- Konfigurasi Kitab Talaran Section -->
    <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid rgba(76,175,80,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px;">
            <div>
                <h3 style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 4px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-book text-primary"></i> Konfigurasi Kitab Talaran per Kelas
                </h3>
                <p style="color: #64748b; font-size: 0.85rem; margin: 0;">Atur kitab yang dipelajari untuk setiap kelas (Semester Ganjil & Genap)</p>
            </div>
            <div style="background: #e0f2fe; color: #0369a1; padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                Otomatisasi Input Tersedia
            </div>
        </div>
            
        <div class="table-responsive">
            <table class="table table-bordered border-0" style="font-size: 13px; width: 100%;">
                <thead>
                    <tr style="background: linear-gradient(135deg, #1f2937 0%, #111827 100%); color: white;">
                        <th rowspan="2" class="text-center align-middle" style="width: 50px; border: none; border-top-left-radius: 8px;">No</th>
                        <th rowspan="2" class="align-middle" style="border: none;">Kelas</th>
                        <th colspan="2" class="text-center" style="background: rgba(255,255,255,0.1); border: none;">Semester Ganjil</th>
                        <th colspan="2" class="text-center" style="background: rgba(255,255,255,0.05); border: none;">Semester Genap</th>
                        <th rowspan="2" class="text-center align-middle" style="width: 100px; border: none; border-top-right-radius: 8px;">Aksi</th>
                    </tr>
                    <tr style="background: #374151; color: #e5e7eb;">
                        <th style="border: none;">Kitab</th>
                        <th class="text-center" style="width: 60px; border: none;">Edit</th>
                        <th style="border: none;">Kitab</th>
                        <th class="text-center" style="width: 60px; border: none;">Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach($kelasList as $kelas)
                        @php
                            $kitabSem1 = \App\Models\KitabTalaran::where('kelas_id', $kelas->id)->where('semester', 1)->first();
                            $kitabSem2 = \App\Models\KitabTalaran::where('kelas_id', $kelas->id)->where('semester', 2)->first();
                            $kitabName1 = $kitabSem1->nama_kitab ?? '-';
                            $kitabName2 = $kitabSem2->nama_kitab ?? '-';
                        @endphp
                        <tr id="kitab-row-{{ $kelas->id }}" style="border-bottom: 1px solid #f3f4f6;">
                            <td class="text-center" style="padding: 12px;">{{ $no++ }}</td>
                            <td class="font-weight-bold" style="color: #4b5563; padding: 12px;">{{ $kelas->nama_kelas }}</td>
                            
                            <!-- Semester Ganjil -->
                            <td style="padding: 12px;">
                                <span id="kitab-display-{{ $kelas->id }}-1" class="{{ $kitabName1 == '-' ? 'text-muted' : 'font-weight-bold text-success' }}">
                                    {{ $kitabName1 }}
                                </span>
                            </td>
                            <td class="text-center" style="padding: 12px;">
                                <button onclick="showKitabModal({{ $kelas->id }}, 1, '{{ addslashes($kitabName1 != '-' ? $kitabName1 : '') }}')" 
                                        style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; width: 28px; height: 28px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer;">
                                    <i class="fas fa-pencil-alt" style="font-size: 12px;"></i>
                                </button>
                            </td>
                            
                            <!-- Semester Genap -->
                            <td style="padding: 12px;">
                                <span id="kitab-display-{{ $kelas->id }}-2" class="{{ $kitabName2 == '-' ? 'text-muted' : 'font-weight-bold text-warning' }}">
                                    {{ $kitabName2 }}
                                </span>
                            </td>
                            <td class="text-center" style="padding: 12px;">
                                <button onclick="showKitabModal({{ $kelas->id }}, 2, '{{ addslashes($kitabName2 != '-' ? $kitabName2 : '') }}')" 
                                        style="background: #fffbeb; border: 1px solid #fde68a; color: #d97706; width: 28px; height: 28px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer;">
                                    <i class="fas fa-pencil-alt" style="font-size: 12px;"></i>
                                </button>
                            </td>
                            
                            <!-- Aksi Hapus -->
                            <td class="text-center" style="padding: 12px;">
                                <button onclick="deleteKitab({{ $kelas->id }})" 
                                        style="background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; width: 28px; height: 28px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer;" 
                                        title="Hapus Semua">
                                    <i class="fas fa-trash" style="font-size: 12px;"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Kitab Talaran Edit Modal -->
<div class="modal fade" id="kitabModal" tabindex="-1" role="dialog" aria-labelledby="kitabModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="kitabModalLabel">📚 Edit Kitab Talaran</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="kitabForm">
                <div class="modal-body">
                    <input type="hidden" id="kitabKelasId" value="">
                    <input type="hidden" id="kitabSemester" value="">
                    
                    <div class="form-group">
                        <label class="font-weight-bold text-secondary">Semester</label><br>
                        <span id="kitabSemesterLabel" class="badge badge-primary p-2"></span>
                    </div>
                    
                    <div class="form-group">
                        <label class="font-weight-bold text-secondary">Nama Kitab Talaran</label>
                        <input type="text" id="kitabNamaInput" class="form-control" placeholder="Contoh: Jurumiyah, Alfiyah, dll" required autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Kitab Modal Functions
    function showKitabModal(kelasId, semester, currentValue) {
        // Set hidden fields
        document.getElementById('kitabKelasId').value = kelasId;
        document.getElementById('kitabSemester').value = semester;
        document.getElementById('kitabNamaInput').value = currentValue || '';
        
        // Set semester label
        const semesterName = semester == 1 ? 'Ganjil' : 'Genap';
        const semesterColor = semester == 1 ? 'badge-info' : 'badge-warning';
        const labelEl = document.getElementById('kitabSemesterLabel');
        labelEl.textContent = 'Semester ' + semester + ' (' + semesterName + ')';
        labelEl.className = 'badge p-2 ' + semesterColor;
        
        // Show modal using Bootstrap jQuery
        $('#kitabModal').modal('show');
        
        // Focus input
        setTimeout(() => {
            document.getElementById('kitabNamaInput').focus();
        }, 500);
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
                displaySpan.classList.remove('text-muted');
                displaySpan.classList.add('font-weight-bold', 'text-dark');
            }
            $('#kitabModal').modal('hide');
            
            // Show success alert
            alert('Kitab berhasil disimpan!');
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
                display1.className = 'text-muted';
            }
            if (display2) {
                display2.textContent = '-';
                display2.className = 'text-muted';
            }
            
            alert('Kitab berhasil dihapus!');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal menghapus kitab. Silakan coba lagi.');
        });
    }
</script>
@endpush
