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
            text-align: right;
            display: flex;
            justify-content: flex-end;
        }

        .footer .signature .line {
            width: 200px;
            border-top: 1px solid black;
        }

        .footer .signature p {
            margin-right: 60px;
            margin-bottom: 0;
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
                <th>Nama</th>
                <th>Username</th>
                <th>Hak Akses</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td> {{ \Carbon\Carbon::parse($item->created_at)->locale('id')->translatedFormat('d F Y') }}
                    </td>
                    <td> {{ $item->name }} </td>
                    <td> {{ $item->username }} </td>
                    <td> {{ $item->role }} </td>
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
