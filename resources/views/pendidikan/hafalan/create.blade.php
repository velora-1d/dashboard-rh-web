@extends('layouts.app')

@section('title', 'Input Hafalan')

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
