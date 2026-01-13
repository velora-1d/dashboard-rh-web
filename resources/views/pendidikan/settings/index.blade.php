@extends('layouts.app')

@section('title', 'Pengaturan Rapor')
@section('page-title', 'Pengaturan Rapor Digital')

@section('sidebar-menu')
    @include('pendidikan.partials.sidebar-menu')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        @if(session('success'))
        <div class="alert alert-success" style="background-color: #d1e7dd; color: #0f5132; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <i data-feather="check-circle" style="width: 18px; vertical-align: text-bottom;"></i> {{ session('success') }}
        </div>
        @endif

        <div class="card" style="background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: none; overflow: hidden;">
            <div class="card-header" style="background: #f8fafc; padding: 20px; border-bottom: 1px solid #e2e8f0;">
                <h5 style="margin: 0; font-weight: 600; color: #1e293b;">Identitas & Kop Rapor</h5>
                <p style="margin: 5px 0 0; color: #64748b; font-size: 0.9rem;">Atur identitas pondok, logo, dan tanda tangan default.</p>
            </div>
            <div class="card-body" style="padding: 25px;">
                <form action="{{ route('pendidikan.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Identitas -->
                        <div class="col-span-1">
                            <h6 style="color: #3b82f6; font-weight: 600; margin-bottom: 15px; border-bottom: 2px solid #3b82f6; padding-bottom: 5px; display: inline-block;">Identitas Instansi</h6>
                            
                            <div class="form-group mb-4">
                                <label class="form-label" style="font-weight: 500; margin-bottom: 5px; display: block;">Nama Yayasan (Kop Atas)</label>
                                <input type="text" name="nama_yayasan" class="form-control" value="{{ $settings->nama_yayasan }}" required
                                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;" {{ auth()->user()->role === 'rois' ? 'disabled' : '' }}>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" style="font-weight: 500; margin-bottom: 5px; display: block;">Nama Pondok / Sekolah (Kop Utama)</label>
                                <input type="text" name="nama_pondok" class="form-control" value="{{ $settings->nama_pondok }}" required
                                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;" {{ auth()->user()->role === 'rois' ? 'disabled' : '' }}>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" style="font-weight: 500; margin-bottom: 5px; display: block;">Alamat Lengkap</label>
                                <textarea name="alamat" class="form-control" rows="2"
                                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;" {{ auth()->user()->role === 'rois' ? 'disabled' : '' }}>{{ $settings->alamat }}</textarea>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" style="font-weight: 500; margin-bottom: 5px; display: block;">Kontak / Telepon</label>
                                <input type="text" name="telepon" class="form-control" value="{{ $settings->telepon }}"
                                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;" {{ auth()->user()->role === 'rois' ? 'disabled' : '' }}>
                            </div>
                            
                            <div class="form-group mb-4">
                                <label class="form-label" style="font-weight: 500; margin-bottom: 5px; display: block;">Kota Terbit Rapor</label>
                                <input type="text" name="kota_terbit" class="form-control" value="{{ $settings->kota_terbit }}" required
                                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;" {{ auth()->user()->role === 'rois' ? 'disabled' : '' }}>
                            </div>
                        </div>

                        <!-- Logo & TTD -->
                        <div class="col-span-1">
                            <h6 style="color: #3b82f6; font-weight: 600; margin-bottom: 15px; border-bottom: 2px solid #3b82f6; padding-bottom: 5px; display: inline-block;">Logo & Validasi</h6>

                            <div class="flex gap-4 mb-4">
                                <div style="flex: 1;">
                                    <label class="form-label" style="font-weight: 500; margin-bottom: 5px; display: block;">Logo Pondok (Kiri)</label>
                                    @if($settings->logo_pondok_path)
                                        <div class="mb-2 p-2 border rounded bg-gray-50 text-center">
                                            <img src="{{ asset('storage/' . $settings->logo_pondok_path) }}" alt="Logo Pondok" style="height: 60px; object-fit: contain;">
                                        </div>
                                    @endif
                                    <input type="file" name="logo_pondok" class="form-control" accept="image/*"
                                        style="font-size: 12px;" {{ auth()->user()->role === 'rois' ? 'disabled' : '' }}>
                                </div>
                                <div style="flex: 1;">
                                    <label class="form-label" style="font-weight: 500; margin-bottom: 5px; display: block;">Logo Pendidikan (Kanan)</label>
                                    @if($settings->logo_pendidikan_path)
                                        <div class="mb-2 p-2 border rounded bg-gray-50 text-center">
                                            <img src="{{ asset('storage/' . $settings->logo_pendidikan_path) }}" alt="Logo Pendidikan" style="height: 60px; object-fit: contain;">
                                        </div>
                                    @endif
                                    <input type="file" name="logo_pendidikan" class="form-control" accept="image/*"
                                        style="font-size: 12px;" {{ auth()->user()->role === 'rois' ? 'disabled' : '' }}>
                                </div>
                            </div>

                            <hr style="border-top: 1px dashed #cbd5e1; margin: 20px 0;">

                            <h6 style="color: #3b82f6; font-weight: 600; margin-bottom: 15px; border-bottom: 2px solid #3b82f6; padding-bottom: 5px; display: inline-block;">Pimpinan Umum</h6>
                            
                            <div class="form-group mb-4">
                                <label class="form-label" style="font-weight: 500; margin-bottom: 5px; display: block;">Nama Pimpinan</label>
                                <input type="text" name="pimpinan_nama" class="form-control" value="{{ $settings->pimpinan_nama }}" required
                                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;" {{ auth()->user()->role === 'rois' ? 'disabled' : '' }}>
                            </div>
                            
                            <div class="form-group mb-4">
                                <label class="form-label" style="font-weight: 500; margin-bottom: 5px; display: block;">Jabatan</label>
                                <input type="text" name="pimpinan_jabatan" class="form-control" value="{{ $settings->pimpinan_jabatan }}" required
                                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;" {{ auth()->user()->role === 'rois' ? 'disabled' : '' }}>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" style="font-weight: 500; margin-bottom: 5px; display: block;">Tanda Tangan (PNG Transparan)</label>
                                @if($settings->pimpinan_ttd_path)
                                    <div class="mb-2 p-2 border rounded bg-gray-50">
                                        <img src="{{ asset('storage/' . $settings->pimpinan_ttd_path) }}" alt="TTD Pimpinan" style="height: 50px;">
                                    </div>
                                @endif
                                <input type="file" name="pimpinan_ttd" class="form-control" accept="image/png"
                                    style="font-size: 12px;" {{ auth()->user()->role === 'rois' ? 'disabled' : '' }}>
                                <small class="text-muted" style="display: block; margin-top: 4px; font-size: 11px;">* Wajib upload untuk fitur cetak otomatis</small>
                            </div>
                        </div>
                    </div>

                    <div class="text-right mt-4" style="text-align: right; border-top: 1px solid #e2e8f0; padding-top: 20px;">
                        @if(auth()->user()->role !== 'rois')
                        <button type="submit" class="btn btn-primary" style="background: #3b82f6; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer;">
                            <i data-feather="save" style="width: 16px; margin-right: 5px;"></i> Simpan Pengaturan
                        </button>
                        @else
                        <div style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 24px; background: #f1f5f9; color: #64748b; border-radius: 8px; font-weight: 600; font-size: 14px;">
                            <i data-feather="lock" style="width: 18px; height: 18px;"></i>
                            Mode Baca Saja
                        </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Tanda Tangan Wali Kelas -->
        <div class="card mt-4" style="background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: none; overflow: hidden; margin-top: 24px;">
            <div class="card-header" style="background: #f8fafc; padding: 20px; border-bottom: 1px solid #e2e8f0;">
                <h5 style="margin: 0; font-weight: 600; color: #1e293b;">Tanda Tangan Wali Kelas</h5>
                <p style="margin: 5px 0 0; color: #64748b; font-size: 0.9rem;">Upload tanda tangan digital untuk setiap wali kelas. File akan otomatis muncul di rapor siswa kelas tersebut.</p>
            </div>
            <div class="card-body" style="padding: 0;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f1f5f9;">
                        <tr>
                            <th style="padding: 15px 20px; text-align: left; font-weight: 600; color: #475569; width: 50px;">No</th>
                            <th style="padding: 15px 20px; text-align: left; font-weight: 600; color: #475569;">Nama Kelas</th>
                            <th style="padding: 15px 20px; text-align: left; font-weight: 600; color: #475569;">Wali Kelas</th>
                            <th style="padding: 15px 20px; text-align: center; font-weight: 600; color: #475569;">Preview TTD</th>
                            <th style="padding: 15px 20px; text-align: right; font-weight: 600; color: #475569;">Upload File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kelasList as $index => $kelas)
                            @if($kelas->tipe_wali_kelas === 'dual')
                                <!-- DUAL: PUTRA Row -->
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td rowspan="2" style="padding: 15px 20px; color: #64748b; vertical-align: top; border-bottom: 3px solid #e2e8f0;">{{ $index + 1 }}</td>
                                    <td rowspan="2" style="padding: 15px 20px; font-weight: 600; color: #1e293b; vertical-align: top; border-bottom: 3px solid #e2e8f0;">
                                        {{ $kelas->nama_kelas }} <br>
                                        <span class="badge" style="background: #e0f2fe; color: #0369a1; padding: 2px 6px; border-radius: 4px; font-size: 10px;">DUAL</span>
                                    </td>
                                    <td style="padding: 10px 20px; color: #475569;">
                                        Putra: <strong>{{ $kelas->wali_kelas_putra ?? '-' }}</strong>
                                    </td>
                                    <td style="padding: 10px 20px; text-align: center;">
                                        @if($kelas->wali_kelas_ttd_path_putra)
                                            <div style="background: #f8fafc; padding: 4px; border: 1px solid #e2e8f0; display: inline-block;">
                                                <img src="{{ asset('storage/' . $kelas->wali_kelas_ttd_path_putra) }}" style="height: 30px;">
                                            </div>
                                        @else
                                            <span style="font-size: 10px; color: #ef4444;">Belum ada</span>
                                        @endif
                                    </td>
                                    <td style="padding: 10px 20px; text-align: right;">
                                        <form action="{{ route('pendidikan.kelas.upload-ttd', $kelas->id) }}" method="POST" enctype="multipart/form-data" class="flex-center-end">
                                            @csrf
                                            <input type="hidden" name="type" value="putra">
                                            @if(auth()->user()->role !== 'rois')
                                            <input type="file" name="ttd_file" required class="form-control" accept="image/png" style="width: 180px; font-size: 11px;">
                                            <button type="submit" class="btn btn-sm-upload"><i data-feather="upload" style="width: 12px;"></i> Upload</button>
                                            @else
                                            <span style="font-size: 11px; color: #94a3b8; font-style: italic;">Read-Only</span>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                                <!-- DUAL: PUTRI Row -->
                                <tr style="border-bottom: 3px solid #e2e8f0;">
                                    <td style="padding: 10px 20px; color: #475569;">
                                        Putri: <strong>{{ $kelas->wali_kelas_putri ?? '-' }}</strong>
                                    </td>
                                    <td style="padding: 10px 20px; text-align: center;">
                                        @if($kelas->wali_kelas_ttd_path_putri)
                                            <div style="background: #f8fafc; padding: 4px; border: 1px solid #e2e8f0; display: inline-block;">
                                                <img src="{{ asset('storage/' . $kelas->wali_kelas_ttd_path_putri) }}" style="height: 30px;">
                                            </div>
                                        @else
                                            <span style="font-size: 10px; color: #ef4444;">Belum ada</span>
                                        @endif
                                    </td>
                                    <td style="padding: 10px 20px; text-align: right;">
                                        <form action="{{ route('pendidikan.kelas.upload-ttd', $kelas->id) }}" method="POST" enctype="multipart/form-data" class="flex-center-end">
                                            @csrf
                                            <input type="hidden" name="type" value="putri">
                                            @if(auth()->user()->role !== 'rois')
                                            <input type="file" name="ttd_file" required class="form-control" accept="image/png" style="width: 180px; font-size: 11px;">
                                            <button type="submit" class="btn btn-sm-upload"><i data-feather="upload" style="width: 12px;"></i> Upload</button>
                                            @else
                                            <span style="font-size: 11px; color: #94a3b8; font-style: italic;">Read-Only</span>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @else
                                <!-- TUNGGAL Row -->
                                <tr style="border-bottom: 3px solid #e2e8f0;">
                                    <td style="padding: 15px 20px; color: #64748b;">{{ $index + 1 }}</td>
                                    <td style="padding: 15px 20px; font-weight: 500; color: #1e293b;">{{ $kelas->nama_kelas }}</td>
                                    <td style="padding: 15px 20px; color: #475569;">{{ $kelas->wali_kelas ?? '-' }}</td>
                                    <td style="padding: 15px 20px; text-align: center;">
                                        @if($kelas->wali_kelas_ttd_path)
                                            <div style="background: #f8fafc; padding: 5px; border-radius: 4px; border: 1px solid #e2e8f0; display: inline-block;">
                                                <img src="{{ asset('storage/' . $kelas->wali_kelas_ttd_path) }}" alt="TTD" style="height: 40px; object-fit: contain;">
                                            </div>
                                        @else
                                            <span style="font-size: 11px; color: #ef4444; background: #fef2f2; padding: 2px 8px; border-radius: 10px;">Belum ada</span>
                                        @endif
                                    </td>
                                    <td style="padding: 15px 20px; text-align: right;">
                                        <form action="{{ route('pendidikan.kelas.upload-ttd', $kelas->id) }}" method="POST" enctype="multipart/form-data" class="flex-center-end">
                                            @csrf
                                            <input type="hidden" name="type" value="umum">
                                            @if(auth()->user()->role !== 'rois')
                                            <input type="file" name="ttd_file" required class="form-control" accept="image/png" style="width: 200px; font-size: 12px;">
                                            <button type="submit" class="btn btn-sm-upload"><i data-feather="upload" style="width: 14px;"></i> Upload</button>
                                            @else
                                            <span style="font-size: 11px; color: #94a3b8; font-style: italic;">Read-Only</span>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>

                    <style>
                        .flex-center-end { display: flex; justify-content: flex-end; align-items: center; gap: 10px; }
                        .btn-sm-upload { background: #10b981; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; gap: 4px; }
                    </style>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
