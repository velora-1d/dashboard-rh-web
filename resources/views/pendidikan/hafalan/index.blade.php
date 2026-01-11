@extends('layouts.app')

@section('title', 'Hafalan Santri')

@section('sidebar-menu')
    @include('pendidikan.partials.sidebar-menu')
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Hafalan Santri</h1>
        <a href="{{ route('pendidikan.hafalan.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Hafalan</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Hafalan</h6>
        </div>
        <div class="card-body">
            <!-- Filter Form -->
            <form method="GET" action="{{ route('pendidikan.hafalan.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="Cari Santri/NIS..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="jenis" class="form-control">
                            <option value="">Semua Jenis</option>
                            <option value="Quran" {{ request('jenis') == 'Quran' ? 'selected' : '' }}>Al-Qur'an</option>
                            <option value="Kitab" {{ request('jenis') == 'Kitab' ? 'selected' : '' }}>Kitab</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" placeholder="Dari Tanggal">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" placeholder="Sampai Tanggal">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
                        <a href="{{ route('pendidikan.hafalan.index') }}" class="btn btn-secondary"><i class="fas fa-sync"></i> Reset</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Santri</th>
                            <th>Jenis</th>
                            <th>Hafalan</th>
                            <th>Progress</th>
                            <th>Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hafalan as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $item->santri->nama_santri ?? '-' }}</td>
                            <td>{{ $item->jenis }}</td>
                            <td>{{ $item->nama_hafalan }}</td>
                            <td>{{ $item->progress }}</td>
                            <td>{{ $item->nilai ?? '-' }}</td>
                            <td>
                                <a href="{{ route('pendidikan.hafalan.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('pendidikan.hafalan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $hafalan->links() }}
        </div>
    </div>

    <!-- Konfigurasi Kitab Talaran per Kelas -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">📚 Konfigurasi Kitab Talaran per Kelas</h6>
        </div>
        <div class="card-body">
            <div class="mb-3 text-muted" style="font-size: 13px;">
                Atur kitab yang dipelajari untuk talaran setoran di setiap kelas untuk Semester Ganjil dan Genap.
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th rowspan="2" class="text-center align-middle" style="width: 50px;">No</th>
                            <th rowspan="2" class="align-middle">Kelas</th>
                            <th colspan="2" class="text-center bg-info">Semester Ganjil</th>
                            <th colspan="2" class="text-center bg-warning">Semester Genap</th>
                            <th rowspan="2" class="text-center align-middle" style="width: 100px;">Aksi</th>
                        </tr>
                        <tr>
                            <th class="bg-light text-dark">Kitab</th>
                            <th class="bg-light text-dark text-center" style="width: 60px;">Edit</th>
                            <th class="bg-light text-dark">Kitab</th>
                            <th class="bg-light text-dark text-center" style="width: 60px;">Edit</th>
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
                            <tr id="kitab-row-{{ $kelas->id }}">
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="font-weight-bold text-primary">{{ $kelas->nama_kelas }}</td>
                                
                                <!-- Semester Ganjil -->
                                <td>
                                    <span id="kitab-display-{{ $kelas->id }}-1" class="{{ $kitabName1 == '-' ? 'text-muted' : 'font-weight-bold text-dark' }}">
                                        {{ $kitabName1 }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button onclick="showKitabModal({{ $kelas->id }}, 1, '{{ addslashes($kitabName1 != '-' ? $kitabName1 : '') }}')" class="btn btn-sm btn-circle btn-light" title="Edit">
                                        <i class="fas fa-pencil-alt text-info"></i>
                                    </button>
                                </td>
                                
                                <!-- Semester Genap -->
                                <td>
                                    <span id="kitab-display-{{ $kelas->id }}-2" class="{{ $kitabName2 == '-' ? 'text-muted' : 'font-weight-bold text-dark' }}">
                                        {{ $kitabName2 }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button onclick="showKitabModal({{ $kelas->id }}, 2, '{{ addslashes($kitabName2 != '-' ? $kitabName2 : '') }}')" class="btn btn-sm btn-circle btn-light" title="Edit">
                                        <i class="fas fa-pencil-alt text-warning"></i>
                                    </button>
                                </td>
                                
                                <!-- Aksi Hapus -->
                                <td class="text-center">
                                    <button onclick="deleteKitab({{ $kelas->id }})" class="btn btn-sm btn-danger" title="Hapus Semua">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
