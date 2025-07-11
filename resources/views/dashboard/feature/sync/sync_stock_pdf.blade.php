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
        <p>Jalan Bungurasih Utara I / 1A RT 5 RW 4, Waru - Sidoarjo 61256</p>
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
                $fifoQueue = []; // Queue untuk menyimpan batch barang masuk (qty dan harga)
                $totalInQty = 0;
                $totalInHarga = 0;
                $totalOutQty = 0;
                $totalOutHarga = 0;
                // Saldo akhir untuk total baris
                $finalSaldoQty = 0;
                $finalSaldoTotal = 0;
            @endphp

            @foreach ($stocks as $stock)
                @php
                    $inQty = null;
                    $inHarga = null;
                    $inTotal = null;
                    $outQty = null;
                    $outHarga = null; // Harga rata-rata barang keluar dari batch FIFO
                    $outTotal = null; // Total harga barang keluar dari batch FIFO
                @endphp

                {{-- Barang Masuk --}}
                @if ($stock->type == 'inbound')
                    @php
                        $inQty = $stock->quantity;
                        $inHarga = $stock->purchase_price;
                        $inTotal = $inQty * $inHarga;

                        // Tambahkan batch baru ke FIFO queue
                        $fifoQueue[] = ['qty' => $inQty, 'harga' => $inHarga];

                        $totalInQty += $inQty;
                        $totalInHarga += $inTotal;
                    @endphp

                    {{-- Baris Barang Masuk --}}
                    <tr>
                        <td>{{ $stock->input_date }}</td>
                        <td>{{ $stock->invoice_code }}</td>
                        <td>{{ $inQty }}</td>
                        <td>{{ 'Rp. ' . number_format($inHarga, 0, ',', '.') }}</td>
                        <td>{{ 'Rp. ' . number_format($inTotal, 0, ',', '.') }}</td>
                        {{-- PERHATIKAN BAGIAN INI: Mengisi setiap sel kolom "Keluar" --}}
                        <td>-</td> {{-- Keluar (Qty) --}}
                        <td>-</td> {{-- Keluar (Harga) --}}
                        <td>-</td> {{-- Keluar (Total Harga) --}}
                        {{-- Kolom Persediaan (untuk detail batch yang baru masuk) --}}
                        <td>{{ $inQty }}</td>
                        <td>{{ 'Rp. ' . number_format($inHarga, 0, ',', '.') }}</td>
                        <td>{{ 'Rp. ' . number_format($inTotal, 0, ',', '.') }}</td>
                    </tr>

                    {{-- Tampilkan saldo sisa per batch setelah barang masuk --}}
                    @foreach ($fifoQueue as $batch)
                        <tr style="background-color: #f9f9f9;">
                            <td colspan="8"></td> {{-- Ini adalah colspan yang mungkin menyebabkan masalah jika tidak sesuai --}}
                            <td>{{ $batch['qty'] }}</td>
                            <td>{{ 'Rp. ' . number_format($batch['harga'], 0, ',', '.') }}</td>
                            <td>{{ 'Rp. ' . number_format($batch['qty'] * $batch['harga'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                @endif

                {{-- Barang Keluar --}}
                @if ($stock->type == 'outbound')
                    @php
                        $outQty = $stock->quantity_out; // Kuantitas yang ingin dikeluarkan
                        $qtyToRemove = $outQty; // Sisa kuantitas yang perlu dikeluarkan
                        $removedQtyActual = 0; // Kuantitas aktual yang berhasil dikeluarkan
                        $outTotal = 0; // Total harga dari barang yang keluar

                        $newQueue = []; // Antrian baru setelah pengurangan

                        foreach ($fifoQueue as $batch) {
                            if ($qtyToRemove <= 0) {
                                // Jika tidak ada lagi kuantitas yang perlu dikeluarkan, tambahkan sisa batch ke antrian baru
                                $newQueue[] = $batch;
                                continue;
                            }

                            if ($batch['qty'] <= $qtyToRemove) {
                                // Jika batch saat ini lebih kecil atau sama dengan qty yang perlu dikeluarkan
                                $outTotal += $batch['qty'] * $batch['harga']; // Tambahkan ke total harga keluar
                                $removedQtyActual += $batch['qty']; // Tambahkan ke kuantitas aktual yang keluar
                                $qtyToRemove -= $batch['qty']; // Kurangi sisa qty yang perlu dikeluarkan
                                // Batch ini habis, tidak perlu ditambahkan ke newQueue
                            } else {
                                // Jika batch saat ini lebih besar dari qty yang perlu dikeluarkan
                                $outTotal += $qtyToRemove * $batch['harga']; // Ambil sebagian dari batch
                                $removedQtyActual += $qtyToRemove; // Tambahkan ke kuantitas aktual yang keluar
                                $batch['qty'] -= $qtyToRemove; // Kurangi qty di batch
                                $newQueue[] = $batch; // Tambahkan sisa batch ke antrian baru
                                $qtyToRemove = 0; // Sudah tidak ada lagi yang perlu dikeluarkan
                            }
                        }

                        $fifoQueue = $newQueue; // Update FIFO queue dengan antrian baru

                        $outHarga = $removedQtyActual > 0 ? $outTotal / $removedQtyActual : 0; // Hitung harga rata-rata barang keluar

                        $totalOutQty += $removedQtyActual;
                        $totalOutHarga += $outTotal;
                    @endphp

                    {{-- Baris Barang Keluar --}}
                    <tr>
                        <td>{{ $stock->input_date }}</td>
                        <td>{{ $stock->invoice_code }}</td>
                        {{-- PERHATIKAN BAGIAN INI: Mengisi setiap sel kolom "Masuk" --}}
                        <td>-</td> {{-- Masuk (Qty) --}}
                        <td>-</td> {{-- Masuk (Harga) --}}
                        <td>-</td> {{-- Masuk (Total Harga) --}}
                        <td>{{ $removedQtyActual }}</td>
                        <td>{{ 'Rp. ' . number_format($outHarga, 0, ',', '.') }}</td>
                        <td>{{ 'Rp. ' . number_format($outTotal, 0, ',', '.') }}</td>
                        {{-- PERHATIKAN BAGIAN INI: Mengisi setiap sel kolom "Persediaan" di baris utama --}}
                        <td>-</td> {{-- Persediaan (Qty) --}}
                        <td>-</td> {{-- Persediaan (Harga) --}}
                        <td>-</td> {{-- Persediaan (Total Harga) --}}
                    </tr>

                    {{-- Tampilkan saldo sisa per batch setelah barang keluar --}}
                    @foreach ($fifoQueue as $batch)
                        <tr style="background-color: #f9f9f9;">
                            <td colspan="8"></td> {{-- Ini adalah colspan yang mungkin menyebabkan masalah jika tidak sesuai --}}
                            <td>{{ $batch['qty'] }}</td>
                            <td>{{ 'Rp. ' . number_format($batch['harga'], 0, ',', '.') }}</td>
                            <td>{{ 'Rp. ' . number_format($batch['qty'] * $batch['harga'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            @endforeach

            @php
                // Hitung saldo akhir setelah semua transaksi untuk baris TOTAL
                $finalSaldoQty = collect($fifoQueue)->sum('qty');
                $finalSaldoTotal = collect($fifoQueue)->sum(fn($item) => $item['qty'] * $item['harga']);
            @endphp

            {{-- Total Baris --}}
            <tr style="font-weight: bold; background-color: #f0f0f0;">
                <td colspan="2">TOTAL</td>
                <td>{{ $totalInQty }}</td>
                <td></td> {{-- Tidak ada total harga per unit di kolom total masuk --}}
                <td>{{ 'Rp. ' . number_format($totalInHarga, 0, ',', '.') }}</td>
                <td>{{ $totalOutQty }}</td>
                <td></td> {{-- Tidak ada total harga per unit di kolom total keluar --}}
                <td>{{ 'Rp. ' . number_format($totalOutHarga, 0, ',', '.') }}</td>
                <td>{{ $finalSaldoQty }}</td>
                <td></td> {{-- Tidak ada total harga per unit di kolom total persediaan --}}
                <td>{{ 'Rp. ' . number_format($finalSaldoTotal, 0, ',', '.') }}</td>
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
