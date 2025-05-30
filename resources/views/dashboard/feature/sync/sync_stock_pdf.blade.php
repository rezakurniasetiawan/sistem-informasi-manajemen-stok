<!DOCTYPE html>
<html>

<head>
    <title>Laporan Barang Masuk dan Keluar</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 20px;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 80px;
        }

        .header h1 {
            font-size: 18px;
            margin: 5px 0;
        }

        .header p {
            margin: 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 11px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: right;
            margin-top: 40px;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="{{ public_path('path/to/logo.png') }}" alt="LOGO Toko Listrik LIA">
        <h1>TOKO LISTRIK LIA</h1>
        <p>Jalan Bungurasih Utara I / 1B RT 5 RW 4, Waru - Sidoarjo 61256</p>
        <hr>
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2">Tanggal</th>
                <th rowspan="2">Kode Transaksi</th>
                <th colspan="3">Masuk</th>
                <th colspan="3">Keluar</th>
                <th colspan="3">Persediaan</th>
            </tr>
            <tr>
                <th>Qty</th>
                <th>Harga</th>
                <th>Total Harga</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Total Harga</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @php
                $saldoQty = 0;
                $saldoHarga = 0;
                $saldoTotal = 0;

                $totalInQty = 0;
                $totalInHarga = 0;
                $totalOutQty = 0;
                $totalOutHarga = 0;
            @endphp

            @foreach ($stocks as $stock)
                @php
                    $inQty = $stock->type == 'inbound' ? $stock->quantity : null;
                    $inHarga = $stock->type == 'inbound' ? $stock->purchase_price : null;
                    $inTotal = $inQty ? $inQty * $inHarga : null;

                    $outQty = $stock->type == 'outbound' ? $stock->quantity_out : null;
                    $outHarga = $stock->type == 'outbound' ? $stock->purchase_price : null;
                    $outTotal = $outQty ? $outQty * $outHarga : null;

                    // Update saldo
                    if ($inQty) {
                        $saldoQty += $inQty;
                        $saldoHarga = $inHarga;
                        $saldoTotal += $inTotal;

                        $totalInQty += $inQty;
                        $totalInHarga += $inTotal;
                    }

                    if ($outQty) {
                        $saldoQty -= $outQty;
                        $saldoTotal -= $outTotal;

                        $totalOutQty += $outQty;
                        $totalOutHarga += $outTotal;
                    }
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($stock->input_date)->format('d-m-Y') }}</td>
                    <td>{{ $stock->invoice_code }}</td>

                    {{-- MASUK --}}
                    <td>{{ $inQty ?? '' }}</td>
                    <td>{{ $inHarga ? 'Rp. ' . number_format($inHarga, 0, ',', '.') : '' }}</td>
                    <td>{{ $inTotal ? 'Rp. ' . number_format($inTotal, 0, ',', '.') : '' }}</td>

                    {{-- KELUAR --}}
                    <td>{{ $outQty ?? '' }}</td>
                    <td>{{ $outHarga ? 'Rp. ' . number_format($outHarga, 0, ',', '.') : '' }}</td>
                    <td>{{ $outTotal ? 'Rp. ' . number_format($outTotal, 0, ',', '.') : '' }}</td>

                    {{-- PERSEDIAAN --}}
                    <td>{{ $saldoQty }}</td>
                    <td>{{ $saldoHarga ? 'Rp. ' . number_format($saldoHarga, 0, ',', '.') : '' }}</td>
                    <td>{{ $saldoTotal ? 'Rp. ' . number_format($saldoTotal, 0, ',', '.') : '' }}</td>
                </tr>
            @endforeach

            {{-- TOTAL --}}
            <tr>
                <th colspan="2">TOTAL</th>
                <th>{{ $totalInQty }}</th>
                <th></th>
                <th>{{ 'Rp. ' . number_format($totalInHarga, 0, ',', '.') }}</th>
                <th>{{ $totalOutQty }}</th>
                <th></th>
                <th>{{ 'Rp. ' . number_format($totalOutHarga, 0, ',', '.') }}</th>
                <th>{{ $saldoQty }}</th>
                <th></th>
                <th>{{ 'Rp. ' . number_format($saldoTotal, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Sidoarjo, {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
        <div class="signature">
            <p>TTD Admin</p>
            <p>_________________________</p>
        </div>
    </div>

</body>

</html>
