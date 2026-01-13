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
            display: flex; /* Keeping flex for centering on preview, might need fallback for PDF if strictly ignored */
            justify-content: center;
            align-items: center;
        }
        .card {
            /* ID-1 Size approximation for screen/PDF */
            width: 500px;
            height: 315px;
            position: relative;
            background-color: #064e3b; /* Solid Emerald 900 */
            border-radius: 12px;
            overflow: hidden;
            /* Removed box-shadow (rgba) */
            margin: 0 auto;
            border: 1px solid #064e3b;
            color: white;
        }

        /* Decorative Elements - SOLID COLORS ONLY */
        .decor-circle {
            position: absolute;
            width: 400px;
            height: 400px;
            background-color: #065f46; /* Solid Emerald 800 (Lightened bg) - Replaces transparent white */
            border-radius: 50%;
            top: -150px;
            right: -100px;
            z-index: 0; /* Lower z-index */
        }
        .decor-line {
            position: absolute;
            width: 100%;
            height: 4px;
            background-color: #eab308; /* Solid Gold */
            top: 75px;
            left: 0;
            z-index: 5;
            /* Removed box-shadow */
        }

        /* Header */
        .header {
            padding: 15px 20px;
            /* Flex is partial in DomPDF, usually works for simple rows. Floats are backup if needed. */
            height: 45px;
            position: relative;
            z-index: 10;
        }
        .header:after {
            content: "";
            display: table;
            clear: both;
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
            /* Removed text-shadow (rgba) */
        }
        .school-desc {
            font-size: 8px;
            color: #a7f3d0; /* Solid light green - Replaces d1fae5 */
            margin-top: 2px;
            font-weight: 400;
        }

        /* Body Content */
        .body {
            padding: 25px 20px 10px 20px;
            position: relative;
            z-index: 10;
        }
        .body:after {
            content: "";
            display: table;
            clear: both;
        }
        
        .photo-container {
            float: left;
            width: 85px;
            height: 105px;
            background-color: #e2e8f0;
            border-radius: 8px;
            border: 2px solid #eab308; /* Gold Border */
            overflow: hidden;
            margin-right: 18px;
            /* Removed box-shadow */
        }
        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
            background-color: #fef9c3; /* Solid Light Yellow - Replaces gradient */
            border-left: 3px solid #eab308;
            padding: 5px 10px;
            border-radius: 0 6px 6px 0;
            position: relative;
        }
        .va-label {
            font-size: 8px;
            color: #854d0e; /* Darker Gold */
            display: block;
            margin-bottom: 2px;
            letter-spacing: 0.5px;
        }
        .va-value {
            font-size: 14px;
            font-family: 'Courier New', monospace;
            font-weight: 900;
            color: #166534; /* Dark Green */
            letter-spacing: 1px;
            /* Removed text-shadow */
        }

        /* QR & Footer */
        .qr-section {
            position: absolute;
            bottom: 15px;
            right: 15px;
            width: 55px;
            height: 55px;
            background-color: #ffffff;
            padding: 3px;
            border-radius: 6px;
            z-index: 20;
            /* Removed box-shadow */
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
            color: #6ee7b7; /* Solid Emerald 300 - Replaces transparent white rgba */
            font-style: italic;
        }

        /* Removed graphic-pattern entirely */

    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <!-- Background Elements -->
            <div class="decor-circle"></div>
            <div class="decor-line"></div>

            <!-- Header -->
            <div class="header">
                <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logo">
                <div class="header-content">
                    <div class="school-name">Ponpes Riyadlul Huda</div>
                    <div class="school-desc">Ngetsi, Tlogorejo, Tegowanu, Grobogan</div>
                </div>
            </div>

            <!-- Body -->
            <div class="body">
                <!-- Photo -->
                <div class="photo-container">
                    @if($santri->foto && file_exists(storage_path('app/public/santri-photos/' . $santri->foto)))
                        <img src="{{ storage_path('app/public/santri-photos/' . $santri->foto) }}">
                    @else
                        <!-- Default Avatar (WhatsApp Style Silhouette) -->
                        <img src="data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMjQgMjQiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjI0IiBoZWlnaHQ9IjI0IiBmaWxsPSIjY2JkNWUxIi8+PGNpcmNsZSBjeD0iMTIiIGN5PSI4IiByPSI0IiBmaWxsPSIjZmZmZmZmIi8+PHBhdGggZD0iTTQgMThDNHAxNS43OTA5IDUuNzkwODYgMTQgOCAxNEgxNkMxOC4yMDkxIDE0IDIwIDE1Ljc5MDkgMjAgMThWMjBINFYxOFoiIGZpbGw9IiNmZmZmZmYiLz48L3N2Zz4=" style="width: 100%; height: 100%; object-fit: cover;">
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
