@extends('layouts.app')

@section('title', 'Edit Hafalan')

@section('sidebar-menu')
    @include('pendidikan.partials.sidebar-menu')
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Title & Back Button -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <a href="{{ route('pendidikan.hafalan.index') }}" style="width: 40px; height: 40px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #6b7280; box-shadow: 0 1px 3px rgba(0,0,0,0.1); text-decoration: none; transition: all 0.2s;" onmouseover="this.style.transform='translateX(-2px)'; this.style.color='#f59e0b'" onmouseout="this.style.transform='translateX(0)'; this.style.color='#6b7280'">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin: 0;">Edit Data Hafalan</h1>
                <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Perbarui data setoran hafalan santri</p>
            </div>
        </div>
    </div>

    <!-- Modern Form Card -->
    <div style="background: white; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); max-width: 800px; margin: 0 auto; overflow: hidden;">
        <div style="background: linear-gradient(to right, #f59e0b, #d97706); padding: 2px;"></div>
        <div style="padding: 32px;">
            <form action="{{ route('pendidikan.hafalan.update', $hafalan->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                    <!-- Santri Selection -->
                    <div style="grid-column: span 2;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Nama Santri <span style="color: #ef4444;">*</span></label>
                        <select name="santri_id" class="form-control" required style="height: 42px; border-radius: 8px; border: 1px solid #d1d5db; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                            <option value="">-- Pilih Santri --</option>
                            @foreach($santri as $s)
                            <option value="{{ $s->id }}" {{ $hafalan->santri_id == $s->id ? 'selected' : '' }}>{{ $s->nis }} - {{ $s->nama_santri }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date -->
                    <div>
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Tanggal Setoran <span style="color: #ef4444;">*</span></label>
                        <input type="date" name="tanggal" value="{{ $hafalan->tanggal }}" required
                               style="display: block; width: 100%; height: 42px; padding: 8px 12px; font-size: 0.95rem; line-height: 1.5; color: #1f2937; background-color: #fff; border: 1px solid #d1d5db; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;">
                    </div>

                    <!-- Type -->
                    <div>
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Jenis Hafalan <span style="color: #ef4444;">*</span></label>
                        <select name="jenis" class="form-control" required style="height: 42px; border-radius: 8px; border: 1px solid #d1d5db; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                            <option value="Quran" {{ $hafalan->jenis == 'Quran' ? 'selected' : '' }}>Al-Qur'an</option>
                            <option value="Kitab" {{ $hafalan->jenis == 'Kitab' ? 'selected' : '' }}>Kitab</option>
                        </select>
                    </div>

                    <!-- Hafalan Name -->
                    <div style="grid-column: span 2;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 8px;">
                            Nama Hafalan <span style="color: #ef4444;">*</span>
                            <span style="font-size: 0.75rem; font-weight: 400; color: #6b7280; margin-left: 4px;">(Contoh: Juz 30 / Kitab Jurumiyah)</span>
                        </label>
                        <input type="text" name="nama_hafalan" value="{{ $hafalan->nama_hafalan }}" required
                               style="display: block; width: 100%; height: 42px; padding: 8px 12px; font-size: 0.95rem; line-height: 1.5; color: #1f2937; background-color: #fff; border: 1px solid #d1d5db; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;">
                    </div>

                    <!-- Progress -->
                    <div style="grid-column: span 2;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 8px;">
                            Progress / Pencapaian <span style="color: #ef4444;">*</span>
                            <span style="font-size: 0.75rem; font-weight: 400; color: #6b7280; margin-left: 4px;">(Contoh: Surat An-Naba Ayat 1-10 / Bab Kalam)</span>
                        </label>
                        <input type="text" name="progress" value="{{ $hafalan->progress }}" required
                               style="display: block; width: 100%; height: 42px; padding: 8px 12px; font-size: 0.95rem; line-height: 1.5; color: #1f2937; background-color: #fff; border: 1px solid #d1d5db; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;">
                    </div>

                    <!-- Score -->
                    <div>
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Nilai <span style="font-weight: 400; color: #9ca3af;">(Opsional)</span></label>
                        <input type="number" name="nilai" min="0" max="100" placeholder="0-100" value="{{ $hafalan->nilai }}"
                               style="display: block; width: 100%; height: 42px; padding: 8px 12px; font-size: 0.95rem; line-height: 1.5; color: #1f2937; background-color: #fff; border: 1px solid #d1d5db; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;">
                    </div>

                    <!-- Notes -->
                    <div style="grid-column: span 2;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Catatan <span style="font-weight: 400; color: #9ca3af;">(Opsional)</span></label>
                        <textarea name="catatan" rows="3" 
                                  style="display: block; width: 100%; padding: 8px 12px; font-size: 0.95rem; line-height: 1.5; color: #1f2937; background-color: #fff; border: 1px solid #d1d5db; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); resize: vertical;">{{ $hafalan->catatan }}</textarea>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; border-top: 1px solid #f3f4f6; padding-top: 24px; margin-top: 8px;">
                    <button type="submit" style="background: #f59e0b; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; font-size: 0.95rem; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.3); transition: all 0.2s;" onmouseover="this.style.background='#d97706'; this.style.transform='translateY(-1px)'" onmouseout="this.style.background='#f59e0b'; this.style.transform='translateY(0)'">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('pendidikan.hafalan.index') }}" style="background: white; color: #6b7280; border: 1px solid #d1d5db; padding: 10px 24px; border-radius: 8px; font-weight: 600; font-size: 0.95rem; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; transition: all 0.2s;" onmouseover="this.style.background='#f9fafb'; this.style.color='#374151'" onmouseout="this.style.background='white'; this.style.color='#6b7280'">
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
