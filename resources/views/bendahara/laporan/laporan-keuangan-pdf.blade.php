<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; }
        .header p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .amount { text-align: right; }
        .summary-box { margin-bottom: 20px; padding: 10px; border: 1px solid #ccc; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Keuangan</h1>
        <h2>Pondok Pesantren Riyadlul Huda</h2>
        <p>Tahun: {{ $year }}</p>
    </div>

    <div class="summary-box">
        <h3>Ringkasan</h3>
        <table>
            <tr>
                <td>Total Pemasukan</td>
                <td class="amount">Rp {{ number_format($summary['total_masuk_bersih'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Pengeluaran</td>
                <td class="amount">Rp {{ number_format($summary['total_keluar_bersih'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Saldo Akhir</strong></td>
                <td class="amount"><strong>Rp {{ number_format($summary['saldo_akhir'], 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>

    <h3>Rincian Bulanan</h3>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
                <th>Selisih</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chart as $item)
            <tr>
                <td>{{ date('F', mktime(0, 0, 0, $item['bulan'], 10)) }}</td>
                <td class="amount">Rp {{ number_format($item['masuk'], 0, ',', '.') }}</td>
                <td class="amount">Rp {{ number_format($item['keluar'], 0, ',', '.') }}</td>
                <td class="amount">Rp {{ number_format($item['masuk'] - $item['keluar'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: right;">
        <p>Dicetak pada: {{ date('d F Y H:i') }}</p>
    </div>
</body>
</html>
