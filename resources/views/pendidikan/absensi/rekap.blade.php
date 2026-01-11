@extends('layouts.app')

@section('title', 'Rekap Alfa & Ranking')
@section('page-title', 'Rekap Alfa & Ranking')

@section('sidebar-menu')
    @include('pendidikan.partials.sidebar-menu')
@endsection

@section('content')
    <h2 style="font-size: var(--font-size-xl); font-weight: var(--font-weight-semibold); color: var(--color-gray-900); margin-bottom: var(--spacing-xl);">
        Rekap Alfa & Ranking Santri
    </h2>

    <!-- Filter -->
    <div class="card" style="margin-bottom: var(--spacing-xl);">
        <h3 class="card-header">Filter Rekap</h3>
        <form method="GET" action="{{ route('pendidikan.absensi.rekap') }}">
            <div class="grid grid-cols-4" style="margin-bottom: var(--spacing-md);">
                <div class="form-group">
                    <label class="form-label">Kelas</label>
                    <select name="kelas_id" class="form-select" required>
                        <option value="">Pilih Kelas</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tahun</label>
                    <input type="number" name="tahun" class="form-input" value="{{ $tahun }}" min="2020" max="2030" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Minggu Mulai</label>
                    <input type="number" name="minggu_mulai" class="form-input" value="{{ $mingguMulai }}" min="1" max="52" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Minggu Selesai</label>
                    <input type="number" name="minggu_selesai" class="form-input" value="{{ $mingguSelesai }}" min="1" max="52" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                <i data-feather="search" style="width: 16px; height: 16px;"></i>
                Tampilkan Rekap
            </button>
            <a href="{{ route('pendidikan.absensi') }}" class="btn btn-secondary">
                <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i>
                Kembali
            </a>
        </form>
    </div>

    @if(isset($rekap) && count($rekap) > 0)
        <!-- Summary Cards -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: var(--spacing-xl);">
            <!-- Card 1: Total Santri -->
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 40px rgba(102, 126, 234, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(102, 126, 234, 0.3)';">
                <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
                    <div style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                        <i data-feather="users" style="width: 32px; height: 32px; color: white;"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="color: rgba(255,255,255,0.9); font-size: 13px; font-weight: 500; margin-bottom: 4px;">Total Santri</div>
                        <div style="color: white; font-size: 32px; font-weight: 700; line-height: 1;">{{ count($rekap) }}</div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Total Alfa -->
            <div style="background: linear-gradient(135deg, #ff6a00 0%, #ee0979 100%); border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(255, 106, 0, 0.3); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 40px rgba(255, 106, 0, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(255, 106, 0, 0.3)';">
                <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
                    <div style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                        <i data-feather="alert-circle" style="width: 32px; height: 32px; color: white;"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="color: rgba(255,255,255,0.9); font-size: 13px; font-weight: 500; margin-bottom: 4px;">Total Alfa</div>
                        <div style="color: white; font-size: 32px; font-weight: 700; line-height: 1;">{{ collect($rekap)->sum('total_alfa') }}</div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Rata-rata Alfa -->
            <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(79, 172, 254, 0.3); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 40px rgba(79, 172, 254, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(79, 172, 254, 0.3)';">
                <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
                    <div style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                        <i data-feather="trending-up" style="width: 32px; height: 32px; color: white;"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="color: rgba(255,255,255,0.9); font-size: 13px; font-weight: 500; margin-bottom: 4px;">Rata-rata Alfa</div>
                        <div style="color: white; font-size: 32px; font-weight: 700; line-height: 1;">{{ number_format(collect($rekap)->avg('total_alfa'), 1) }}</div>
                    </div>
                </div>
            </div>

            <!-- Card 4: Periode -->
            <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(240, 147, 251, 0.3); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 40px rgba(240, 147, 251, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(240, 147, 251, 0.3)';">
                <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
                    <div style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                        <i data-feather="calendar" style="width: 32px; height: 32px; color: white;"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="color: rgba(255,255,255,0.9); font-size: 13px; font-weight: 500; margin-bottom: 4px;">Periode</div>
                        <div style="color: white; font-size: 18px; font-weight: 700; line-height: 1.2;">Minggu {{ $mingguMulai }}-{{ $mingguSelesai }}<br><span style="font-size: 14px; opacity: 0.9;">{{ $tahun }}</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ranking Table -->
        <div class="card">
            <h3 class="card-header">
                Ranking Alfa - {{ $kelas->nama_kelas ?? 'Semua Kelas' }} 
                (Minggu {{ $mingguMulai }}-{{ $mingguSelesai }}, {{ $tahun }})
            </h3>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">Rank</th>
                            <th>NIS</th>
                            <th>Nama Santri</th>
                            <th style="text-align: center;">Sorogan</th>
                            <th style="text-align: center;">Menghafal Malam</th>
                            <th style="text-align: center;">Menghafal Subuh</th>
                            <th style="text-align: center;">Tahajud</th>
                            <th style="text-align: center;">Total Alfa</th>
                            <th style="text-align: center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekap as $index => $r)
                            <tr style="{{ $index < 3 ? 'background-color: #fff3cd;' : '' }}">
                                <td style="text-align: center;">
                                    @if($index == 0)
                                        <span style="font-size: 24px;">🥇</span>
                                    @elseif($index == 1)
                                        <span style="font-size: 24px;">🥈</span>
                                    @elseif($index == 2)
                                        <span style="font-size: 24px;">🥉</span>
                                    @else
                                        <strong>{{ $index + 1 }}</strong>
                                    @endif
                                </td>
                                <td>{{ $r['santri']->nis }}</td>
                                <td><strong>{{ $r['santri']->nama_santri }}</strong></td>
                                <td style="text-align: center;">
                                    <span class="badge {{ $r['sorogan'] > 5 ? 'badge-error' : ($r['sorogan'] > 0 ? 'badge-warning' : 'badge-success') }}">
                                        {{ $r['sorogan'] }}
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <span class="badge {{ $r['menghafal_malam'] > 5 ? 'badge-error' : ($r['menghafal_malam'] > 0 ? 'badge-warning' : 'badge-success') }}">
                                        {{ $r['menghafal_malam'] }}
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <span class="badge {{ $r['menghafal_subuh'] > 5 ? 'badge-error' : ($r['menghafal_subuh'] > 0 ? 'badge-warning' : 'badge-success') }}">
                                        {{ $r['menghafal_subuh'] }}
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <span class="badge {{ $r['tahajud'] > 5 ? 'badge-error' : ($r['tahajud'] > 0 ? 'badge-warning' : 'badge-success') }}">
                                        {{ $r['tahajud'] }}
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <strong style="font-size: 18px; color: {{ $r['total_alfa'] > 20 ? '#f44336' : ($r['total_alfa'] > 10 ? '#ff9800' : '#4caf50') }};">
                                        {{ $r['total_alfa'] }}
                                    </strong>
                                </td>
                                <td style="text-align: center;">
                                    @if($r['total_alfa'] == 0)
                                        <span class="badge badge-success">Sempurna</span>
                                    @elseif($r['total_alfa'] <= 5)
                                        <span class="badge badge-primary">Baik</span>
                                    @elseif($r['total_alfa'] <= 10)
                                        <span class="badge badge-warning">Perlu Perhatian</span>
                                    @else
                                        <span class="badge badge-error">Perlu Bimbingan</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background-color: #f5f5f5; font-weight: bold;">
                            <td colspan="3" style="text-align: right;">Total:</td>
                            <td style="text-align: center;">{{ collect($rekap)->sum('sorogan') }}</td>
                            <td style="text-align: center;">{{ collect($rekap)->sum('menghafal_malam') }}</td>
                            <td style="text-align: center;">{{ collect($rekap)->sum('menghafal_subuh') }}</td>
                            <td style="text-align: center;">{{ collect($rekap)->sum('tahajud') }}</td>
                            <td style="text-align: center;">{{ collect($rekap)->sum('total_alfa') }}</td>
                            <td></td>
                        </tr>
                        <tr style="background-color: #e3f2fd; font-weight: bold;">
                            <td colspan="3" style="text-align: right;">Rata-rata:</td>
                            <td style="text-align: center;">{{ number_format(collect($rekap)->avg('sorogan'), 1) }}</td>
                            <td style="text-align: center;">{{ number_format(collect($rekap)->avg('menghafal_malam'), 1) }}</td>
                            <td style="text-align: center;">{{ number_format(collect($rekap)->avg('menghafal_subuh'), 1) }}</td>
                            <td style="text-align: center;">{{ number_format(collect($rekap)->avg('tahajud'), 1) }}</td>
                            <td style="text-align: center;">{{ number_format(collect($rekap)->avg('total_alfa'), 1) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @else
        <div class="card">
            <div style="padding: var(--spacing-xl); text-align: center; color: var(--color-gray-500);">
                <i data-feather="inbox" style="width: 48px; height: 48px; margin-bottom: var(--spacing-md);"></i>
                <p>Pilih kelas, tahun, dan periode minggu untuk melihat rekap alfa & ranking</p>
            </div>
        </div>
    @endif
@endsection
