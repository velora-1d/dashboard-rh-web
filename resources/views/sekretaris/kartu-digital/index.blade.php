@extends('layouts.app')

@section('title', 'Kartu Digital')
@section('page-title', 'Kartu Syahriah Digital')

@section('sidebar-menu')
    @include('sekretaris.partials.sidebar-menu')
@endsection

@section('content')
    <!-- Aesthetic Header -->
    <div style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border-radius: 16px; padding: 24px 32px; margin-bottom: 24px; box-shadow: 0 10px 30px rgba(30, 58, 138, 0.3); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -30px; right: -30px; width: 120px; height: 120px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -40px; left: 40%; width: 80px; height: 80px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        
        <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
            <div style="background: rgba(255,255,255,0.2); width: 56px; height: 56px; border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                <i data-feather="credit-card" style="width: 28px; height: 28px; color: white;"></i>
            </div>
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 700; color: white; margin: 0 0 4px 0;">Kartu Syahriah Digital</h2>
                <p style="color: rgba(255,255,255,0.9); font-size: 0.875rem; margin: 0;">Cetak Kartu Pembayaran & Bagikan ke Wali Santri</p>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div style="background: white; border-radius: 12px; padding: 20px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <form method="GET" action="{{ route('sekretaris.kartu-digital') }}" style="display: flex; gap: 16px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 200px;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama / NIS..." style="width: 100%; padding: 10px 14px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
            </div>
            <div style="min-width: 150px;">
                <select name="kelas_id" style="width: 100%; padding: 10px 14px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" style="background: #3b82f6; color: white; border: none; padding: 0 20px; border-radius: 8px; font-weight: 600; cursor: pointer;">
                Cari
            </button>
        </form>
    </div>

    <!-- Santri List -->
    <div style="background: white; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                <tr>
                    <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Santri</th>
                    <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Info</th>
                    <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">VA Number</th>
                    <th style="padding: 16px; text-align: center; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($santris as $santri)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 16px;">
                            <div style="font-weight: 600; color: #1e293b;">{{ $santri->nama_santri }}</div>
                            <div style="font-size: 12px; color: #64748b;">{{ $santri->nis }}</div>
                        </td>
                        <td style="padding: 16px;">
                            <span style="font-size: 13px; color: #475569;">
                                {{ $santri->kelas->nama_kelas ?? '-' }} - Kobong {{ $santri->kobong->nomor_kobong ?? '-' }}
                            </span>
                        </td>
                        <td style="padding: 16px;">
                            @if($santri->virtual_account_number)
                                <span style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 99px; font-family: monospace; font-weight: 600; font-size: 13px;">
                                    {{ $santri->virtual_account_number }}
                                </span>
                            @else
                                <span style="background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 99px; font-size: 11px;">
                                    Belum Ada VA
                                </span>
                            @endif
                        </td>
                        <td style="padding: 16px; text-align: center;">
                            @if($santri->virtual_account_number)
                                <div style="display: flex; justify-content: center; gap: 8px;">
                                    <a href="#" onclick="openPreviewModels('{{ route('sekretaris.kartu-digital.preview', $santri->id) }}')" 
                                       style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 36px; background: #3b82f6; color: white; border-radius: 8px; text-decoration: none;" title="Preview Kartu">
                                        <i data-feather="eye" style="width: 16px; height: 16px;"></i>
                                    </a>

                                    <a href="{{ route('sekretaris.kartu-digital.download', $santri->id) }}" target="_blank" 
                                       style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 36px; background: #eab308; color: white; border-radius: 8px; text-decoration: none;" title="Download PDF">
                                        <i data-feather="download" style="width: 16px; height: 16px;"></i>
                                    </a>
                                    
                                    @php
                                            // Format Phone Number to International (62)
                                            $phone = $santri->no_hp_ortu_wali;
                                            if(substr($phone, 0, 1) == '0') {
                                                $phone = '62' . substr($phone, 1);
                                            }
                                            $msg = "Assalamu'alaikum, berikut kami lampirkan Kartu Pembayaran Digital ananda " . $santri->nama_santri . ". Mohon disimpan untuk kemudahan pembayaran Syahriah via Virtual Account. (Silakan download file PDF kartu ini dan kirimkan manual)";
                                            $waLink = "https://web.whatsapp.com/send?phone={$phone}&text=" . urlencode($msg);
                                        @endphp
                                        <a href="{{ $waLink }}" target="_blank" 
                                           style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 36px; background: #25D366; color: white; border-radius: 8px; text-decoration: none; transition: all 0.2s ease;" 
                                           onmouseover="this.style.filter='brightness(90%)'" onmouseout="this.style.filter='brightness(100%)'"
                                           title="Kirim Pesan WhatsApp">
                                            <!-- Official WhatsApp SVG Icon -->
                                            <svg viewBox="0 0 24 24" width="18" height="18" fill="white" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                        </a>
                                </div>
                            @else
                                <span style="font-size: 12px; color: #94a3b8; font-style: italic;">Generate VA dulu</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 40px; color: #94a3b8;">
                            Tidak ada data santri ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $santris->withQueryString()->links() }}
    </div>

    <!-- PREVIEW MODAL -->
    <div id="previewModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; justify-content: center; align-items: center;">
        <div style="background: white; width: 90%; max-width: 800px; height: 85%; border-radius: 12px; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);">
            <div style="padding: 16px 24px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; background: #f9fafb;">
                <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: #111827;">Preview Kartu</h3>
                <button onclick="closePreviewModal()" style="background: none; border: none; cursor: pointer; color: #6b7280; padding: 4px;">
                    <i data-feather="x" style="width: 24px; height: 24px;"></i>
                </button>
            </div>
            <div style="flex: 1; position: relative;">
                <iframe id="previewFrame" src="" style="width: 100%; height: 100%; border: none;"></iframe>
            </div>
        </div>
    </div>

    <script>
        function openPreviewModels(url) {
            document.getElementById('previewFrame').src = url;
            document.getElementById('previewModal').style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closePreviewModal() {
            document.getElementById('previewModal').style.display = 'none';
            document.getElementById('previewFrame').src = '';
            document.body.style.overflow = 'auto'; // Restore scrolling
        }
        
        // Close modal when clicking outside
        document.getElementById('previewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePreviewModal();
            }
        });
    </script>
@endsection
