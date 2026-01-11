<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Syahriah</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { color: #1B5E20; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .summary { margin-top: 20px; padding: 15px; background-color: #E8F5E9; border-radius: 5px; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .badge-success { background-color: #4CAF50; color: white; }
        .badge-error { background-color: #f44336; color: white; }
    </style>
</head>
<body>
    <h2>Laporan Pembayaran Syahriah</h2>
    <p style="text-align: center;">
        @if($request->filled('tahun') || $request->filled('bulan'))
            Periode: 
            @if($request->filled('bulan'))
                {{ date('F', mktime(0, 0, 0, $request->bulan, 1)) }}
            @endif
            @if($request->filled('tahun'))
                {{ $request->tahun }}
            @endif
        @else
            Semua Periode
        @endif
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Santri</th>
                <th>Bulan/Tahun</th>
                <th>Nominal</th>
                <th>Status</th>
                <th>Tanggal Bayar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($syahriah as $index => $s)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $s->santri->nis ?? '-' }}</td>
                    <td>{{ $s->santri->nama_santri ?? '-' }}</td>
                    <td>{{ date('F', mktime(0, 0, 0, $s->bulan, 1)) }} {{ $s->tahun }}</td>
                    <td>Rp {{ number_format($s->nominal, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge {{ $s->is_lunas ? 'badge-success' : 'badge-error' }}">
                            {{ $s->is_lunas ? 'Lunas' : 'Belum Lunas' }}
                        </span>
                    </td>
                    <td>{{ $s->tanggal_bayar ? $s->tanggal_bayar->format('d/m/Y') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <h3>Ringkasan</h3>
        <p><strong>Total Syahriah:</strong> Rp {{ number_format($totalNominal, 0, ',', '.') }}</p>
        <p><strong>Total Lunas:</strong> Rp {{ number_format($totalLunas, 0, ',', '.') }}</p>
        <p><strong>Total Belum Lunas:</strong> Rp {{ number_format($totalBelumLunas, 0, ',', '.') }}</p>
        <p><strong>Jumlah Transaksi:</strong> {{ $syahriah->count() }}</p>
    </div>

    <p style="margin-top: 30px; text-align: center; font-size: 12px; color: #666;">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}<br>
        Yayasan Pondok Pesantren Riyadlul Huda
    </p>
</body>
</html>
