@extends('layouts.app')

@section('title', 'Tambah Santri')
@section('page-title', 'Tambah Data Santri')

@section('sidebar-menu')
    @include('sekretaris.partials.sidebar-menu')
@endsection

@section('content')
    <!-- Aesthetic Header with Gradient -->
    <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 16px; padding: 24px 32px; margin-bottom: 32px; box-shadow: 0 10px 30px rgba(67, 233, 123, 0.3); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -30px; right: -30px; width: 120px; height: 120px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -40px; left: 40%; width: 80px; height: 80px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
            <div style="background: rgba(255,255,255,0.2); width: 56px; height: 56px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                <i data-feather="user-plus" style="width: 28px; height: 28px; color: white;"></i>
            </div>
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 700; color: white; margin: 0 0 4px 0;">Tambah Santri Baru</h2>
                <p style="color: rgba(255,255,255,0.9); font-size: 0.875rem; margin: 0;">Lengkapi Data untuk Mendaftarkan Santri</p>
            </div>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('sekretaris.data-santri.store') }}">
            @csrf
            
            <h3 style="font-size: var(--font-size-lg); font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-lg); color: var(--color-gray-900);">
                Informasi Santri
            </h3>
            
            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label class="form-label">NIS *</label>
                    <input type="text" name="nis" class="form-input" value="{{ old('nis') }}" required>
                    @error('nis')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Nama Santri *</label>
                    <input type="text" name="nama_santri" class="form-input" value="{{ old('nama_santri') }}" required>
                    @error('nama_santri')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Gender *</label>
                    <select name="gender" class="form-select" required>
                        <option value="">Pilih Gender</option>
                        <option value="putra" {{ old('gender') == 'putra' ? 'selected' : '' }}>Putra</option>
                        <option value="putri" {{ old('gender') == 'putri' ? 'selected' : '' }}>Putri</option>
                    </select>
                    @error('gender')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Tanggal Masuk *</label>
                    <input type="date" name="tanggal_masuk" class="form-input" value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                    @error('tanggal_masuk')<span class="form-error">{{ $message }}</span>@enderror
                </div>
            </div>
            
            <h3 style="font-size: var(--font-size-lg); font-weight: var(--font-weight-semibold); margin: var(--spacing-xl) 0 var(--spacing-lg); color: var(--color-gray-900);">
                Alamat Lengkap
            </h3>
            
            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label class="form-label">Negara *</label>
                    <input type="text" name="negara" class="form-input" value="{{ old('negara', 'Indonesia') }}" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Provinsi *</label>
                    <input type="text" name="provinsi" class="form-input" value="{{ old('provinsi') }}" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Kota/Kabupaten *</label>
                    <input type="text" name="kota_kabupaten" class="form-input" value="{{ old('kota_kabupaten') }}" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Kecamatan *</label>
                    <input type="text" name="kecamatan" class="form-input" value="{{ old('kecamatan') }}" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Desa/Kampung *</label>
                    <input type="text" name="desa_kampung" class="form-input" value="{{ old('desa_kampung') }}" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">RT/RW *</label>
                    <input type="text" name="rt_rw" class="form-input" placeholder="001/002" value="{{ old('rt_rw') }}" required>
                </div>
            </div>
            
            <h3 style="font-size: var(--font-size-lg); font-weight: var(--font-weight-semibold); margin: var(--spacing-xl) 0 var(--spacing-lg); color: var(--color-gray-900);">
                Orang Tua / Wali
            </h3>
            
            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label class="form-label">Nama Orang Tua/Wali *</label>
                    <input type="text" name="nama_ortu_wali" class="form-input" value="{{ old('nama_ortu_wali') }}" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">No. HP Orang Tua/Wali *</label>
                    <input type="text" name="no_hp_ortu_wali" class="form-input" placeholder="08xxxxxxxxxx" value="{{ old('no_hp_ortu_wali') }}" required>
                </div>
            </div>
            
            <h3 style="font-size: var(--font-size-lg); font-weight: var(--font-weight-semibold); margin: var(--spacing-xl) 0 var(--spacing-lg); color: var(--color-gray-900);">
                Penempatan
            </h3>
            
            <div class="grid grid-cols-3">
                <div class="form-group">
                    <label class="form-label">Kelas *</label>
                    <select name="kelas_id" class="form-select" required>
                        <option value="">Pilih Kelas</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Asrama *</label>
                    <select name="asrama_id" id="asrama_id" class="form-select" required>
                        <option value="">Pilih Asrama</option>
                        @foreach($asramaList as $asrama)
                            <option value="{{ $asrama->id }}" {{ old('asrama_id') == $asrama->id ? 'selected' : '' }}>
                                {{ $asrama->nama_asrama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Kobong *</label>
                    <select name="kobong_id" id="kobong_id" class="form-select" required>
                        <option value="">Pilih Asrama Dulu</option>
                    </select>
                </div>
            </div>
            
            <div style="display: flex; gap: var(--spacing-md); margin-top: var(--spacing-xl);">
                <button type="submit" class="btn btn-primary">
                    <i data-feather="save" style="width: 16px; height: 16px;"></i>
                    Simpan
                </button>
                <a href="{{ route('sekretaris.data-santri') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
// Dynamic Kobong dropdown based on Asrama selection
document.getElementById('asrama_id').addEventListener('change', function() {
    const asramaId = this.value;
    const kobongSelect = document.getElementById('kobong_id');
    
    if (!asramaId) {
        kobongSelect.innerHTML = '<option value="">Pilih Asrama Dulu</option>';
        return;
    }
    
    // Fetch kobong data
    fetch(`/sekretaris/api/kobong/${asramaId}`)
        .then(response => response.json())
        .then(data => {
            kobongSelect.innerHTML = '<option value="">Pilih Kobong</option>';
            data.forEach(kobong => {
                kobongSelect.innerHTML += `<option value="${kobong.id}">Kobong ${kobong.nomor_kobong}</option>`;
            });
        })
        .catch(error => console.error('Error:', error));
});
</script>
@endpush
