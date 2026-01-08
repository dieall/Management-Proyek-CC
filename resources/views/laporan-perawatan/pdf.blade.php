<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Perawatan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h3 { text-align: center; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h3>Laporan Perawatan Aset</h3>
    <table>
        <thead>
            <tr>
                <th>Aset</th>
                <th>Tanggal</th>
                <th>Kondisi Sebelum</th>
                <th>Kondisi Sesudah</th>
                <th>Pengurus</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $item)
            <tr>
                <td>{{ $item->aset->nama_aset }}</td>
                <td>{{ $item->tanggal_pemeriksaan->format('d/m/Y') }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $item->kondisi_sebelum)) }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $item->kondisi_sesudah)) }}</td>
                <td>{{ $item->user->name }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>


