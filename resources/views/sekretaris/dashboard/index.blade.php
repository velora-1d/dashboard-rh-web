@extends('layouts.app')

@section('title', 'Dashboard Sekretaris')
@section('page-title', 'Dashboard Sekretaris')

@section('sidebar-menu')
    @include('sekretaris.partials.sidebar-menu')
@endsection

@section('bottom-nav')
    <li class="bottom-nav-item">
        <a href="{{ route('sekretaris.dashboard') }}" class="bottom-nav-link active">
            <i data-feather="home" class="bottom-nav-icon"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="bottom-nav-item">
        <a href="#" class="bottom-nav-link">
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
        <a href="{{ route('sekretaris.laporan') }}" class="bottom-nav-link">
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

@push('styles')
<style>
    /* Prevent layout shift on initial load */
    .main-content {
        min-height: 100vh;
    }
    
    /* Optimize grid rendering */
    [style*="display: grid"] {
        will-change: contents;
        contain: layout style paint;
    }
</style>
@endpush

@section('content')
    <!-- Aesthetic Header with Gradient -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 24px 32px; margin-bottom: 32px; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -30px; right: -30px; width: 120px; height: 120px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -40px; left: 40%; width: 80px; height: 80px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
            <div style="background: rgba(255,255,255,0.2); width: 56px; height: 56px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                <i data-feather="briefcase" style="width: 28px; height: 28px; color: white;"></i>
            </div>
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 700; color: white; margin: 0 0 4px 0;">Dashboard Sekretaris</h2>
                <p style="color: rgba(255,255,255,0.9); font-size: 0.875rem; margin: 0;">Kelola Data Santri, Asrama, dan Mutasi</p>
            </div>
        </div>
    </div>

    <!-- Gradient KPI Cards Row 1 -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 24px;">
        <!-- Card 1: Total Santri -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 40px rgba(102, 126, 234, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(102, 126, 234, 0.3)';">
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
                <div style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                    <i data-feather="users" style="width: 32px; height: 32px; color: white;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 13px; font-weight: 500; margin-bottom: 4px;">Total Santri</div>
                    <div style="color: white; font-size: 32px; font-weight: 700; line-height: 1;">{{ number_format($totalSantri) }}</div>
                </div>
            </div>
        </div>

        <!-- Card 2: Santri Putra -->
        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(79, 172, 254, 0.3); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 40px rgba(79, 172, 254, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(79, 172, 254, 0.3)';">
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
                <div style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                    <i data-feather="user" style="width: 32px; height: 32px; color: white;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 13px; font-weight: 500; margin-bottom: 4px;">Santri Putra</div>
                    <div style="color: white; font-size: 32px; font-weight: 700; line-height: 1;">{{ number_format($santriPutra) }}</div>
                </div>
            </div>
        </div>

        <!-- Card 3: Santri Putri -->
        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(240, 147, 251, 0.3); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 40px rgba(240, 147, 251, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(240, 147, 251, 0.3)';">
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
                <div style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                    <i data-feather="user" style="width: 32px; height: 32px; color: white;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 13px; font-weight: 500; margin-bottom: 4px;">Santri Putri</div>
                    <div style="color: white; font-size: 32px; font-weight: 700; line-height: 1;">{{ number_format($santriPutri) }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gradient KPI Cards Row 2 -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 32px;">
        <!-- Card 4: Jumlah Asrama -->
        <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(250, 112, 154, 0.3); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 40px rgba(250, 112, 154, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(250, 112, 154, 0.3)';">
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
                <div style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                    <i data-feather="home" style="width: 32px; height: 32px; color: white;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 13px; font-weight: 500; margin-bottom: 4px;">Jumlah Asrama</div>
                    <div style="color: white; font-size: 32px; font-weight: 700; line-height: 1;">{{ number_format($jumlahAsrama) }}</div>
                </div>
            </div>
        </div>

        <!-- Card 5: Jumlah Kelas -->
        <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(67, 233, 123, 0.3); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 40px rgba(67, 233, 123, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(67, 233, 123, 0.3)';">
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
                <div style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                    <i data-feather="book" style="width: 32px; height: 32px; color: white;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 13px; font-weight: 500; margin-bottom: 4px;">Jumlah Kelas</div>
                    <div style="color: white; font-size: 32px; font-weight: 700; line-height: 1;">{{ number_format($jumlahKelas) }}</div>
                </div>
            </div>
        </div>

        <!-- Card 6: Jumlah Kobong -->
        <div style="background: linear-gradient(135deg, #30cfd0 0%, #330867 100%); border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(48, 207, 208, 0.3); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 40px rgba(48, 207, 208, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(48, 207, 208, 0.3)';">
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
                <div style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                    <i data-feather="grid" style="width: 32px; height: 32px; color: white;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 13px; font-weight: 500; margin-bottom: 4px;">Jumlah Kobong</div>
                    <div style="color: white; font-size: 32px; font-weight: 700; line-height: 1;">{{ number_format($jumlahKobong) }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 32px;">
        <a href="{{ route('sekretaris.data-santri') }}" style="text-decoration: none;">
            <div class="card" style="text-align: center; transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i data-feather="users" style="width: 24px; height: 24px; color: white;"></i>
                </div>
                <h4 style="font-size: 14px; font-weight: 600; color: #1f2937; margin-bottom: 4px;">Data Santri</h4>
                <p style="font-size: 12px; color: #6b7280; margin: 0;">Kelola data santri</p>
            </div>
        </a>

        <a href="{{ route('sekretaris.data-santri.create') }}" style="text-decoration: none;">
            <div class="card" style="text-align: center; transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i data-feather="user-plus" style="width: 24px; height: 24px; color: white;"></i>
                </div>
                <h4 style="font-size: 14px; font-weight: 600; color: #1f2937; margin-bottom: 4px;">Tambah Santri</h4>
                <p style="font-size: 12px; color: #6b7280; margin: 0;">Input santri baru</p>
            </div>
        </a>

        <a href="{{ route('sekretaris.mutasi-santri') }}" style="text-decoration: none;">
            <div class="card" style="text-align: center; transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i data-feather="repeat" style="width: 24px; height: 24px; color: white;"></i>
                </div>
                <h4 style="font-size: 14px; font-weight: 600; color: #1f2937; margin-bottom: 4px;">Mutasi Santri</h4>
                <p style="font-size: 12px; color: #6b7280; margin: 0;">Kelola mutasi</p>
            </div>
        </a>

        <a href="{{ route('sekretaris.laporan') }}" style="text-decoration: none;">
            <div class="card" style="text-align: center; transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i data-feather="file-text" style="width: 24px; height: 24px; color: white;"></i>
                </div>
                <h4 style="font-size: 14px; font-weight: 600; color: #1f2937; margin-bottom: 4px;">Laporan</h4>
                <p style="font-size: 12px; color: #6b7280; margin: 0;">Cetak laporan</p>
            </div>
        </a>
    </div>

    <!-- Welcome Card with Gradient Border -->
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: 2px solid transparent; background-image: linear-gradient(white, white), linear-gradient(135deg, #667eea 0%, #764ba2 100%); background-origin: border-box; background-clip: padding-box, border-box;">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px;">
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i data-feather="smile" style="width: 24px; height: 24px; color: white;"></i>
            </div>
            <div>
                <h3 style="font-size: 18px; font-weight: 700; color: #1f2937; margin: 0;">Selamat Datang, {{ auth()->user()->name }}!</h3>
                <p style="font-size: 14px; color: #6b7280; margin: 4px 0 0 0;">Anda login sebagai <strong style="color: #667eea;">Sekretaris</strong></p>
            </div>
        </div>
        <p style="color: #4b5563; font-size: 14px; line-height: 1.6; margin: 0 0 16px 0;">
            Gunakan menu di samping atau kartu aksi cepat di atas untuk mengelola data santri, mutasi santri, dan mencetak laporan.
        </p>
        <div style="display: flex; gap: 8px;">
            <span style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">✓ Sistem Aktif</span>
            <span style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">Database: MySQL</span>
        </div>
    </div>
@endsection
