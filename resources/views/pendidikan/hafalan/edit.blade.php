@extends('layouts.app')

@section('title', 'Edit Hafalan')

@section('sidebar-menu')
    @include('pendidikan.partials.sidebar-menu')
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Hafalan</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('pendidikan.hafalan.update', $hafalan->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label>Nama Santri</label>
                    <select name="santri_id" class="form-control" required>
                        <option value="">Pilih Santri</option>
                        @foreach($santri as $s)
                        <option value="{{ $s->id }}" {{ $hafalan->santri_id == $s->id ? 'selected' : '' }}>{{ $s->nis }} - {{ $s->nama_santri }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ $hafalan->tanggal }}" required>
                </div>

                <div class="form-group">
                    <label>Jenis Hafalan</label>
                    <select name="jenis" class="form-control" required>
                        <option value="Quran" {{ $hafalan->jenis == 'Quran' ? 'selected' : '' }}>Al-Qur'an</option>
                        <option value="Kitab" {{ $hafalan->jenis == 'Kitab' ? 'selected' : '' }}>Kitab</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Nama Hafalan (Misal: Juz 30 / Kitab Jurumiyah)</label>
                    <input type="text" name="nama_hafalan" class="form-control" value="{{ $hafalan->nama_hafalan }}" required>
                </div>

                <div class="form-group">
                    <label>Progress (Misal: Surat An-Naba 1-10 / Bab Kalam)</label>
                    <input type="text" name="progress" class="form-control" value="{{ $hafalan->progress }}" required>
                </div>

                <div class="form-group">
                    <label>Nilai (Opsional)</label>
                    <input type="number" name="nilai" class="form-control" min="0" max="100" value="{{ $hafalan->nilai }}">
                </div>

                <div class="form-group">
                    <label>Catatan (Opsional)</label>
                    <textarea name="catatan" class="form-control">{{ $hafalan->catatan }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('pendidikan.hafalan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
