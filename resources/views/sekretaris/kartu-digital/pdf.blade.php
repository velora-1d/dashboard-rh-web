<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Kartu Syahriah Digital - {{ $santri->nama_santri }}</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #f8fafc;
        }
        .container {
            width: 100%;
            height: 100%;
            display: flex;
            text-align: center;
        }
        .card-wrapper {
            width: 100%;
            padding-top: 50px;
            text-align: center;
        }
        .card {
            width: 500px;
            height: 365px; /* Increased height to prevent text clipping */
            margin: 0 auto;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            background-color: #0f172a;
            border-radius: 20px;
            position: relative;
            color: white;
            overflow: hidden;
            border: 2px solid #fbbf24;
        }
        .header {
            padding: 25px 30px;
            display: block;
            text-align: left;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .school-name {
            font-size: 18px;
            font-weight: bold;
            color: #fbbf24;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-right: 60px; /* Space for logo */
        }
        .card-title {
            font-size: 10px;
            color: rgba(255,255,255,0.7);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 4px;
        }
        .logo-school {
            position: absolute;
            top: 20px;
            right: 25px;
            width: 50px;
            height: auto;
            z-index: 10;
        }
        .content {
            padding: 30px;
            text-align: center;
        }
        .va-label {
            font-size: 12px;
            color: rgba(255,255,255,0.8);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        .va-number {
            font-size: 32px;
            font-weight: bold;
            font-family: 'Courier New', monospace;
            color: white;
            letter-spacing: 4px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            background: rgba(255,255,255,0.1);
            padding: 10px 20px;
            border-radius: 8px;
            display: inline-block;
        }
        .santri-info {
            padding: 0 30px 30px 30px;
            text-align: left;
        }
        .label {
            font-size: 10px;
            color: rgba(255,255,255,0.6);
            text-transform: uppercase;
        }
        .name {
            font-size: 20px;
            font-weight: 600;
            color: white;
            margin-top: 5px;
            text-transform: uppercase;
        }
        .footer-note {
            position: absolute;
            bottom: 0;
            left: 0;
        .footer-note {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 12px 0 15px 0; /* Vertical padding only */
            background: rgba(0,0,0,0.3);
            font-size: 8px;
            color: rgba(255,255,255,0.9);
            line-height: 1.5;
            border-top: 1px solid rgba(255,255,255,0.1);
            text-align: center; /* Ensure inheritance */
        }
        .bank-icons {
            position: absolute;
            bottom: 70px;
            right: 30px;
            font-size: 10px;
            color: white;
            font-weight: bold;
            opacity: 0.8;
            text-align: right;
        }
        .chip {
            width: 50px;
            height: 35px;
            background: linear-gradient(135deg, #fcd34d 0%, #d97706 100%);
            border-radius: 6px;
            position: absolute;
            top: 90px;
            left: 30px;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="card-wrapper">
        <div class="card">
            
            <!-- LOGO PESANTREN -->
            <img src="{{ public_path('images/logo-yayasan.png') }}" class="logo-school" alt="Logo">

            <div class="header">
                <div class="school-name">PONPES RIYADLUL HUDA</div>
                <div class="card-title">Kartu Syahriah Digital</div>
            </div>

            <div class="chip"></div>

            <div class="content">
                <div class="va-label">Virtual Account Number</div>
                <div class="va-number">
                    {{ chunk_split($santri->virtual_account_number ?? '00000000', 4, ' ') }}
                </div>
            </div>

            <div class="santri-info">
                <div class="label">Nama Santri</div>
                <div class="name">{{ $santri->nama_santri }}</div>
            </div>

            <div class="bank-icons">
                ATM BERSAMA / PRIMA / ALTO
            </div>

            <div class="footer-note">
                <div style="width: 100%; max-width: 90%; margin: 0 auto; text-align: center;">
                    <strong>PETUNJUK:</strong> Simpan kartu ini. Gunakan Nomor VA di atas untuk pembayaran Syahriah<br>
                    via ATM, Mobile Banking, atau Internet Banking (BRI/BNI/Mandiri/Lainnya).
                </div>
            </div>
        </div>
    </div>
</body>
</html>
