<!DOCTYPE html>
<html>
<head>
    <title>Rekap Absensi Kelas {{ $kelas->nama_kelas }}</title>
    <style>
        body { font-family: sans-serif; font-size: 13px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #000; padding: 6px; }
        .table th { background-color: #f0f0f0; text-align: center; }
        .high-alfa { color: red; font-weight: bold; }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>REKAPITULASI KETIDAKHADIRAN (ALFA) <br>
            @if(isset($gender) && $gender != 'all') 
                {{ $gender == 'putra' ? '(PUTRA)' : '(PUTRI)' }}
            @endif
        </h2>
        <p>Kelas: {{ $kelas->nama_kelas }} | Tahun: {{ $tahun }} 
            @if(isset($semester)) | Semester: {{ $semester }} @endif
        </p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Santri</th>
                <th width="15%">Sorogan</th>
                <th width="15%">Hafalan Malam</th>
                <th width="15%">Hafalan Subuh</th>
                <th width="15%">Tahajud</th>
                <th width="10%">Total Alfa</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($absensi as $santriId => $items)
                @php 
                    $santri = $items->first()->santri; 
                    $totalSorogan = $items->sum('alfa_sorogan');
                    $totalMalam = $items->sum('alfa_menghafal_malam');
                    $totalSubuh = $items->sum('alfa_menghafal_subuh');
                    $totalTahajud = $items->sum('alfa_tahajud');
                    $grandTotal = $totalSorogan + $totalMalam + $totalSubuh + $totalTahajud;
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $no++ }}</td>
                    <td>{{ $santri->nama_santri ?? '-' }}</td>
                    <td style="text-align: center;">{{ $totalSorogan }}</td>
                    <td style="text-align: center;">{{ $totalMalam }}</td>
                    <td style="text-align: center;">{{ $totalSubuh }}</td>
                    <td style="text-align: center;">{{ $totalTahajud }}</td>
                    <td style="text-align: center;" class="{{ $grandTotal > 10 ? 'high-alfa' : '' }}">{{ $grandTotal }}</td>
                </tr>
            @endforeach
            
            @if($absensi->isEmpty())
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">Tidak ada data absensi untuk periode ini.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div style="margin-top: 30px; font-size: 12px;">
        <p><i>Catatan: Data di atas adalah akumulasi jumlah pelanggaran/ketidakhadiran (Alfa) sepanjang tahun {{ $tahun }}.</i></p>
    </div>

</body>
</html>
