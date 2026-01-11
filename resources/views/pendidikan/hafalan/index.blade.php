@extends('layouts.app')

@section('title', 'Hafalan Santri')

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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $hafalan->links() }}
        </div>
    </div>
</div>
@endsection
