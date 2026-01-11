<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Santri</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; font-size: 12px; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .header p { margin: 5px 0; font-size: 14px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>PONTREN RIYADLUL HUDA</h2>
        <p>Laporan Data Santri Aktif</p>
        <p>Per Tanggal: {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 10%">NIS</th>
                <th style="width: 25%">Nama Santri</th>
                <th style="width: 10%">Gender</th>
                <th style="width: 15%">Kelas</th>
                <th style="width: 20%">Asrama</th>
                <th style="width: 15%">Kobong</th>
            </tr>
        </thead>
        <tbody>
            @foreach($santri as $index => $s)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td style="text-align: center;">{{ $s->nis }}</td>
                <td>{{ $s->nama_santri }}</td>
                <td style="text-align: center;">{{ ucfirst($s->gender) }}</td>
                <td style="text-align: center;">{{ $s->kelas->nama_kelas ?? '-' }}</td>
                <td style="text-align: center;">{{ $s->asrama->nama_asrama ?? '-' }}</td>
                <td style="text-align: center;">
                    @if($s->kobong)
                        Kobong {{ $s->kobong->nomor_kobong }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 20px; font-size: 11px; text-align: right;">
        Dicetak pada: {{ date('d-m-Y H:i:s') }}
    </div>
</body>
</html>
