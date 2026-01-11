<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Template Import Santri</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #1B5E20;
            color: white;
            font-weight: bold;
        }
        .info {
            background-color: #FFF3E0;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="info">
        <h3>Petunjuk Pengisian Template Import Santri</h3>
        <ul>
            <li>Isi semua kolom sesuai dengan data santri</li>
            <li>Gender: isi dengan "putra" atau "putri" (huruf kecil)</li>
            <li>Kelas ID, Asrama ID, Kobong ID: lihat referensi di bawah</li>
            <li>Jangan ubah header kolom</li>
            <li>Hapus baris contoh sebelum mengisi data</li>
        </ul>
    </div>

    <table>
        <thead>
            <tr>
                <th>NIS</th>
                <th>Nama Santri</th>
                <th>Gender</th>
                <th>Negara</th>
                <th>Provinsi</th>
                <th>Kota/Kabupaten</th>
                <th>Kecamatan</th>
                <th>Desa/Kampung</th>
                <th>RT/RW</th>
                <th>Nama Ortu/Wali</th>
                <th>No HP Ortu/Wali</th>
                <th>Kelas ID</th>
                <th>Asrama ID</th>
                <th>Kobong ID</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>2025001</td>
                <td>Ahmad Santoso</td>
                <td>putra</td>
                <td>Indonesia</td>
                <td>Jawa Timur</td>
                <td>Surabaya</td>
                <td>Gubeng</td>
                <td>Airlangga</td>
                <td>001/002</td>
                <td>Bapak Ahmad</td>
                <td>081234567890</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
            </tr>
        </tbody>
    </table>

    <h3 style="margin-top: 30px;">Referensi Kelas</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kelas</th>
                <th>Tingkat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kelasList as $kelas)
            <tr>
                <td>{{ $kelas->id }}</td>
                <td>{{ $kelas->nama_kelas }}</td>
                <td>{{ $kelas->tingkat }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3 style="margin-top: 30px;">Referensi Asrama</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Asrama</th>
                <th>Gender</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asramaList as $asrama)
            <tr>
                <td>{{ $asrama->id }}</td>
                <td>{{ $asrama->nama_asrama }}</td>
                <td>{{ $asrama->gender }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 30px; font-size: 12px; color: #666;">
        <strong>Catatan:</strong> Kobong ID adalah 1-20 untuk setiap asrama. 
        Untuk Asrama ID 1: Kobong 1-20, Asrama ID 2: Kobong 21-40, dst.
    </p>
</body>
</html>
