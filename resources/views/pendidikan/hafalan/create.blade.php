@extends('layouts.app')

@section('title', 'Input Hafalan')

@section('sidebar-menu')
    @include('pendidikan.partials.sidebar-menu')
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Input Hafalan Baru</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('pendidikan.hafalan.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label>Nama Santri</label>
                    <select name="santri_id" class="form-control" required>
                        <option value="">Pilih Santri</option>
                        @foreach($santri as $s)
                        <option value="{{ $s->id }}">{{ $s->nis }} - {{ $s->nama_santri }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="form-group">
                    <label>Jenis Hafalan</label>
                    <select name="jenis" class="form-control" required>
                        <option value="Quran">Al-Qur'an</option>
                        <option value="Kitab">Kitab</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Nama Hafalan (Misal: Juz 30 / Kitab Jurumiyah)</label>
                    <input type="text" name="nama_hafalan" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Progress (Misal: Surat An-Naba 1-10 / Bab Kalam)</label>
                    <input type="text" name="progress" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Nilai (Opsional)</label>
                    <input type="number" name="nilai" class="form-control" min="0" max="100">
                </div>

                <div class="form-group">
                    <label>Catatan (Opsional)</label>
                    <textarea name="catatan" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Embed configuration from backend
    const kitabConfig = @json($kitabConfig);
    const santriData = @json($santri->map(function($s) {
        return ['id' => $s->id, 'kelas_id' => $s->kelas_id];
    }));
    
    document.querySelector('select[name="santri_id"]').addEventListener('change', function() {
        updateHafalanSuggestion();
    });

    document.querySelector('select[name="jenis"]').addEventListener('change', function() {
        updateHafalanSuggestion();
    });

    function updateHafalanSuggestion() {
        const santriId = document.querySelector('select[name="santri_id"]').value;
        const jenis = document.querySelector('select[name="jenis"]').value;
        const hafalanInput = document.querySelector('input[name="nama_hafalan"]');
        
        if (!santriId || jenis !== 'Kitab') return;

        // Find santri class
        const santri = santriData.find(s => s.id == santriId);
        if (santri && santri.kelas_id) {
            // Get current semester (simple approximation or you can inject it)
            const currentMonth = new Date().getMonth() + 1;
            const currentSemester = (currentMonth >= 7) ? 1 : 2;
            
            // Check config
            if (kitabConfig[santri.kelas_id]) {
                const config = kitabConfig[santri.kelas_id].find(c => c.semester == currentSemester);
                if (config) {
                    hafalanInput.value = config.nama_kitab;
                    hafalanInput.setAttribute('placeholder', 'Sesuai kelas: ' + config.nama_kitab);
                    return;
                }
            }
        }
        
        hafalanInput.setAttribute('placeholder', 'Misal: Juz 30 / Kitab Jurumiyah');
    }
</script>
@endpush
