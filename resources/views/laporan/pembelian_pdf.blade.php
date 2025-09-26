<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #eee; }
        h3 { margin: 0 0 10px; }
    </style>
    <title>{{ $title }}</title>
    </head>
<body>
    <h3>{{ $title }}</h3>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kode</th>
                <th>User</th>
                <th>Pemasok</th>
                <th>Item</th>
                <th>Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $r)
            <tr>
                <td>{{ $r->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $r->kode_pembelian }}</td>
                <td>{{ $r->user?->name }}</td>
                <td>{{ $r->pemasok?->nama_pemasok }}</td>
                <td style="text-align:right">{{ $r->total_item }}</td>
                <td style="text-align:right">{{ number_format($r->bayar,0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
