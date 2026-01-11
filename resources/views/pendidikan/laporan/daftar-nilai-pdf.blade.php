<!DOCTYPE html>
<html>
<head>
    <title>Daftar Nilai Kelas {{ $kelas->nama_kelas }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .table th, .table td { border: 1px solid #000; padding: 4px; }
        .table th { background-color: #f0f0f0; }
        .page-break { page-break-after: always; }
        h3 { margin-top: 0; margin-bottom: 5px; }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>REKAPITULASI NILAI SANTRI
            @if(isset($gender) && $gender != 'all') 
                {{ $gender == 'putra' ? '(PUTRA)' : '(PUTRI)' }}
            @endif
        </h2>
        <p>Kelas: {{ $kelas->nama_kelas }} | Tahun Ajaran: {{ $tahunAjaran }} | Semester: {{ $semester }}</p>
    </div>

    @foreach($dataNilai as $santriId => $nilais)
        @php $santri = $nilais->first()->santri; @endphp
        <div style="margin-bottom: 15px; border-bottom: 1px dashed #ccc; padding-bottom: 15px;">
            <h3>{{ $loop->iteration }}. {{ $santri->nama_santri ?? '-' }} (NIS: {{ $santri->nis ?? '-' }})</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th width="40%">Mata Pelajaran</th>
                        <th width="15%">Nilai</th>
                        <th width="10%">Grade</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; $count = 0; @endphp
                    @foreach($nilais as $n)
                        <tr>
                            <td>{{ $n->mataPelajaran->nama_mapel ?? '-' }}</td>
                            <td style="text-align: center;">{{ $n->nilai_akhir }}</td>
                            <td style="text-align: center;">{{ $n->grade }}</td>
                            <td>{{ $n->catatan }}</td>
                        </tr>
                        @php $total += $n->nilai_akhir; $count++; @endphp
                    @endforeach
                    <tr style="background: #fafafa; font-weight: bold;">
                        <td style="text-align: right;">RATA-RATA</td>
                        <td style="text-align: center;">{{ $count > 0 ? number_format($total / $count, 2) : 0 }}</td>
                        <td colspan="2"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        @if($loop->iteration % 3 == 0) 
            <div class="page-break"></div>
        @endif
    @endforeach

</body>
</html>
