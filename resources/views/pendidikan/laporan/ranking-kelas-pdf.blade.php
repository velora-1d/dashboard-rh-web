<!DOCTYPE html>
<html>
<head>
    <title>Ranking Kelas {{ $kelas->nama_kelas }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #000; padding: 8px; }
        .table th { background-color: #f0f0f0; text-align: center; }
        .rank-top { font-weight: bold; }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>PERINGKAT KELAS: {{ strtoupper($kelas->nama_kelas) }} <br>
            @if(isset($gender) && $gender != 'all') 
                {{ $gender == 'putra' ? '(PUTRA)' : '(PUTRI)' }}
            @endif
        </h2>
        <p>Tahun Ajaran: {{ $tahunAjaran }} | Semester: {{ $semester }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th width="10%">Peringkat</th>
                <th>Nama Santri</th>
                <th width="20%">NIS</th>
                <th width="20%">Total Nilai</th>
                <th width="20%">Rata-Rata</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rankings as $item)
                <tr class="{{ $loop->iteration <= 3 ? 'rank-top' : '' }}">
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $item['santri']->nama_santri ?? '-' }}</td>
                    <td style="text-align: center;">{{ $item['santri']->nis ?? '-' }}</td>
                    <td style="text-align: center;">{{ number_format($item['total_nilai'], 2) }}</td>
                    <td style="text-align: center;">{{ number_format($item['rata_rata'], 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px;">Belum ada data nilai di kelas ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer" style="margin-top: 50px; text-align: right; margin-right: 50px;">
        <p>Tasikmalaya, {{ date('d F Y') }}</p>
        <p>Wali Kelas,</p>
        <br><br><br>
        <p>_______________________</p>
    </div>

</body>
</html>
