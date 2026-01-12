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
            background-color: #f1f5f9;
        }
        .container {
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 50px;
        }
        .card {
            width: 500px; /* Approx ID-1 scaled up for A4 pdf view */
            height: 320px;
            margin: 0 auto;
            position: relative;
            background: linear-gradient(135deg, #064e3b 0%, #059669 100%);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border: 1px solid #047857;
        }
        
        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 14px;
            color: rgba(255, 255, 255, 0.08); /* Very subtle */
            white-space: nowrap;
            z-index: 0;
            width: 100%;
            text-align: center;
            pointer-events: none;
        }

        .header {
            position: relative;
            z-index: 10;
            padding: 20px;
            display: flex;
            align-items: center;
            border-bottom: 2px solid rgba(255,255,255,0.2);
            background: rgba(0,0,0,0.1);
        }
        .logo {
            width: 50px;
            height: 50px;
            object-fit: contain;
            float: left;
            margin-right: 15px;
        }
        .header-text {
            color: white;
            text-align: left;
            float: left;
        }
        .school-name {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            line-height: 1.2;
        }
        .school-sub {
            font-size: 10px;
            opacity: 0.9;
            font-weight: normal;
        }

        .content {
            position: relative;
            z-index: 10;
            padding: 20px;
            color: white;
            clear: both;
        }
        
        .photo-container {
            float: left;
            width: 100px;
            height: 120px;
            background: #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid rgba(255,255,255,0.3);
            margin-right: 20px;
        }
        .photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .details {
            float: left;
            width: 250px;
        }
        .row {
            margin-bottom: 8px;
        }
        .label {
            font-size: 10px;
            color: rgba(255,255,255,0.7);
            text-transform: uppercase;
            width: 80px;
            display: inline-block;
        }
        .value {
            font-size: 12px;
            font-weight: 600;
            color: white;
            display: inline-block;
        }
        
        .qr-container {
            position: absolute;
            bottom: 20px;
            right: 20px;
            width: 70px;
            height: 70px;
            background: white;
            border-radius: 8px;
            padding: 5px;
            z-index: 10;
        }
        
        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(0,0,0,0.2);
            padding: 8px;
            text-align: center;
            font-size: 8px;
            color: rgba(255,255,255,0.8);
            z-index: 10;
        }
        
        /* Helper for clearance */
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
            <div class="watermark">
                Management Riyadlul Huda<br>
                Created by Mahin Utsman Nawawi
            </div>

            <div class="header clearfix">
                <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logo">
                <div class="header-text">
                    <div class="school-name">PONPES RIYADLUL HUDA</div>
                    <div class="school-sub">Ngetsi, Tlogorejo, Tegowanu, Grobogan</div>
                </div>
            </div>

            <div class="content clearfix">
                <!-- Santri Photo -->
                <div class="photo-container">
                    @if($santri->foto && file_exists(storage_path('app/public/santri-photos/' . $santri->foto)))
                        <img src="{{ storage_path('app/public/santri-photos/' . $santri->foto) }}" class="photo">
                    @else
                        <!-- Fallback Avatar -->
                        <div style="width: 100%; height: 100%; background: #cbd5e1; display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 30px; font-weight: bold; text-align: center; line-height: 120px;">
                            {{ substr($santri->nama_santri, 0, 1) }}
                        </div>
                    @endif
                </div>

                <!-- Details -->
                <div class="details">
                    <div class="row">
                        <span class="label">NAMA</span>
                        <span class="value">: {{ strtoupper($santri->nama_santri) }}</span>
                    </div>
                    <div class="row">
                        <span class="label">NIS</span>
                        <span class="value">: {{ $santri->nis }}</span>
                    </div>
                    <div class="row">
                        <span class="label">KELAS</span>
                        <span class="value">: {{ $santri->kelas->nama_kelas ?? '-' }}</span>
                    </div>
                    <div class="row">
                        <span class="label">KAMAR</span>
                        <span class="value">: {{ $santri->kobong->nomor_kobong ?? '-' }}</span>
                    </div>
                    <div class="row">
                        <span class="label">ASRAMA</span>
                        <span class="value">: {{ $santri->asrama->nama_asrama ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- QR Code (Placeholder using explicit URL or API for simplicity, or just an image if text) -->
            <div class="qr-container">
                 <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($santri->nis . ' - ' . $santri->nama_santri) }}" style="width: 100%; height: 100%;">
            </div>

            <div class="footer">
                KARTU TANDA SANTRI • BERLAKU SELAMA MENJADI SANTRI
            </div>
        </div>
    </div>
</body>
</html>
