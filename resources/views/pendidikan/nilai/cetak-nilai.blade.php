<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Nilai - {{ $kelas->nama_kelas }}</title>
    <style>
        @page {
            size: landscape;
            margin: 1cm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 9pt;
            line-height: 1.3;
            color: #000;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
        }
        
        .header h1 {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        
        .header h2 {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .header p {
            font-size: 10pt;
            margin: 2px 0;
        }
        
        .info-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 9pt;
        }
        
        .info-table td {
            padding: 2px 0;
        }
        
        .info-table td:first-child {
            width: 120px;
            font-weight: bold;
        }
        
        table.nilai-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        
        table.nilai-table th,
        table.nilai-table td {
            border: 1px solid #000;
            padding: 4px 3px;
            text-align: center;
            font-size: 8pt;
        }
        
        table.nilai-table th {
            background-color: #e0e0e0;
            font-weight: bold;
            font-size: 7pt;
            text-transform: uppercase;
        }
        
        table.nilai-table th.sticky-col {
            background-color: #d0d0d0;
        }
        
        table.nilai-table td.student-name {
            text-align: left;
            font-weight: bold;
            padding-left: 5px;
        }
        
        table.nilai-table td.no-col {
            font-weight: bold;
        }
        
        table.nilai-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        table.nilai-table tfoot tr {
            background-color: #e8e8e8;
            font-weight: bold;
        }
        
        table.nilai-table tfoot td {
            font-size: 8pt;
        }
        
        .summary-label {
            text-align: left !important;
            padding-left: 10px !important;
            font-weight: bold;
        }
        
        .rank-1 { color: #d4af37; font-weight: bold; }
        .rank-2 { color: #c0c0c0; font-weight: bold; }
        .rank-3 { color: #cd7f32; font-weight: bold; }
        
        .footer {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            font-size: 9pt;
        }
        
        .signature-box {
            text-align: center;
            width: 200px;
        }
        
        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Print Button (hidden when printing) -->
    <div class="no-print" style="text-align: right; margin-bottom: 10px;">
        <button onclick="window.print()" style="padding: 8px 20px; background: #2196f3; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 11pt;">
            🖨️ Cetak / Print
        </button>
        <button onclick="window.close()" style="padding: 8px 20px; background: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 11pt; margin-left: 5px;">
            ✖ Tutup
        </button>
    </div>

    <!-- Header -->
    <div class="header">
        <h1>Pondok Pesantren Riyadlul Huda</h1>
        <h2>Rekapitulasi Nilai Ujian</h2>
        <p>Kelas: {{ $kelas->nama_kelas }} | Semester: {{ $semester == 1 ? 'Ganjil' : 'Genap' }} | Tahun Ajaran: {{ $tahunAjaran }}</p>
        @if($gender && $gender !== 'all')
            <p style="font-style: italic;">Filter: {{ ucfirst($gender) }}</p>
        @endif
    </div>

    <!-- Nilai Table -->
    <table class="nilai-table">
        <thead>
            <tr>
                <th rowspan="2" style="width: 30px;">NO</th>
                <th rowspan="2" style="min-width: 150px;">NAMA SANTRI</th>
                @foreach($mapelList as $mapel)
                    <th style="min-width: 45px;">{{ $mapel->nama_mapel }}</th>
                @endforeach
                <th rowspan="2" style="width: 50px; background-color: #fff3cd;">JML</th>
                <th rowspan="2" style="width: 50px; background-color: #d4edda;">RATA²</th>
                <th rowspan="2" style="width: 40px; background-color: #f8d7da;">RANK</th>
            </tr>
        </thead>
        <tbody>
            @foreach($santriList as $index => $santri)
                <tr>
                    <td class="no-col">{{ $index + 1 }}</td>
                    <td class="student-name">{{ $santri->nama_santri }}</td>
                    @foreach($mapelList as $mapel)
                        <td>
                            @if(isset($nilaiData[$santri->id][$mapel->id]) && $nilaiData[$santri->id][$mapel->id])
                                {{ number_format($nilaiData[$santri->id][$mapel->id], 1) }}
                            @else
                                -
                            @endif
                        </td>
                    @endforeach
                    <td style="background-color: #fff9e6; font-weight: bold;">
                        {{ $studentAverages[$santri->id]['total'] > 0 ? number_format($studentAverages[$santri->id]['total'], 1) : '-' }}
                    </td>
                    <td style="background-color: #f0f8f0; font-weight: bold;">
                        {{ $studentAverages[$santri->id]['average'] > 0 ? number_format($studentAverages[$santri->id]['average'], 2) : '-' }}
                    </td>
                    <td style="background-color: #fff0f0;" class="{{ $studentRankings[$santri->id] <= 3 ? 'rank-' . $studentRankings[$santri->id] : '' }}">
                        @if($studentAverages[$santri->id]['average'] > 0)
                            {{ $studentRankings[$santri->id] }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <!-- Jumlah Row -->
            <tr>
                <td colspan="2" class="summary-label">📊 JUMLAH</td>
                @foreach($mapelList as $mapel)
                    <td>{{ $columnStats[$mapel->id]['sum'] > 0 ? number_format($columnStats[$mapel->id]['sum'], 1) : '-' }}</td>
                @endforeach
                <td colspan="3" style="background-color: #e3f2fd;">
                    {{ collect($columnStats)->sum('sum') > 0 ? number_format(collect($columnStats)->sum('sum'), 1) : '-' }}
                </td>
            </tr>
            <!-- Rata-rata Row -->
            <tr>
                <td colspan="2" class="summary-label">📈 RATA-RATA</td>
                @foreach($mapelList as $mapel)
                    <td>{{ $columnStats[$mapel->id]['average'] > 0 ? number_format($columnStats[$mapel->id]['average'], 2) : '-' }}</td>
                @endforeach
                <td colspan="3" style="background-color: #fff3e0;">
                    @php
                        $totalAvg = collect($columnStats)->avg('average');
                    @endphp
                    {{ $totalAvg > 0 ? number_format($totalAvg, 2) : '-' }}
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- Footer with Signatures -->
    <div class="footer">
        <div class="signature-box">
            <p>Mengetahui,</p>
            <p style="font-weight: bold;">Kepala Madrasah</p>
            <div class="signature-line">
                <p>(...........................)</p>
            </div>
        </div>
        
        <div class="signature-box">
            <p>{{ now()->locale('id')->translatedFormat('d F Y') }}</p>
            <p style="font-weight: bold;">Wali Kelas</p>
            <div class="signature-line">
                <p>(...........................)</p>
            </div>
        </div>
    </div>
</body>
</html>
