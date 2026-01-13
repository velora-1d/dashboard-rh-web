<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Kartu Tanda Santri - {{ $santri->nama_santri }}</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #e2e8f0;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .container {
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 20px;
        }
        .card {
            width: 85.6mm; /* ISO ID-1 width */
            height: 53.98mm; /* ISO ID-1 height */
            /* Scale up for PDF view clarity if needed, but let's stick to standard ratio relative sizes */
            width: 550px; 
            height: 350px;
            margin: 0 auto;
            position: relative;
            /* Gradient removed for better PDF compatibility */
            background-color: #1B5E20; 
            /* background: linear-gradient(120deg, #047857 0%, #064e3b 100%); */
            border-radius: 12px;
            overflow: hidden;
            box-shadow: none; /* Shadow often causes issues in PDFs */
            border: 2px solid #14532d; /* Darker border */
            color: white;
        }
        
        /* Background decorative elements */
        .circle-bg {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.03);
            top: -100px;
            right: -50px;
            z-index: 1;
        }
        .circle-bg-2 {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.03);
            bottom: -50px;
            left: -50px;
            z-index: 1;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-0deg);
            z-index: 0; /* Changed from 2 to 0 to be BEHIND content */
            width: 100%;
            text-align: center;
            pointer-events: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            opacity: 0.1; /* Reduced opacity */
            padding: 10px 0;
        }
        .watermark-text {
            font-size: 14px; /* Slightly smaller */
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(255,255,255,0.8);
        }
        .watermark-sub {
            font-size: 9px;
            font-style: italic;
            margin-top: 2px;
            color: rgba(255,255,255,0.8);
        }

        .header {
            position: relative;
            z-index: 10;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            background: rgba(0,0,0,0.15);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .logo {
            width: 45px;
            height: 45px;
            object-fit: contain;
            float: left;
            margin-right: 12px;
        }
        .header-text {
            float: left;
            margin-top: 2px;
        }
        .school-name {
            font-size: 18px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }
        .school-address {
            font-size: 9px;
            opacity: 0.9;
            margin-top: 4px;
            font-weight: 300;
        }

        .content {
            position: relative;
            z-index: 10;
            padding: 15px 20px;
        }
        
        .photo-wrapper {
            float: left;
            width: 90px;
            height: 110px;
            background: #cbd5e1;
            border-radius: 6px;
            overflow: hidden;
            border: 2px solid rgba(255,255,255,0.5);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-right: 15px;
        }
        .photo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .info-col {
            float: left;
            width: 280px;
            padding-top: 0px;
        }
        .info-row {
            margin-bottom: 3px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding-bottom: 2px;
        }
        .info-label {
            display: inline-block;
            width: 60px;
            font-size: 9px;
            color: rgba(255,255,255,0.7);
            font-weight: 500;
        }
        .info-value {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            color: white;
            text-shadow: 0 1px 1px rgba(0,0,0,0.2);
        }

        /* Virtual Account Box */
        .va-box {
            margin-top: 10px;
            margin-bottom: 5px;
            background: rgba(0,0,0,0.2); /* Darker solid background */
            border-radius: 6px;
            padding: 6px 10px;
            display: inline-block;
            border: 1px solid rgba(255,255,255,0.15); /* Solid subtle border */
        }
        .va-label {
            font-size: 8px;
            color: #d1fae5;
            display: block;
            margin-bottom: 2px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .va-number {
            font-size: 15px;
            font-weight: 800;
            letter-spacing: 1.5px;
            font-family: 'Courier New', monospace;
            color: #fbbf24; /* Amber color for visibility */
        }

        .qr-area {
            position: absolute;
            bottom: 40px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: white;
            padding: 3px;
            border-radius: 4px;
            z-index: 10;
        }

        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: linear-gradient(to top, rgba(0,0,0,0.3), rgba(0,0,0,0));
            padding: 8px 0 12px 0;
            text-align: center;
            font-size: 7px;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.6);
            z-index: 10;
        }
        
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="circle-bg"></div>
            <div class="circle-bg-2"></div>
            
            <div class="watermark">
                <div class="watermark-text">MANAGEMENT RIYADLUL HUDA</div>
                <div class="watermark-sub">Dibuat Oleh : Mahin Utsman Nawawi, S.H</div>
            </div>

            <div class="header clearfix">
                <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logo">
                <div class="header-text">
                    <div class="school-name">PONPES RIYADLUL HUDA</div>
                    <div class="school-address">Ngetsi, Tlogorejo, Tegowanu, Grobogan</div>
                </div>
            </div>

            <div class="content clearfix">
                <div class="photo-wrapper">
                    @if($santri->foto && file_exists(storage_path('app/public/santri-photos/' . $santri->foto)))
                        <img src="{{ storage_path('app/public/santri-photos/' . $santri->foto) }}" class="photo-img">
                    @else
                        <div style="width: 100%; height: 100%; background: #94a3b8; display: flex; align-items: center; justify-content: center; color: white; font-size: 36px; font-weight: bold;">
                            {{ substr($santri->nama_santri, 0, 1) }}
                        </div>
                    @endif
                </div>

                <div class="info-col">
                    <div class="info-row">
                        <span class="info-label">NAMA</span>
                        <span class="info-value">: {{ strtoupper($santri->nama_santri) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">NIS</span>
                        <span class="info-value">: {{ $santri->nis }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">KELAS</span>
                        <span class="info-value">: {{ $santri->kelas->nama_kelas ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">ASRAMA</span>
                        <span class="info-value">: {{ $santri->asrama->nama_asrama ?? '-' }} ({{ $santri->kobong->nomor_kobong ?? '-' }})</span>
                    </div>
                    
                    <!-- Virtual Account Section -->
                    <div class="va-box">
                        <span class="va-label">NOMOR VIRTUAL ACCOUNT (VA)</span>
                        <span class="va-number">{{ $santri->virtual_account_number ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="qr-area">
                <img src="https://quickchart.io/qr?text={{ urlencode($santri->nis . ' - ' . $santri->nama_santri) }}&size=150" style="width: 100%; height: 100%;">
            </div>

            <div class="footer">
                KARTU TANDA SANTRI • BERLAKU SELAMA MENJADI SANTRI
            </div>
        </div>
    </div>
</body>
</html>
