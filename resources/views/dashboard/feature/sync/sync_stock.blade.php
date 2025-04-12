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
    <h1 class="h3 mb-3"><strong>Transaksi</strong> Barang Masuk</h1>
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill p-4">
                <div class="d-flex justify-content-center mb-4">
                    <div class="border p-3 rounded" style="width: 300px;">
                        <h5 class="text-center mb-3">PILIH STOK BARANG - METODE FIFO</h5>
                        <form action="{{ route('syncStock') }}" method="GET">
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
                        <a href="{{ route('pdfOutboundItems') }}" class="btn btn-danger me-2">
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
                <table class="table table-striped table-bordered">
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
                </table>


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
