@extends('layouts.app')

@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('sidebar-menu')
    @include('sekretaris.partials.sidebar-menu')
@endsection

@section('bottom-nav')
    <li class="bottom-nav-item">
        <a href="{{ route('sekretaris.dashboard') }}" class="bottom-nav-link">
            <i data-feather="home" class="bottom-nav-icon"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="bottom-nav-item">
        <a href="{{ route('sekretaris.data-santri') }}" class="bottom-nav-link">
            <i data-feather="users" class="bottom-nav-icon"></i>
            <span>Santri</span>
        </a>
    </li>
    <li class="bottom-nav-item">
        <a href="{{ route('sekretaris.mutasi-santri') }}" class="bottom-nav-link">
            <i data-feather="repeat" class="bottom-nav-icon"></i>
            <span>Mutasi</span>
        </a>
    </li>
    <li class="bottom-nav-item">
        <a href="{{ route('sekretaris.laporan') }}" class="bottom-nav-link active">
            <i data-feather="file-text" class="bottom-nav-icon"></i>
            <span>Laporan</span>
        </a>
    </li>
@endsection

@section('drawer-menu')
    <li class="drawer-menu-item">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="drawer-menu-link" style="width: 100%; background: none; border: none; cursor: pointer; text-align: left;">
                <i data-feather="log-out"></i>
                <span>Logout</span>
            </button>
        </form>
    </li>
@endsection

@section('content')
    <!-- Aesthetic Header with Gradient -->
    <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 16px; padding: 24px 32px; margin-bottom: 32px; box-shadow: 0 10px 30px rgba(79, 172, 254, 0.3); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -30px; right: -30px; width: 120px; height: 120px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -40px; left: 40%; width: 80px; height: 80px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
            <div style="background: rgba(255,255,255,0.2); width: 56px; height: 56px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                <i data-feather="file-text" style="width: 28px; height: 28px; color: white;"></i>
            </div>
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 700; color: white; margin: 0 0 4px 0;">Laporan</h2>
                <p style="color: rgba(255,255,255,0.9); font-size: 0.875rem; margin: 0;">Export dan Cetak Berbagai Laporan Data Santri</p>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
        <!-- Laporan Data Santri -->
        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-left: 4px solid #667eea; transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)';">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-feather="users" style="width: 20px; height: 20px; color: white;"></i>
                </div>
                <h3 style="font-size: 16px; font-weight: 600; color: #1f2937; margin: 0;">Laporan Data Santri</h3>
            </div>
            <p style="font-size: 14px; color: #6b7280; line-height: 1.6; margin-bottom: 20px;">
                Export data seluruh santri aktif beserta informasi lengkap (kelas, asrama, kobong, alamat, orang tua).
            </p>
            <a href="{{ route('sekretaris.laporan.export-santri') }}" class="btn btn-primary" target="_blank" style="width: 100%; justify-content: center;">
                <i data-feather="download" style="width: 16px; height: 16px;"></i>
                Export Data Santri
            </a>
        </div>

        <!-- Laporan Mutasi Santri -->
        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-left: 4px solid #fa709a; transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)';">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-feather="repeat" style="width: 20px; height: 20px; color: white;"></i>
                </div>
                <h3 style="font-size: 16px; font-weight: 600; color: #1f2937; margin: 0;">Laporan Mutasi Santri</h3>
            </div>
            <p style="font-size: 14px; color: #6b7280; line-height: 1.6; margin-bottom: 16px;">
                Export riwayat mutasi santri (masuk, keluar, pindah kelas, pindah asrama).
            </p>
            <form method="GET" action="{{ route('sekretaris.laporan.export-mutasi') }}" target="_blank">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 16px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label" style="font-size: 12px;">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-input" style="font-size: 13px;">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label" style="font-size: 12px;">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-input" style="font-size: 13px;">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label" style="font-size: 12px;">Jenis Mutasi</label>
                        <select name="jenis_mutasi" class="form-select" style="font-size: 13px;">
                            <option value="">Semua</option>
                            <option value="masuk">Masuk</option>
                            <option value="keluar">Keluar</option>
                            <option value="pindah_kelas">Pindah Kelas</option>
                            <option value="pindah_asrama">Pindah Asrama</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                    <i data-feather="download" style="width: 16px; height: 16px;"></i>
                    Export Laporan Mutasi
                </button>
            </form>
        </div>

        <!-- Statistik Santri per Kelas -->
        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-left: 4px solid #43e97b; transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)';">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-feather="bar-chart-2" style="width: 20px; height: 20px; color: white;"></i>
                </div>
                <h3 style="font-size: 16px; font-weight: 600; color: #1f2937; margin: 0;">Statistik Santri per Kelas</h3>
            </div>
            <p style="font-size: 14px; color: #6b7280; line-height: 1.6; margin-bottom: 20px;">
                Laporan jumlah santri per kelas dengan breakdown gender (putra/putri).
            </p>
            <a href="{{ route('sekretaris.laporan.export-statistik-kelas') }}" class="btn btn-primary" target="_blank" style="width: 100%; justify-content: center;">
                <i data-feather="download" style="width: 16px; height: 16px;"></i>
                Export Statistik Kelas
            </a>
        </div>

        <!-- Statistik Santri per Asrama -->
        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-left: 4px solid #4facfe; transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)';">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-feather="home" style="width: 20px; height: 20px; color: white;"></i>
                </div>
                <h3 style="font-size: 16px; font-weight: 600; color: #1f2937; margin: 0;">Statistik Santri per Asrama</h3>
            </div>
            <p style="font-size: 14px; color: #6b7280; line-height: 1.6; margin-bottom: 20px;">
                Laporan jumlah santri per asrama dan kobong dengan informasi kapasitas.
            </p>
            <a href="{{ route('sekretaris.laporan.export-statistik-asrama') }}" class="btn btn-primary" target="_blank" style="width: 100%; justify-content: center;">
                <i data-feather="download" style="width: 16px; height: 16px;"></i>
                Export Statistik Asrama
            </a>
        </div>
    </div>
@endsection
