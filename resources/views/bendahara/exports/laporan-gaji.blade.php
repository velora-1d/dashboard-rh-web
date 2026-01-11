<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Gaji Pegawai</title>
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
    <h2>Laporan Gaji Pegawai</h2>
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
                <th>Nama Pegawai</th>
                <th>Jabatan</th>
                <th>Periode Gaji</th>
                <th>Nominal</th>
                <th>Status</th>
                <th>Tanggal Bayar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($gaji as $index => $g)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $g->pegawai->nama_pegawai ?? '-' }}</td>
                    <td>{{ $g->pegawai->jabatan ?? '-' }}</td>
                    <td>{{ date('F', mktime(0, 0, 0, $g->bulan, 1)) }} {{ $g->tahun }}</td>
                    <td>Rp {{ number_format($g->nominal, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge {{ $g->is_dibayar ? 'badge-success' : 'badge-error' }}">
                            {{ $g->is_dibayar ? 'Sudah Dibayar' : 'Belum Dibayar' }}
                        </span>
                    </td>
                    <td>{{ $g->tanggal_bayar ? $g->tanggal_bayar->format('d/m/Y') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data gaji</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <h3>Ringkasan</h3>
        <p><strong>Total Gaji:</strong> Rp {{ number_format($totalGaji, 0, ',', '.') }}</p>
        <p><strong>Total Sudah Dibayar:</strong> Rp {{ number_format($totalDibayar, 0, ',', '.') }}</p>
        <p><strong>Total Belum Dibayar:</strong> Rp {{ number_format($totalBelumDibayar, 0, ',', '.') }}</p>
        <p><strong>Jumlah Transaksi:</strong> {{ $gaji->count() }}</p>
    </div>

    <p style="margin-top: 30px; text-align: center; font-size: 12px; color: #666;">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}<br>
        Yayasan Pondok Pesantren Riyadlul Huda
    </p>
</body>
</html>
