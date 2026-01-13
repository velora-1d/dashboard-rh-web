@extends('layouts.app')

@section('title', 'Edit Izin Santri')

@section('sidebar-menu')
    @include('sekretaris.partials.sidebar-menu')
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Title & Back Button -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <a href="{{ route('sekretaris.perizinan.index') }}" style="width: 40px; height: 40px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #6b7280; box-shadow: 0 1px 3px rgba(0,0,0,0.1); text-decoration: none; transition: all 0.2s;" onmouseover="this.style.transform='translateX(-2px)'; this.style.color='#f59e0b'" onmouseout="this.style.transform='translateX(0)'; this.style.color='#6b7280'">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin: 0;">Edit Data Izin</h1>
                <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Perbarui data perizinan santri</p>
            </div>
        </div>
    </div>

    <!-- Modern Form Card -->
    <div style="background: white; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); max-width: 800px; margin: 0 auto; overflow: hidden;">
        <div style="background: linear-gradient(to right, #f59e0b, #d97706); padding: 2px;"></div>
        <div style="padding: 32px;">
            <form action="{{ route('sekretaris.perizinan.update', $perizinan->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                    <!-- Santri Selection -->
                    <div style="grid-column: span 2;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Nama Santri <span style="color: #ef4444;">*</span></label>
                        <select name="santri_id" class="form-control" required style="height: 42px; border-radius: 8px; border: 1px solid #d1d5db; box-shadow: 0 1px 2px rgba(0,0,0,0.05); {{ auth()->user()->role === 'rois' ? 'background-color: #f1f5f9; cursor: not-allowed;' : '' }}" {{ auth()->user()->role === 'rois' ? 'disabled' : '' }}>
                            <option value="">-- Pilih Santri --</option>
                            @foreach($santri as $s)
                            <option value="{{ $s->id }}" {{ $perizinan->santri_id == $s->id ? 'selected' : '' }}>{{ $s->nis }} - {{ $s->nama_santri }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Jenis Izin -->
                    <div style="grid-column: span 2;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Jenis Izin <span style="color: #ef4444;">*</span></label>
                        <select name="jenis" class="form-control" required style="height: 42px; border-radius: 8px; border: 1px solid #d1d5db; box-shadow: 0 1px 2px rgba(0,0,0,0.05); {{ auth()->user()->role === 'rois' ? 'background-color: #f1f5f9; cursor: not-allowed;' : '' }}" {{ auth()->user()->role === 'rois' ? 'disabled' : '' }}>
                            <option value="Izin" {{ $perizinan->jenis == 'Izin' ? 'selected' : '' }}>Izin Keluar</option>
                            <option value="Sakit" {{ $perizinan->jenis == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                            <option value="Pulang" {{ $perizinan->jenis == 'Pulang' ? 'selected' : '' }}>Pulang ke Rumah</option>
                        </select>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div>
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Tanggal Mulai <span style="color: #ef4444;">*</span></label>
                        <input type="date" name="tgl_mulai" value="{{ $perizinan->tgl_mulai }}" required
                               style="display: block; width: 100%; height: 42px; padding: 8px 12px; font-size: 0.95rem; line-height: 1.5; color: #1f2937; background-color: #fff; border: 1px solid #d1d5db; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; {{ auth()->user()->role === 'rois' ? 'background-color: #f1f5f9; cursor: not-allowed;' : '' }}" {{ auth()->user()->role === 'rois' ? 'disabled' : '' }}>
                    </div>

                    <!-- Tanggal Selesai -->
                    <div>
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Tanggal Selesai <span style="font-weight: 400; color: #9ca3af;">(Opsional)</span></label>
                        <input type="date" name="tgl_selesai" value="{{ $perizinan->tgl_selesai }}"
                               style="display: block; width: 100%; height: 42px; padding: 8px 12px; font-size: 0.95rem; line-height: 1.5; color: #1f2937; background-color: #fff; border: 1px solid #d1d5db; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; {{ auth()->user()->role === 'rois' ? 'background-color: #f1f5f9; cursor: not-allowed;' : '' }}" {{ auth()->user()->role === 'rois' ? 'disabled' : '' }}>
                    </div>

                    <!-- Status -->
                     <div style="grid-column: span 2;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Status</label>
                        <select name="status" class="form-control" required style="height: 42px; border-radius: 8px; border: 1px solid #d1d5db; box-shadow: 0 1px 2px rgba(0,0,0,0.05); {{ auth()->user()->role === 'rois' ? 'background-color: #f1f5f9; cursor: not-allowed;' : '' }}" {{ auth()->user()->role === 'rois' ? 'disabled' : '' }}>
                            <option value="Pending" {{ $perizinan->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Disetujui" {{ $perizinan->status == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Ditolak" {{ $perizinan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <!-- Alasan -->
                    <div style="grid-column: span 2;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Alasan <span style="color: #ef4444;">*</span></label>
                        <textarea name="alasan" rows="3" required
                                  style="display: block; width: 100%; padding: 8px 12px; font-size: 0.95rem; line-height: 1.5; color: #1f2937; background-color: #fff; border: 1px solid #d1d5db; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); resize: vertical; {{ auth()->user()->role === 'rois' ? 'background-color: #f1f5f9; cursor: not-allowed;' : '' }}" {{ auth()->user()->role === 'rois' ? 'disabled' : '' }}>{{ $perizinan->alasan }}</textarea>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; border-top: 1px solid #f3f4f6; padding-top: 24px; margin-top: 8px; align-items: center;">
                    @if(auth()->user()->role !== 'rois')
                        <button type="submit" style="background: #f59e0b; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; font-size: 0.95rem; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.3); transition: all 0.2s;" onmouseover="this.style.background='#d97706'; this.style.transform='translateY(-1px)'" onmouseout="this.style.background='#f59e0b'; this.style.transform='translateY(0)'">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    @else
                        <div style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 24px; background: #f1f5f9; color: #64748b; border-radius: 8px; font-weight: 600; font-size: 14px; border: 1px solid #e2e8f0;">
                            <i class="fas fa-lock"></i> Mode Baca Saja
                        </div>
                    @endif
                    <a href="{{ route('sekretaris.perizinan.index') }}" style="background: white; color: #6b7280; border: 1px solid #d1d5db; padding: 10px 24px; border-radius: 8px; font-weight: 600; font-size: 0.95rem; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; transition: all 0.2s;" onmouseover="this.style.background='#f9fafb'; this.style.color='#374151'" onmouseout="this.style.background='white'; this.style.color='#6b7280'">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('select[name="santri_id"]').select2({
            placeholder: "-- Pilih Santri --",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush
