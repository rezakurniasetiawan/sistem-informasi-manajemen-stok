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
                <div class="d-flex justify-content-center mb-4"
                    style="width: 20%; margin: 0 auto; border: 1px solid #000; padding: 10px; border-radius: 5px;">
                    <div class="d-flex flex-column align-items-center">
                        <div class="d-flex justify-content-between w-100">
                            <h5 class="align-self-start">Pilih Periode</h5>
                            <div class="align-self-end">
                                <hr style="border: 1px solid #000; width: 100%;">
                            </div>
                        </div>
                        <form action="{{ route('indexInboundItems') }}" method="GET"
                            class="d-flex flex-column align-items-center">
                            <div class="mb-2" style="width: 100%;">
                                <input type="date" class="form-control" name="start_date" required>
                            </div>
                            <div class="mb-4" style="width: 100%;">
                                <input type="date" class="form-control" name="end_date" required>
                            </div>
                            <button type="submit" class="btn btn-primary" style="width: 100%;">Tampilkan</button>
                        </form>
                    </div>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div class="d-flex">
                        <div class="align-self-center"
                            style="border: 1px solid #000; padding: 5px; border-radius: 5px; margin-right: 15px;">
                            <span>Data barang masuk : 10 - 15 Januari 2024</span>
                        </div>
                        <a href="{{ route('pdfInboundItems') }}" class="btn btn-danger me-2">
                            <i class="align-middle" data-feather="file"></i> Cetak PDF
                        </a>
                        <div class="align-self-center">
                            <span>Total Data: {{ $totalData }}</span>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="me-3">
                            <form action="{{ route('indexInboundItems') }}" method="GET">
                                <input type="text" class="form-control" placeholder="Search..." id="searchInput"
                                    name="search" value="{{ request('search') }}">
                            </form>
                        </div>
                        <div>
                            <form action="{{ route('indexInboundItems') }}" method="GET">
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
                            <th scope="col" style="width: 5%;">No</th>
                            <th scope="col">Tanggal Input</th>
                            <th scope="col">User</th>
                            <th scope="col">Kode Invoice</th>
                            <th scope="col">Kode Barang</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Satuan</th>
                            <th scope="col">Kode Supplier</th>
                            <th scope="col">Nama Supplier</th>
                            <th scope="col">Harga Beli</th>
                            <th scope="col">Jumlah Barang</th>
                            <th scope="col">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $datas)
                            <tr>
                                <td scope="row">
                                    {{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}.</td>
                                <td> {{ \Carbon\Carbon::parse($datas->created_at)->locale('id')->translatedFormat('d F Y') }}
                                </td>
                                <td>{{ $datas->user }}</td>
                                <td>{{ $datas->invoice_code }}</td>
                                <td>{{ $datas->code_mdgoods }}</td>
                                <td>{{ $datas->item_name }}</td>
                                <td>{{ $datas->name_mdunit }}</td>
                                <td>{{ $datas->code_mdsupplier }}</td>
                                <td>{{ $datas->supplier_name }}</td>
                                <td> Rp. {{ number_format($datas->purchase_price, 0, ',', '.') }}</td>
                                <td>{{ $datas->quantity }}</td>
                                <td> Rp. {{ number_format($datas->total_price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
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
