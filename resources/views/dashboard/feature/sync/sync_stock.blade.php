@include('dashboard.components.head')
<div class="container-fluid p-0">
    @if (session()->has('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "{{ session('success') }}", // Menampilkan pesan dari session
                });
            });
        </script>
    @endif
    <h1 class="h3 mb-3"><strong>Laporan</strong> Barang Masuk</h1>
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill p-4">
                <div class="d-flex justify-content-center mb-4">
                    <div class="border p-3 rounded" style="width: 300px;">
                        <h5 class="text-center mb-3">PILIH STOK BARANG - METODE FIFO</h5>
                        <form action="{{ route('syncStockFIFO') }}" method="GET">
                            <!-- Dropdown Nama Barang -->
                            <div class="mb-3">
                                <label for="item_name" class="form-label">Nama Barang</label>
                                <select class="form-select" id="item_name" name="item_code">
                                    <option value="">Pilih Nama Barang</option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id_mdgoods }}" data-code="{{ $item->code_mdgoods }}"
                                            {{ old('item_code', request('item_code')) == $item->id_mdgoods ? 'selected' : '' }}>
                                            {{ $item->name_mdgoods }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Input Kode Barang (Readonly) -->
                            <div class="mb-3">
                                <label for="item_code" class="form-label">Kode Barang</label>
                                <input type="text" class="form-control" id="item_code" name="item_code_display"
                                    value="{{ old('item_code_display') }}" readonly>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                        </form>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const dropdown = document.getElementById('item_name');
                        const itemCodeInput = document.getElementById('item_code');

                        function updateItemCode() {
                            const selectedOption = dropdown.options[dropdown.selectedIndex];
                            const selectedCode = selectedOption.getAttribute('data-code') || '';
                            itemCodeInput.value = selectedCode;
                        }

                        // Set default jika sudah ada item_code yang dipilih sebelumnya
                        updateItemCode();

                        // Update item_code saat dropdown berubah
                        dropdown.addEventListener('change', updateItemCode);
                    });
                </script>

                <div class="d-flex justify-content-between mb-3">
                    <div class="d-flex">
                        <div class="align-self-center"
                            style="border: 1px solid #000; padding: 5px; border-radius: 5px; margin-right: 15px;">
                            <span>Data barang masuk : </span>
                        </div>
                        <a href="{{ route('pdfSyncStockFIFO') }}" class="btn btn-danger me-2">
                            <i class="align-middle" data-feather="file"></i> Cetak PDF
                        </a>
                        <div class="align-self-center">
                            <span>Total Data: {{ $totalData }}</span>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="me-3">
                            <form action="{{ route('indexOutboundItems') }}" method="GET">
                                <input type="text" class="form-control" placeholder="Search..." id="searchInput"
                                    name="search" value="{{ request('search') }}">
                            </form>
                        </div>
                        <div>
                            <form action="{{ route('indexOutboundItems') }}" method="GET">
                                <select class="form-select" id="entriesDropdown" name="entries"
                                    onchange="this.form.submit()">
                                    <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>Show 10
                                    </option>
                                    <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>Show 25
                                    </option>
                                    <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>Show 50
                                    </option>
                                    <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>Show 100
                                    </option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th rowspan="2">Tanggal Input</th>
                            <th rowspan="2">Status Barang</th>
                            <th rowspan="2">Kode Invoice</th>
                            <th colspan="3" class="text-center">Masuk</th>
                            <th colspan="3" class="text-center">Keluar</th>
                            <th rowspan="2">Stok Inventaris Harga</th>
                            <th rowspan="2">Total Harga</th>
                        </tr>
                        <tr>
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
                            $totalMasukQty = 0;
                            $totalMasukHarga = 0;
                            $totalMasukTotal = 0;
                            $totalKeluarQty = 0;
                            $totalKeluarHarga = 0;
                            $totalKeluarTotal = 0;
                            $fifoStock = []; // FIFO: Array untuk menyimpan stok masuk
                        @endphp

                        @if ($data->isEmpty())
                            <tr>
                                <td colspan="11" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        @endif

                        @foreach ($data as $datas)
                            @php
                                $tanggalInput = \Carbon\Carbon::parse($datas->created_at)
                                    ->locale('id')
                                    ->translatedFormat('d F Y');
                                $isInbound = $datas->type == 'inbound';

                                if ($isInbound) {
                                    // Tambahkan ke FIFO
                                    $fifoStock[] = [
                                        'qty' => $datas->quantity,
                                        'price' => $datas->purchase_price,
                                        'total' => $datas->total_price,
                                    ];

                                    $totalMasukQty += $datas->quantity;
                                    $totalMasukHarga += $datas->purchase_price;
                                    $totalMasukTotal += $datas->total_price;
                                } else {
                                    // Proses FIFO untuk barang keluar
                                    $keluarQty = $datas->quantity;
                                    $keluarTotalHarga = 0;
                                    $keluarHargaPerItem = 0;

                                    while ($keluarQty > 0 && count($fifoStock) > 0) {
                                        $batch = array_shift($fifoStock);
                                        if ($keluarQty >= $batch['qty']) {
                                            $keluarTotalHarga += $batch['total'];
                                            $keluarHargaPerItem = $batch['price'];
                                            $keluarQty -= $batch['qty'];
                                        } else {
                                            $keluarTotalHarga += $keluarQty * $batch['price'];
                                            $keluarHargaPerItem = $batch['price'];
                                            $batch['qty'] -= $keluarQty;
                                            array_unshift($fifoStock, $batch);
                                            $keluarQty = 0;
                                        }
                                    }

                                    $totalKeluarQty += $datas->quantity;
                                    $totalKeluarHarga += $keluarHargaPerItem;
                                    $totalKeluarTotal += $keluarTotalHarga;
                                }

                                // Hitung stok inventaris yang tersisa
                                $totalStokInventaris = array_sum(array_column($fifoStock, 'total'));
                            @endphp

                            <tr>
                                <td>{{ $tanggalInput }}</td>
                                <td>{{ $isInbound ? 'Barang Masuk' : 'Barang Keluar' }}</td>
                                <td>{{ $datas->invoice_code }}</td>
                                <td>{{ $isInbound ? $datas->quantity : '-' }}</td>
                                <td>{{ $isInbound ? 'Rp. ' . number_format($datas->purchase_price, 0, ',', '.') : '-' }}
                                </td>
                                <td>{{ $isInbound ? 'Rp. ' . number_format($datas->total_price, 0, ',', '.') : '-' }}
                                </td>
                                <td>{{ !$isInbound ? $datas->quantity : '-' }}</td>
                                <td>{{ !$isInbound ? 'Rp. ' . number_format($keluarHargaPerItem, 0, ',', '.') : '-' }}
                                </td>
                                <td>{{ !$isInbound ? 'Rp. ' . number_format($keluarTotalHarga, 0, ',', '.') : '-' }}
                                </td>
                                <td>Rp. {{ number_format($totalStokInventaris, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($totalMasukTotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                    @if ($data->isNotEmpty())
                        <tfoot>
                            <tr class="table-dark">
                                <th colspan="3" class="text-end">Total</th>
                                <th>{{ $totalMasukQty }}</th>
                                <th>Rp. {{ number_format($totalMasukHarga, 0, ',', '.') }}</th>
                                <th>Rp. {{ number_format($totalMasukTotal, 0, ',', '.') }}</th>
                                <th>{{ $totalKeluarQty }}</th>
                                <th>Rp. {{ number_format($totalKeluarHarga, 0, ',', '.') }}</th>
                                <th>Rp. {{ number_format($totalKeluarTotal, 0, ',', '.') }}</th>
                                <th>Rp. {{ number_format(array_sum(array_column($fifoStock, 'total')), 0, ',', '.') }}
                                </th>
                                <th>Rp. {{ number_format($totalMasukTotal, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    @endif
                </table> --}}

                {{-- <div class="table-responsive">
                    <table class="styled-table">
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
                                    $inTotal = $inQty && $inHarga ? $inQty * $inHarga : null;

                                    $outQty = $stock->type == 'outbound' ? $stock->quantity_out : null;
                                    $outHarga = $stock->type == 'outbound' ? $stock->purchase_price : null;
                                    $outTotal = $outQty && $outHarga ? $outQty * $outHarga : null;

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
                                    <td>{{ $stock->input_date }}</td>
                                    <td>{{ $stock->invoice_code }}</td>

                                    <td>{{ $inQty ?? '-' }}</td>
                                    <td>{{ $inHarga ? 'Rp ' . number_format($inHarga, 0, ',', '.') : '-' }}</td>
                                    <td>{{ $inTotal ? 'Rp ' . number_format($inTotal, 0, ',', '.') : '-' }}</td>

                                    <td>{{ $outQty ?? '-' }}</td>
                                    <td>{{ $outHarga ? 'Rp ' . number_format($outHarga, 0, ',', '.') : '-' }}</td>
                                    <td>{{ $outTotal ? 'Rp ' . number_format($outTotal, 0, ',', '.') : '-' }}</td>

                                    <td>{{ $saldoQty }}</td>
                                    <td>{{ $saldoHarga ? 'Rp ' . number_format($saldoHarga, 0, ',', '.') : '-' }}</td>
                                    <td>{{ $saldoTotal ? 'Rp ' . number_format($saldoTotal, 0, ',', '.') : '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2">TOTAL</th>
                                <th>{{ $totalInQty }}</th>
                                <th></th>
                                <th>{{ 'Rp ' . number_format($totalInHarga, 0, ',', '.') }}</th>
                                <th>{{ $totalOutQty }}</th>
                                <th></th>
                                <th>{{ 'Rp ' . number_format($totalOutHarga, 0, ',', '.') }}</th>
                                <th>{{ $saldoQty }}</th>
                                <th></th>
                                <th>{{ 'Rp ' . number_format($saldoTotal, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>


                <br> --}}
                <div class="table-responsive">
                    <table class="styled-table">
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
                </div>



                {{-- Pagination --}}
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <p class="text-muted">
                            Menampilkan {{ $data->firstItem() }} hingga {{ $data->lastItem() }} dari
                            {{ $data->total() }} data.
                        </p>
                    </div>
                    <div>
                        {{ $data->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@include('dashboard.components.foodcomp')
