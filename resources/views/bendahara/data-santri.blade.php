@extends('layouts.app')

@section('title', 'Data Santri')
@section('page-title', 'Data Santri')

@section('sidebar-menu')
    @include('bendahara.partials.sidebar-menu')
@endsection

@section('content')
    <h2 style="font-size: var(--font-size-xl); font-weight: var(--font-weight-semibold); color: var(--color-gray-900); margin-bottom: var(--spacing-xl);">
        Data Santri (Read-Only)
    </h2>

    <!-- Search -->
    <div class="card" style="margin-bottom: var(--spacing-xl);">
        <form method="GET" action="{{ route('bendahara.data-santri') }}">
            <div style="display: flex; gap: var(--spacing-sm);">
                <input type="text" name="search" class="form-input" placeholder="Cari NIS/Nama..." value="{{ request('search') }}" style="flex: 1;">
                <button type="submit" class="btn btn-primary">
                    <i data-feather="search" style="width: 16px; height: 16px;"></i>
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>NIS</th>
                    <th>Nama Santri</th>
                    <th>Gender</th>
                    <th>Kelas</th>
                    <th>Asrama</th>
                </tr>
            </thead>
            <tbody>
                @forelse($santri as $s)
                    <tr>
                        <td>{{ $s->nis }}</td>
                        <td>{{ $s->nama_santri }}</td>
                        <td>
                            <span class="badge {{ $s->gender == 'putra' ? 'badge-info' : 'badge-warning' }}">
                                {{ ucfirst($s->gender) }}
                            </span>
                        </td>
                        <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                        <td>{{ $s->asrama->nama_asrama ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: var(--spacing-xl); color: var(--color-gray-500);">
                            Tidak ada data santri
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($santri->hasPages())
        <div style="margin-top: var(--spacing-lg); display: flex; justify-content: center;">
            {{ $santri->links() }}
        </div>
    @endif
@endsection
