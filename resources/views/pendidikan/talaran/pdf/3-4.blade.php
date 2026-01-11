<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Talaran Minggu 3-4</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header h2 { margin: 5px 0; font-size: 14px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background-color: #f0f0f0; }
        .text-left { text-align: left; }
        .text-alfa { color: #ef4444; font-weight: bold; font-size: 11px; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; padding: 10px; }
        }
    </style>
</head>
<body onload="window.print()">
    
    <div class="no-print" style="margin-bottom: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Cetak Laporan</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer;">Tutup</button>
    </div>

    <div class="header">
        <h1>LAPORAN TALARAN MINGGU 3-4</h1>
        <h2>Bulan: {{ $monthName }} {{ $tahun }} | Kelas: {{ $kelasName }}</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 22%;">Nama Santri</th>
                <th style="width: 13%;">Kelas / Kitab</th>
                <th style="width: 7%;">Minggu 3</th>
                <th style="width: 7%;">Minggu 4</th>
                <th style="width: 7%;">Jumlah</th>
                <th style="width: 7%;">Tamat</th>
                <th style="width: 7%;">Alfa</th>
                <th style="width: 13%;">Total</th>
                <th style="width: 12%;">KET</th>
            </tr>
        </thead>
        <tbody>
            @forelse($santriList as $index => $santri)
                @php
                    $talaran = $talaranRecords->get($santri->id);
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="text-left">{{ $santri->nama_santri }}</td>
                    <td>{{ $santri->kelas->nama_kelas ?? '-' }} ({{ $santri->kelas->kitab_talaran ?? '-' }})</td>
                    <td>{{ $talaran->minggu_3 ?? 0 }}</td>
                    <td>{{ $talaran->minggu_4 ?? 0 }}</td>
                    <td><b>{{ $talaran->jumlah_3_4 ?? 0 }}</b></td>
                    <td>{{ $talaran->tamat ?? 0 }}</td>
                    <td>{{ $talaran->alfa ?? 0 }}</td>
                    <td>{{ $talaran->total_3_4 ?? '-' }}</td>
                    <td class="text-alfa">@if(($talaran->alfa ?? 0) > 0) ALFA {{ $talaran->alfa }} @endif</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="margin-top: 30px; float: right; text-align: center; width: 200px;">
        <p>Mengetahui,</p>
        <br><br><br>
        <p>Kepala Pondok</p>
    </div>
</body>
</html>
