<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ijazah {{ ucfirst($type) }} - {{ $dataIjazah[0]['santri']->nama_santri ?? 'Santri' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Great+Vibes&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    
    <style>
        /* CSS RESET & VARS */
        :root {
            --primary-green: #0d5f2d;
            --gold: #c9a227;
            --gold-light: #e8d174;
            --dark-green: #0a4a23;
        }
        
        /* PAGE SETUP FOR PRINT - A4 Portrait */
        @page {
            size: A4 portrait;
            margin: 0;
        }

        /* GLOBAL STYLES */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
            background-color: #525659;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* CERTIFICATE CONTAINER */
        .certificate-page {
            width: 210mm;
            height: 297mm;
            background: linear-gradient(135deg, #f8f6f0 0%, #fff 50%, #f8f6f0 100%);
            margin: 20px auto;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            page-break-after: always;
        }

        @media print {
            body { background: white; }
            .certificate-page {
                margin: 0;
                box-shadow: none;
            }
            .no-print { display: none !important; }
        }

        /* WATERMARK TEXT - CURVED */
        .watermark-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 72pt;
            font-weight: 900;
            font-family: 'Playfair Display', serif;
            color: var(--primary-green);
            opacity: 0.03;
            letter-spacing: 8px;
            white-space: nowrap;
            pointer-events: none;
            z-index: 1;
            text-transform: uppercase;
        }
        .watermark-text-2 {
            position: absolute;
            top: 35%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 52pt;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            color: var(--gold);
            opacity: 0.04;
            letter-spacing: 6px;
            white-space: nowrap;
            pointer-events: none;
            z-index: 1;
            text-transform: uppercase;
        }
        .watermark-text-3 {
            position: absolute;
            top: 65%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 52pt;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            color: var(--gold);
            opacity: 0.04;
            letter-spacing: 6px;
            white-space: nowrap;
            pointer-events: none;
            z-index: 1;
            text-transform: uppercase;
        }

        /* DECORATIVE CORNERS */
        .corner-decoration {
            position: absolute;
            width: 120px;
            height: 120px;
        }
        .corner-tl {
            top: 0; left: 0;
            background: linear-gradient(135deg, var(--dark-green) 0%, transparent 70%);
            border-radius: 0 0 100% 0;
        }
        .corner-tr {
            top: 0; right: 0;
            background: linear-gradient(-135deg, var(--dark-green) 0%, transparent 70%);
            border-radius: 0 0 0 100%;
        }
        .corner-bl {
            bottom: 0; left: 0;
            background: linear-gradient(45deg, var(--dark-green) 0%, transparent 70%);
            border-radius: 0 100% 0 0;
        }
        .corner-br {
            bottom: 0; right: 0;
            background: linear-gradient(-45deg, var(--dark-green) 0%, transparent 70%);
            border-radius: 100% 0 0 0;
        }

        /* GOLD RIBBON EFFECT */
        .ribbon {
            position: absolute;
            width: 200px;
            height: 30px;
            background: linear-gradient(90deg, transparent, var(--gold-light), var(--gold), var(--gold-light), transparent);
        }
        .ribbon-tl {
            top: 60px; left: -30px;
            transform: rotate(-45deg);
        }
        .ribbon-tr {
            top: 60px; right: -30px;
            transform: rotate(45deg);
        }
        .ribbon-bl {
            bottom: 60px; left: -30px;
            transform: rotate(45deg);
        }
        .ribbon-br {
            bottom: 60px; right: -30px;
            transform: rotate(-45deg);
        }

        /* BORDER FRAME */
        .border-frame {
            position: absolute;
            top: 20px; left: 20px; right: 20px; bottom: 20px;
            border: 3px solid var(--gold);
            pointer-events: none;
        }
        .border-frame-inner {
            position: absolute;
            top: 28px; left: 28px; right: 28px; bottom: 28px;
            border: 1px solid var(--gold);
            pointer-events: none;
        }

        /* CONTENT AREA */
        .content {
            position: relative;
            z-index: 10;
            padding: 50px 60px;
            text-align: center;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        /* HEADER WITH LOGOS */
        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 15px;
        }
        .logo {
            width: 90px;
            height: 90px;
            object-fit: contain;
        }
        .header-text {
            text-align: center;
        }
        .yayasan-name {
            font-size: 11pt;
            font-weight: 600;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .pondok-name {
            font-size: 16pt;
            font-weight: 700;
            color: var(--primary-green);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 3px 0;
        }
        .pondok-address {
            font-size: 8pt;
            color: #666;
        }

        /* TITLE */
        .title-section {
            margin: 20px 0;
        }
        .certificate-title {
            font-family: 'Playfair Display', serif;
            font-size: 42pt;
            font-weight: 700;
            color: var(--primary-green);
            text-transform: uppercase;
            letter-spacing: 8px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        .certificate-subtitle {
            font-family: 'Playfair Display', serif;
            font-size: 18pt;
            font-weight: 600;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 4px;
            margin-top: 5px;
        }
        .ijazah-type {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            color: white;
            padding: 8px 30px;
            border-radius: 30px;
            font-size: 12pt;
            font-weight: 600;
            margin-top: 10px;
            letter-spacing: 2px;
        }

        /* PRESENTED TO TEXT */
        .presented-to {
            font-size: 11pt;
            color: #555;
            margin: 20px 0 10px 0;
            letter-spacing: 1px;
        }

        /* NAME */
        .student-name {
            font-family: 'Great Vibes', cursive;
            font-size: 42pt;
            color: var(--primary-green);
            padding: 10px 0;
            border-bottom: 2px solid var(--gold);
            display: inline-block;
            min-width: 400px;
        }
        .student-nis {
            font-size: 10pt;
            color: #666;
            margin-top: 5px;
            letter-spacing: 1px;
        }

        /* DESCRIPTION */
        .description {
            font-size: 11pt;
            line-height: 1.8;
            color: #444;
            margin: 20px auto;
            max-width: 500px;
        }

        /* GRADE BOX - PREMIUM DESIGN */
        .grade-box {
            background: linear-gradient(145deg, #fffef8 0%, #faf8f0 30%, #f5f3e8 70%, #f0ede0 100%);
            border: 3px solid transparent;
            background-clip: padding-box;
            position: relative;
            border-radius: 20px;
            padding: 25px 50px;
            display: inline-block;
            margin: 20px 0;
            box-shadow: 
                0 15px 35px rgba(201, 162, 39, 0.15),
                0 8px 15px rgba(0, 0, 0, 0.08),
                0 3px 6px rgba(0, 0, 0, 0.05),
                inset 0 2px 4px rgba(255, 255, 255, 0.95),
                inset 0 -1px 2px rgba(0, 0, 0, 0.05);
            min-width: 280px;
        }
        .grade-box::before {
            content: '';
            position: absolute;
            top: -3px; left: -3px; right: -3px; bottom: -3px;
            background: linear-gradient(135deg, 
                #f4e4a6 0%, 
                #d4af37 20%, 
                #c9a227 40%, 
                #d4af37 60%, 
                #f4e4a6 80%, 
                #d4af37 100%);
            border-radius: 20px;
            z-index: -1;
            box-shadow: 0 4px 12px rgba(201, 162, 39, 0.3);
        }
        .grade-box::after {
            content: '';
            position: absolute;
            top: 5px; left: 5px; right: 5px; bottom: 5px;
            border-radius: 17px;
            background: linear-gradient(180deg, 
                rgba(255, 255, 255, 0.4) 0%, 
                transparent 50%, 
                rgba(0, 0, 0, 0.02) 100%);
            pointer-events: none;
        }
        .grade-label {
            font-size: 9pt;
            color: #888;
            margin-bottom: 10px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .grade-value {
            font-size: 42pt;
            font-weight: 900;
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: none;
            letter-spacing: -2px;
            line-height: 1;
            margin: 5px 0;
        }
        .grade-predikat {
            font-size: 12pt;
            font-weight: 700;
            background: linear-gradient(135deg, var(--gold) 0%, #b8941f 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-top: 8px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* SIGNATURES */
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: auto;
            padding-top: 30px;
            margin-bottom: 90px; /* Added margin to avoid barcode overlap */
        }
        .signature-box {
            width: 35%;
            text-align: center;
            position: relative; /* Added for absolute signature positioning */
        }
        .signature-title {
            font-size: 10pt;
            color: #555;
            margin-bottom: 85px; /* Increased slightly */
        }
        .signature-image {
            height: 130px; /* Increased from 110px */
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            bottom: 20px; /* Lowered to touch name better */
            z-index: 5;
            pointer-events: none;
        }
        .signature-name {
            font-weight: 700;
            font-size: 11pt;
            border-top: 1px solid #333;
            padding-top: 5px;
            display: inline-block;
            min-width: 150px;
        }
        .signature-nip {
            font-size: 9pt;
            color: #666;
        }

        /* SEAL/STAMP */
        .seal {
            position: absolute;
            bottom: 180px;
            left: 50%;
            transform: translateX(-50%);
            width: 95px;
            height: 95px;
            background: linear-gradient(145deg, #f4e4a6 0%, #d4af37 30%, #c9a227 50%, #b8941f 70%, #d4af37 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 
                0 10px 25px rgba(201, 162, 39, 0.4),
                0 4px 8px rgba(0, 0, 0, 0.15),
                inset 0 2px 4px rgba(255, 255, 255, 0.5),
                inset 0 -2px 4px rgba(0, 0, 0, 0.2);
            position: relative;
        }
        .seal::before {
            content: '';
            position: absolute;
            top: 3px; left: 3px; right: 3px; bottom: 3px;
            border-radius: 50%;
            background: linear-gradient(145deg, transparent 0%, rgba(255, 255, 255, 0.3) 50%, transparent 100%);
            pointer-events: none;
        }
        .seal-inner {
            width: 70px;
            height: 70px;
            border: 2.5px solid rgba(139, 69, 19, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
        }
        .seal-inner svg {
            filter: drop-shadow(0 2px 3px rgba(0, 0, 0, 0.2));
        }

        /* QR/BARCODE FOOTER */
        .footer {
            position: absolute;
            bottom: 45px; /* Increased from 25px to avoid border overlap */
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.9);
            padding: 8px 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .qr-code {
            width: 40px;
            height: 40px;
            border: 1px solid #ccc;
        }
        .footer-text {
            font-size: 7pt;
            color: #555;
            text-align: left;
            line-height: 1.3;
        }
        .doc-number {
            font-weight: 700;
        }

        /* NOMOR IJAZAH */
        .nomor-ijazah {
            position: absolute;
            top: 35px;
            right: 50px;
            font-size: 9pt;
            color: #666;
        }

        /* FAB PRINT BUTTON */
        .fab-print {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: var(--primary-green);
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            cursor: pointer;
            z-index: 1000;
            transition: transform 0.2s;
            border: none;
            font-size: 24px;
        }
        .fab-print:hover { transform: scale(1.1); }
    </style>
</head>
<body style="margin: 0; padding: 0; background: #525659;">
    <div id="pdf-content">
    @foreach($dataIjazah as $index => $data)
    @php
        $santri = $data['santri'];
        $rataRata = $data['rataRata'];
        $nomorIjazah = $data['nomorIjazah'];
        $nip = $data['nip'];
        
        // Calculate predikat
        if ($rataRata >= 85) $predikat = 'Sangat Baik';
        elseif ($rataRata >= 70) $predikat = 'Baik';
        elseif ($rataRata >= 60) $predikat = 'Cukup';
        else $predikat = 'Kurang';
        
        $jenisIjazah = $type === 'ibtida' ? 'IBTIDA' : 'TSANAWI';
        $jenjang = $type === 'ibtida' ? 'Pendidikan Diniyah Takmiliyah Awaliyah (IBTIDA)' : 'Pendidikan Diniyah Takmiliyah Wustha (TSANAWI)';
    @endphp

    <div class="certificate-page">
        <!-- Decorative Corners -->
        <div class="corner-decoration corner-tl"></div>
        <div class="corner-decoration corner-tr"></div>
        <div class="corner-decoration corner-bl"></div>
        <div class="corner-decoration corner-br"></div>

        <!-- Gold Ribbons -->
        <div class="ribbon ribbon-tl"></div>
        <div class="ribbon ribbon-tr"></div>
        <div class="ribbon ribbon-bl"></div>
        <div class="ribbon ribbon-br"></div>

        <!-- Border Frame -->
        <div class="border-frame"></div>
        <div class="border-frame-inner"></div>

        <!-- Watermark Text - Curved Background -->
        <div class="watermark-text">RIYADLUL HUDA</div>
        <div class="watermark-text-2">RIYADLUL HUDA</div>
        <div class="watermark-text-3">RIYADLUL HUDA</div>

        <!-- Nomor Ijazah -->
        <div class="nomor-ijazah">
            No: <strong>{{ $nomorIjazah }}</strong>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Header with Logos -->
            <div class="header">
                @if($reportSettings->logo_pondok_path)
                    <img src="{{ asset('storage/' . $reportSettings->logo_pondok_path) }}" class="logo" alt="Logo Yayasan">
                @endif
                
                <div class="header-text">
                    <div class="yayasan-name">{{ $reportSettings->nama_yayasan ?? 'Yayasan Riyadlul Huda' }}</div>
                    <div class="pondok-name">{{ $reportSettings->nama_pondok ?? 'Pondok Pesantren Riyadlul Huda' }}</div>
                    <div class="pondok-address">{{ $reportSettings->alamat ?? 'Alamat Pondok' }}</div>
                </div>
                
                @if($reportSettings->logo_pendidikan_path)
                    <img src="{{ asset('storage/' . $reportSettings->logo_pendidikan_path) }}" class="logo" alt="Logo Pendidikan">
                @endif
            </div>

            <!-- Title Section -->
            <div class="title-section">
                <div class="certificate-title">IJAZAH</div>
                <div class="certificate-subtitle">SERTIFIKAT KELULUSAN</div>
                <div class="ijazah-type">{{ $jenisIjazah }}</div>
            </div>

            <!-- Presented To -->
            <div class="presented-to">
                DENGAN RAHMAT ALLAH SWT, DIBERIKAN KEPADA:
            </div>

            <!-- Student Name -->
            <div class="student-name">{{ $santri->nama_santri }}</div>
            <div class="student-nis">NIS: {{ $santri->nis }}</div>

            <!-- Description -->
            <div class="description">
                Telah menyelesaikan {{ $jenjang }} pada {{ $reportSettings->nama_pondok ?? 'Pondok Pesantren Riyadlul Huda' }}
                dengan hasil nilai rata-rata sebagai berikut:
            </div>

            <!-- Grade Box -->
            <div class="grade-box">
                <div class="grade-label">NILAI RATA-RATA</div>
                <div class="grade-value">{{ number_format($rataRata, 1) }}</div>
                <div class="grade-predikat">Predikat: {{ $predikat }}</div>
            </div>

            <!-- Signatures -->
            <div class="signatures">
                <!-- Wali Kelas -->
                <div class="signature-box">
                    <div class="signature-title">Wali Kelas</div>
                    @php 
                        $waliKelasName = $santri->kelas->getWaliKelasName($santri->gender ?? 'L');
                        $waliKelasTtd = $santri->kelas->getWaliKelasTtd($santri->gender ?? 'L');
                    @endphp
                    @if($waliKelasTtd)
                        <img src="{{ asset('storage/' . $waliKelasTtd) }}" class="signature-image">
                    @else
                        <div style="height: 110px;"></div> {{-- Placeholder space --}}
                    @endif
                    <div class="signature-name">{{ $waliKelasName ?? '............................' }}</div>
                    <div class="signature-nip">NIP: {{ $nip }}</div>
                </div>

                <!-- Pimpinan -->
                <div class="signature-box">
                    <div class="signature-title">
                        {{ $reportSettings->kota_terbit ?? 'Jombang' }}, {{ $settings->tanggal_ijazah?->translatedFormat('d F Y') ?? now()->translatedFormat('d F Y') }}<br>
                        Pimpinan Umum
                    </div>
                    @if($reportSettings->pimpinan_ttd_path)
                        <img src="{{ asset('storage/' . $reportSettings->pimpinan_ttd_path) }}" class="signature-image">
                    @else
                        <div style="height: 110px;"></div> {{-- Placeholder space --}}
                    @endif
                    <div class="signature-name">{{ $reportSettings->pimpinan_nama ?? '............................' }}</div>
                    <div class="signature-nip">NIP: {{ \App\Models\IjazahSetting::generateNIP('PTU') }}</div>
                </div>
            </div>

            <!-- Seal -->
            <div class="seal">
                <div class="seal-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 45px; height: 45px; color: #5a4a1b;">
                        <path fill-rule="evenodd" d="M5.166 2.621v.858c-1.035.148-2.059.33-3.071.543a.75.75 0 0 0-.584.859 6.753 6.753 0 0 0 6.138 5.6 6.73 6.73 0 0 0 2.743 1.346A6.707 6.707 0 0 1 9.279 15H8.54c-1.036 0-1.875.84-1.875 1.875V19.5h-.75a2.25 2.25 0 0 0-2.25 2.25c0 .414.336.75.75.75h15a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-2.25-2.25h-.75v-2.625c0-1.036-.84-1.875-1.875-1.875h-.739a6.706 6.706 0 0 1-1.112-3.173 6.73 6.73 0 0 0 2.743-1.347 6.753 6.753 0 0 0 6.139-5.6.75.75 0 0 0-.585-.858 47.077 47.077 0 0 0-3.07-.543V2.62a.75.75 0 0 0-.658-.744 49.22 49.22 0 0 0-6.093-.377c-2.063 0-4.096.128-6.093.377a.75.75 0 0 0-.657.744Zm0 2.629c0 1.196.312 2.32.857 3.294A5.266 5.266 0 0 1 3.16 5.337a45.6 45.6 0 0 1 2.006-.343v.256Zm13.5 0v-.256c.674.1 1.343.214 2.006.343a5.265 5.265 0 0 1-2.863 3.207 6.72 6.72 0 0 0 .857-3.294Z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- QR/Barcode Footer -->
        <div class="footer">
            @php
                $qrMessage = "DOKUMEN RESMI YAYASAN PONDOK PESANTREN RIYADLUL HUDA. Ijazah ini dinyatakan SAH dan VALID untuk Santri: " . $santri->nama_santri . " - No: " . $nomorIjazah . ". Ditandatangani secara elektronik pada " . ($settings->tanggal_ijazah?->translatedFormat('d F Y') ?? now()->translatedFormat('d F Y')) . ".";
            @endphp
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($qrMessage) }}" 
                 class="qr-code" alt="QR Code">
            <div class="footer-text">
                <strong>DOKUMEN SAH</strong> - Ijazah ini ditandatangani secara elektronik.<br>
                Nomor Dokumen: <span class="doc-number">{{ $nomorIjazah }}</span>
            </div>
        </div>
    </div>
    @endforeach
    </div>

    <!-- PDF DOWNLOAD CONTROLS (Hidden in Print) -->
    <div id="download-controls" style="position: fixed; top: 20px; right: 20px; z-index: 1000; background: white; padding: 15px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); border: 1px solid #f59e0b; display: flex; flex-direction: column; gap: 10px; font-family: sans-serif;">
        <div style="font-weight: bold; color: #92400e; font-size: 14px; margin-bottom: 5px;">Opsi Ijazah</div>
        <button onclick="window.print()" style="padding: 8px 15px; background: #f3f4f6; border: 1px solid #d1d5db; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; color: #374151; display: flex; align-items: center; gap: 8px;">
            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak (Print)
        </button>
        <a href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->all(), ['download' => '1'])) }}" 
           style="padding: 10px 15px; background: #f59e0b; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 700; color: white; display: flex; align-items: center; gap: 8px; box-shadow: 0 2px 5px rgba(245,158,11,0.3); text-decoration: none;">
            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Unduh PDF
        </a>
    </div>

    <style>
        @media print {
            .no-print, #download-controls { display: none !important; }
        }
    </style>

</body>
</html>
