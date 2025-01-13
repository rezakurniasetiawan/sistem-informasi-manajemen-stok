<!DOCTYPE html>
<html>

<head>
    <title>Cetak PDF</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 20px;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
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
            margin-bottom: 20px;
            font-size: 11px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }

        .footer .signature {
            margin-top: 50px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .footer .signature p {
            margin: 0;
            margin-right: 20px;
        }

        .footer .signature .line {
            width: 200px;
            border-top: 1px solid black;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="{{ public_path('path/to/logo.png') }}" alt="LOGO TOKO LIA">
        <h1>TOKO LISTRIK LIA</h1>
        <p>Jalan Bungurasih Utara I / 1B RT 5 RW 4, Waru - Sidoarjo 61256</p>
        <hr>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Input</th>
                <th>User</th>
                <th>Kode Invoice</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Kode Supplier</th>
                <th>Nama Supplier</th>
                <th>Harga Beli</th>
                <th>Jumlah Barang</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td> {{ \Carbon\Carbon::parse($item->created_at)->locale('id')->translatedFormat('d F Y') }}</td>
                    <td>{{ $item->user }}</td>
                    <td>{{ $item->invoice_code }}</td>
                    <td>{{ $item->code_mdgoods }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->name_mdunit }}</td>
                    <td>{{ $item->code_mdsupplier }}</td>
                    <td>{{ $item->supplier_name }}</td>
                    <td> Rp. {{ number_format($item->purchase_price, 0, ',', '.') }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td> Rp. {{ number_format($item->total_price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Sidoarjo, {{ \Carbon\Carbon::now()->format('Y/m/d') }}</p>
        <p>Admin Toko Listrik LIA</p>

        <div class="signature">
            <p>TTD Admin</p>
            <p>_________________</p>
            {{-- <div class="line"></div> --}}
        </div>
    </div>

</body>

</html>
