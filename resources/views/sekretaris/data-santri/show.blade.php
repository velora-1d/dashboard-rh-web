@extends('layouts.app')

@section('title', 'Detail Santri - ' . $santri->nama_santri)
@section('page-title', 'Detail Santri')

@section('sidebar-menu')
    @include('sekretaris.partials.sidebar-menu')
@endsection

@section('content')
<div style="width: 100%; max-width: 100%;">
    <!-- Top Action & Navigation -->
    <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <a href="{{ route('sekretaris.data-santri') }}" style="display: inline-flex; align-items: center; gap: 8px; color: #475569; text-decoration: none; font-weight: 600; font-size: 14px; background: white; padding: 10px 18px; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.03); transition: all 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='white';">
            <i data-feather="arrow-left" style="width: 18px; height: 18px;"></i>
            Kembali ke Data Santri
        </a>
        @if(auth()->user()->role !== 'rois')
        <a href="{{ route('sekretaris.data-santri.edit', $santri->id) }}" style="display: inline-flex; align-items: center; gap: 8px; color: white; text-decoration: none; font-weight: 600; font-size: 14px; background: linear-gradient(135deg, #059669 0%, #0d9488 100%); padding: 10px 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
            <i data-feather="edit-2" style="width: 18px; height: 18px;"></i>
            Edit Data Santri
        </a>
        @endif
    </div>

    <!-- Header Banner -->
    <div style="background: linear-gradient(135deg, #059669 0%, #0d9488 100%); border-radius: 20px; padding: 32px; margin-bottom: 24px; box-shadow: 0 10px 30px rgba(5, 150, 105, 0.3); position: relative; overflow: hidden; color: white;">
        <div style="position: absolute; top: -40px; right: -40px; width: 160px; height: 160px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
        
        <div style="display: flex; align-items: center; gap: 24px; position: relative; z-index: 1; flex-wrap: wrap;">
            <!-- Profile Photo / Avatar -->
            <div style="width: 90px; height: 90px; border-radius: 20px; overflow: hidden; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border: 3px solid rgba(255,255,255,0.4); display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 8px 20px rgba(0,0,0,0.15);">
                @if($santri->foto && \Illuminate\Support\Facades\Storage::exists('public/santri-photos/' . $santri->foto))
                    <img src="{{ asset('storage/santri-photos/' . $santri->foto) }}" alt="{{ $santri->nama_santri }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <div style="font-size: 36px; font-weight: 800; color: white;">{{ substr($santri->nama_santri, 0, 1) }}</div>
                @endif
            </div>

            <div style="flex: 1; min-width: 250px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px; flex-wrap: wrap;">
                    <span style="background: rgba(255,255,255,0.25); backdrop-filter: blur(10px); padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                        NIS: {{ $santri->nis }}
                    </span>
                    <span style="background: {{ $santri->gender == 'putra' ? 'rgba(59, 130, 246, 0.3)' : 'rgba(236, 72, 153, 0.3)' }}; backdrop-filter: blur(10px); padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                        {{ ucfirst($santri->gender) }}
                    </span>
                    <span style="background: {{ $santri->is_active ? 'rgba(34, 197, 94, 0.3)' : 'rgba(239, 68, 68, 0.3)' }}; backdrop-filter: blur(10px); padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                        {{ $santri->is_active ? 'Santri Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <h1 style="font-size: 2rem; font-weight: 800; margin: 0 0 6px 0;">{{ $santri->nama_santri }}</h1>
                <p style="margin: 0; color: rgba(255,255,255,0.9); font-size: 14px;">
                    Kelas {{ $santri->kelas->nama_kelas ?? '-' }} · {{ $santri->asrama->nama_asrama ?? '-' }} (Kobong {{ $santri->kobong->nomor_kobong ?? '-' }})
                </p>
            </div>
        </div>
    </div>

    <!-- Main Detail Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
        
        <!-- Card 1: Informasi Akademik & Pesantren -->
        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px;">
                <div style="background: #ecfdf5; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #059669;">
                    <i data-feather="book-open" style="width: 20px; height: 20px;"></i>
                </div>
                <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0;">Informasi Akademik</h3>
            </div>

            <div style="display: flex; flex-direction: column; gap: 16px;">
                <div>
                    <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;">Nomor Induk Santri (NIS)</div>
                    <div style="font-size: 15px; font-weight: 700; color: #1e293b; margin-top: 2px;">{{ $santri->nis }}</div>
                </div>

                <div>
                    <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;">Virtual Account (VA)</div>
                    <div style="font-size: 15px; font-weight: 700; color: #059669; margin-top: 2px; font-family: monospace;">{{ $santri->virtual_account_number ?? 'Belum ter-generate' }}</div>
                </div>

                <div>
                    <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;">Kelas Diniyah</div>
                    <div style="font-size: 14px; font-weight: 600; color: #334155; margin-top: 2px;">{{ $santri->kelas->nama_kelas ?? '-' }}</div>
                </div>

                <div>
                    <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;">Asrama & Kobong</div>
                    <div style="font-size: 14px; font-weight: 600; color: #334155; margin-top: 2px;">
                        {{ $santri->asrama->nama_asrama ?? '-' }} - Kobong {{ $santri->kobong->nomor_kobong ?? '-' }}
                    </div>
                </div>

                <div>
                    <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;">Tanggal Masuk</div>
                    <div style="font-size: 14px; font-weight: 600; color: #334155; margin-top: 2px;">
                        {{ $santri->tanggal_masuk ? $santri->tanggal_masuk->translatedFormat('d F Y') : '-' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Informasi Orang Tua / Wali -->
        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px;">
                <div style="background: #ecfdf5; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #059669;">
                    <i data-feather="users" style="width: 20px; height: 20px;"></i>
                </div>
                <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0;">Orang Tua / Wali</h3>
            </div>

            <div style="display: flex; flex-direction: column; gap: 16px;">
                <div>
                    <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;">Nama Orang Tua / Wali</div>
                    <div style="font-size: 15px; font-weight: 700; color: #1e293b; margin-top: 2px;">{{ $santri->nama_ortu_wali ?? '-' }}</div>
                </div>

                <div>
                    <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;">Nomor HP / WhatsApp Ortu</div>
                    <div style="font-size: 14px; font-weight: 600; color: #334155; margin-top: 4px; display: flex; align-items: center; gap: 8px;">
                        <span>{{ $santri->no_hp_ortu_wali ?? '-' }}</span>
                        @if($santri->no_hp_ortu_wali)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $santri->no_hp_ortu_wali) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 4px; background: #25d366; color: white; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-decoration: none;">
                                <i data-feather="message-circle" style="width: 12px; height: 12px;"></i>
                                Chat WA
                            </a>
                        @endif
                    </div>
                </div>

                <div>
                    <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;">Tanggal Lahir Santri</div>
                    <div style="font-size: 14px; font-weight: 600; color: #334155; margin-top: 2px;">
                        {{ $santri->tanggal_lahir ? $santri->tanggal_lahir->translatedFormat('d F Y') : '-' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Alamat Domisili -->
        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px;">
                <div style="background: #ecfdf5; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #059669;">
                    <i data-feather="map-pin" style="width: 20px; height: 20px;"></i>
                </div>
                <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0;">Alamat Asal / Domisili</h3>
            </div>

            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #f8fafc; padding-bottom: 8px;">
                    <span style="font-size: 12px; color: #64748b; font-weight: 600;">Desa / Kampung</span>
                    <span style="font-size: 13px; color: #1e293b; font-weight: 700;">{{ $santri->desa_kampung ?? '-' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #f8fafc; padding-bottom: 8px;">
                    <span style="font-size: 12px; color: #64748b; font-weight: 600;">RT / RW</span>
                    <span style="font-size: 13px; color: #1e293b; font-weight: 700;">{{ $santri->rt_rw ?? '-' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #f8fafc; padding-bottom: 8px;">
                    <span style="font-size: 12px; color: #64748b; font-weight: 600;">Kecamatan</span>
                    <span style="font-size: 13px; color: #1e293b; font-weight: 700;">{{ $santri->kecamatan ?? '-' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #f8fafc; padding-bottom: 8px;">
                    <span style="font-size: 12px; color: #64748b; font-weight: 600;">Kota / Kabupaten</span>
                    <span style="font-size: 13px; color: #1e293b; font-weight: 700;">{{ $santri->kota_kabupaten ?? '-' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #f8fafc; padding-bottom: 8px;">
                    <span style="font-size: 12px; color: #64748b; font-weight: 600;">Provinsi</span>
                    <span style="font-size: 13px; color: #1e293b; font-weight: 700;">{{ $santri->provinsi ?? '-' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="font-size: 12px; color: #64748b; font-weight: 600;">Negara</span>
                    <span style="font-size: 13px; color: #1e293b; font-weight: 700;">{{ $santri->negara ?? 'Indonesia' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
