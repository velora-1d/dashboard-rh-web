@extends('layouts.app')

@section('title', 'Perizinan Santri')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Perizinan Santri</h1>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengajuan Izin</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal Request</th>
                            <th>Nama Santri</th>
                            <th>Jenis Izin</th>
                            <th>Waktu</th>
                            <th>Alasan</th>
                            <th>Bukti</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($perizinan as $item)
                        <tr>
                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $item->santri->nama_santri ?? '-' }}</td>
                            <td>
                                <span class="badge badge-info">{{ $item->jenis }}</span>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($item->tgl_mulai)->format('d M Y') }}
                                @if($item->tgl_selesai)
                                    - {{ \Carbon\Carbon::parse($item->tgl_selesai)->format('d M Y') }}
                                @endif
                            </td>
                            <td>{{ $item->alasan }}</td>
                            <td>
                                @if($item->bukti_foto)
                                    <a href="{{ $item->bukti_foto }}" target="_blank">Lihat</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($item->status == 'Pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($item->status == 'Disetujui')
                                    <span class="badge badge-success">Disetujui</span>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                @if($item->status == 'Pending')
                                <form action="{{ route('sekretaris.perizinan.approval', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="Disetujui">
                                    <button class="btn btn-success btn-sm">Terima</button>
                                </form>
                                <form action="{{ route('sekretaris.perizinan.approval', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="Ditolak">
                                    <button class="btn btn-danger btn-sm">Tolak</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $perizinan->links() }}
        </div>
    </div>
</div>
@endsection
