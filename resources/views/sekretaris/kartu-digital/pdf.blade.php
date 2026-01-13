<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Kartu Santri</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 40px;
        }
        .container {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            /* ID-1 Size approximation for screen/PDF */
            width: 500px;
            height: 315px;
            position: relative;
            background-color: #064e3b; /* Solid Emerald 900 - PDF Safe */
            background-image: none; /* Disable gradient for safety */
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            margin: 0 auto;
            border: 1px solid #064e3b;
            color: white;
        }

        /* Decorative Elements */
        .decor-circle {
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.03);
            border-radius: 50%;
            top: -150px;
            right: -100px;
            z-index: 1;
        }
        .decor-line {
            position: absolute;
            width: 100%;
            height: 4px;
            background: #eab308; /* Gold */
            top: 75px;
            left: 0;
            z-index: 5;
            box-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        /* Header */
        .header {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            position: relative;
            z-index: 10;
            height: 45px; /* Fixed height for top section */
        }
        .logo {
            width: 45px;
            height: 45px;
            object-fit: contain;
            float: left;
            margin-right: 12px;
        }
        .header-content {
            margin-top: 4px;
            float: left;
        }
        .school-name {
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #ffffff;
            line-height: 1.1;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        .school-desc {
            font-size: 8px;
            color: #d1fae5; /* Light green */
            margin-top: 2px;
            font-weight: 400;
        }

        /* Body Content */
        .body {
            padding: 25px 20px 10px 20px; /* Top padding pushes below gold line */
            position: relative;
            z-index: 10;
        }
        
        .photo-container {
            float: left;
            width: 85px;
            height: 105px;
            background: #e2e8f0;
            border-radius: 8px;
            border: 2px solid #eab308; /* Gold Border */
            overflow: hidden;
            margin-right: 18px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }
        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .photo-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 30px;
            font-weight: bold;
            background: #cbd5e1;
        }

        .details {
            float: left;
            width: 250px;
        }
        .detail-row {
            margin-bottom: 5px;
            font-size: 10px;
        }
        .label {
            display: inline-block;
            width: 50px;
            color: #a7f3d0; /* Soft Green */
            font-weight: 600;
            text-transform: uppercase;
        }
        .value {
            display: inline-block;
            color: white;
            font-weight: 700;
            text-transform: uppercase;
        }
        
        /* Highlighted VA Box */
        .va-container {
            margin-top: 8px;
            background: linear-gradient(90deg, rgba(234,179,8,0.2) 0%, rgba(234,179,8,0.05) 100%);
            border-left: 3px solid #eab308;
            padding: 5px 10px;
            border-radius: 0 6px 6px 0;
            position: relative;
        }
        .va-label {
            font-size: 8px;
            color: #fef08a; /* Soft Yellow */
            display: block;
            margin-bottom: 2px;
            letter-spacing: 0.5px;
        }
        .va-value {
            font-size: 14px;
            font-family: 'Courier New', monospace;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: 1px;
            text-shadow: 0 1px 2px rgba(0,0,0,0.5);
        }

        /* QR & Footer */
        .qr-section {
            position: absolute;
            bottom: 15px;
            right: 15px;
            width: 55px;
            height: 55px;
            background: white;
            padding: 3px;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 20;
        }
        .qr-section img {
            width: 100%;
            height: 100%;
        }

        .footer-watermark {
            position: absolute;
            bottom: 15px;
            left: 20px;
            font-size: 8px;
            color: rgba(255,255,255,0.4);
            font-style: italic;
        }

        .graphic-pattern {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
            border-radius: 100% 0 0 0;
            z-index: 1;
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
            <!-- Background Elements -->
            <div class="decor-circle"></div>
            <div class="graphic-pattern"></div>
            <div class="decor-line"></div>

            <!-- Header -->
            <div class="header clearfix">
                <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logo">
                <div class="header-content">
                    <div class="school-name">Ponpes Riyadlul Huda</div>
                    <div class="school-desc">Ngetsi, Tlogorejo, Tegowanu, Grobogan</div>
                </div>
            </div>

            <!-- Body -->
            <div class="body clearfix">
                <!-- Photo -->
                <div class="photo-container">
                    @if($santri->foto && file_exists(storage_path('app/public/santri-photos/' . $santri->foto)))
                        <img src="{{ storage_path('app/public/santri-photos/' . $santri->foto) }}">
                    @else
                        <div class="photo-placeholder">
                            {{ substr($santri->nama_santri, 0, 1) }}
                        </div>
                    @endif
                </div>

                <!-- Personal Info -->
                <div class="details">
                    <div class="detail-row">
                        <span class="label">Nama</span>
                        <span class="value">: {{ Str::limit(strtoupper($santri->nama_santri), 20) }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="label">NIS</span>
                        <span class="value">: {{ $santri->nis }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Kelas</span>
                        <span class="value">: {{ $santri->kelas->nama_kelas ?? '-' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Asrama</span>
                        <span class="value">: {{ Str::limit($santri->asrama->nama_asrama ?? '-', 15) }}</span>
                    </div>

                    <!-- VA Box -->
                    <div class="va-container">
                        <span class="va-label">Virtual Account (BRI)</span>
                        <span class="va-value">{{ $santri->virtual_account_number ?? 'BELUM TERSEDIA' }}</span>
                    </div>
                </div>
            </div>

            <!-- QR Code -->
            <div class="qr-section">
                @if(isset($qrBase64) && $qrBase64)
                    <img src="{{ $qrBase64 }}" alt="QR Code">
                @else
                   <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:#eee; color:#999; font-size:8px; text-align:center;">
                       NO QR
                   </div>
                @endif
            </div>

            <!-- Footer Text -->
            <div class="footer-watermark">
                Kartu Tanda Santri Digital<br>
                Berlaku Selama Menjadi Santri
            </div>

        </div>
    </div>
</body>
</html>
