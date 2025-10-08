<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Struk {{ $penjualan->kode_penjualan }}</title>
    <style>
        @page { margin: 6mm; }
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; }
        .wrap { max-width: 320px; margin:0 auto; }
        .center { text-align:center; }
        .dashed { border-top:2px dashed #000; margin:8px 0; }
        table { width:100%; border-collapse:collapse; }
        th,td { padding:2px 0; font-weight:400; }
        th { font-weight:600; border-bottom:1px dashed #000; }
        .totals td { padding:2px 0; }
        .right { text-align:right; }
        .mono { font-family: monospace; }
    </style>
</head>
<body onload="window.print()">
    <div class="wrap">
        <div class="dashed"></div>
        <div class="center">
            <div style="font-size:16px;font-weight:700;">UD TANI JAYA</div>
            <div style="font-size:11px;">Jl. xxx No.xx</div>
            <div style="font-size:11px;">Telp : xxxxxxxxxxxxxx</div>
        </div>
        <div class="dashed"></div>
        <table style="margin-bottom:4px; font-size:11px;">
            <tr><td style="width:70px;">Tanggal</td><td>: {{ $penjualan->created_at->format('d-m-Y H:i') }}</td></tr>
            <tr><td>Kasir</td><td>: {{ $penjualan->user?->name }}</td></tr>
            <tr><td>No. Trx</td><td>: {{ $penjualan->kode_penjualan }}</td></tr>
        </table>
        <div class="dashed" style="margin-top:2px;"></div>
        <table style="font-size:11px;">
            <thead>
                <tr>
                    <th style="text-align:left;">Nama Barang</th>
                    <th class="right">Qty</th>
                    <th class="right">Harga</th>
                    <th class="right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualan->detail as $d)
                    <tr>
                        <td style="max-width:120px; overflow:hidden;">{{ $d->pupuk?->nama_pupuk }}</td>
                        <td class="right">{{ $d->jumlah }}</td>
                        <td class="right">{{ number_format($d->harga_jual,0,',','.') }}</td>
                        <td class="right">{{ number_format($d->subtotal,0,',','.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="dashed"></div>
        <table class="totals" style="font-size:11px;">
            <tr><td style="width:60%;"></td><td>Total</td><td class="right">{{ number_format($penjualan->total_harga,0,',','.') }}</td></tr>
            <tr><td></td><td>Dibayar</td><td class="right">{{ number_format($penjualan->bayar,0,',','.') }}</td></tr>
            <tr><td></td><td>Kembalian</td><td class="right">{{ number_format($penjualan->kembalian,0,',','.') }}</td></tr>
        </table>
        <div class="dashed"></div>
        <div class="center" style="margin-top:8px; font-size:12px; font-weight:600;">Terima kasih atas kepercayaan Anda!</div>
        <div class="center" style="margin-top:10px; font-size:11px;">Barang yang sudah dibeli<br/>**tidak dapat dikembalikan**</div>
        <div class="dashed" style="margin-top:10px;"></div>
    </div>
</body>
</html>