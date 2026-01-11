<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Kas</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { color: #1B5E20; text-align: center; }
        h3 { color: #2E7D32; margin-top: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .summary { margin-top: 20px; padding: 15px; background-color: #E8F5E9; border-radius: 5px; }
        .saldo-positive { color: #4CAF50; font-weight: bold; }
        .saldo-negative { color: #f44336; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Laporan Arus Kas</h2>
    <p style="text-align: center;">
        Periode: 
        {{ $request->filled('tanggal_mulai') ? date('d/m/Y', strtotime($request->tanggal_mulai)) : 'Awal' }}
        s/d
        {{ $request->filled('tanggal_selesai') ? date('d/m/Y', strtotime($request->tanggal_selesai)) : 'Sekarang' }}
    </p>

    <h3>Pemasukan</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Sumber</th>
                <th>Kategori</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pemasukan as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $p->sumber_pemasukan }}</td>
                    <td>{{ ucfirst($p->kategori) }}</td>
                    <td>Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data</td>
                </tr>
            @endforelse
            <tr style="background-color: #C8E6C9; font-weight: bold;">
                <td colspan="4" style="text-align: right;">Total Pemasukan:</td>
                <td>Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <h3>Pengeluaran</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Kategori</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengeluaran as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $p->jenis_pengeluaran }}</td>
                    <td>{{ ucfirst($p->kategori) }}</td>
                    <td>Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data</td>
                </tr>
            @endforelse
            <tr style="background-color: #FFCDD2; font-weight: bold;">
                <td colspan="4" style="text-align: right;">Total Pengeluaran:</td>
                <td>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="summary">
        <h3>Ringkasan Kas</h3>
        <p><strong>Total Pemasukan:</strong> Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
        <p><strong>Total Pengeluaran:</strong> Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
        <p class="{{ $saldoKas >= 0 ? 'saldo-positive' : 'saldo-negative' }}">
            <strong>Saldo Kas:</strong> Rp {{ number_format($saldoKas, 0, ',', '.') }}
        </p>
    </div>

    <p style="margin-top: 30px; text-align: center; font-size: 12px; color: #666;">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}<br>
        Yayasan Pondok Pesantren Riyadlul Huda
    </p>
</body>
</html>
