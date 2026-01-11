<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengeluaran</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { color: #1B5E20; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .summary { margin-top: 20px; padding: 15px; background-color: #E8F5E9; border-radius: 5px; }
    </style>
</head>
<body>
    <h2>Laporan Pengeluaran</h2>
    <p style="text-align: center;">
        @if($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai'))
            Periode: {{ \Carbon\Carbon::parse($request->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($request->tanggal_selesai)->format('d M Y') }}
        @elseif($request->filled('tanggal_mulai'))
            Sejak: {{ \Carbon\Carbon::parse($request->tanggal_mulai)->format('d M Y') }}
        @elseif($request->filled('tanggal_selesai'))
            Sampai: {{ \Carbon\Carbon::parse($request->tanggal_selesai)->format('d M Y') }}
        @else
            Semua Periode
        @endif
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis Pengeluaran</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengeluaran as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $p->jenis_pengeluaran }}</td>
                    <td style="text-transform: capitalize;">{{ $p->kategori }}</td>
                    <td>{{ $p->keterangan ?? '-' }}</td>
                    <td style="text-align: right;">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data pengeluaran</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <h3>Ringkasan</h3>
        <p><strong>Total Pengeluaran:</strong> Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
        <p><strong>Jumlah Transaksi:</strong> {{ $pengeluaran->count() }}</p>
    </div>

    <p style="margin-top: 30px; text-align: center; font-size: 12px; color: #666;">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}<br>
        Yayasan Pondok Pesantren Riyadlul Huda
    </p>
</body>
</html>
