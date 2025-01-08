@include('dashboard.components.head')
<div class="container-fluid p-0">

    <div class="d-flex align-items-center mb-3">
        <!-- Tombol Back -->
        <a href="{{ url()->previous() }}" class="btn btn-secondary me-3">
            &larr; Back
        </a>
        <h1 class="h3"><strong>Transaksi</strong> - Edit Barang Keluar</h1>
    </div>
    <div class="row">
        <div class="col-6 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill p-4">
                <form action="{{ route('updateInboundItems', $data->id_inbound_items) }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id_inbound_items }}">
                    {{-- Tanggal Input --}}
                    <div class="mb-2">
                        <label for="name" class="form-label">Tanggal Input</label>
                        <input type="date" class="form-control" id="input_date" name="input_date"
                            value="{{ \Carbon\Carbon::parse($data->input_date)->format('Y-m-d') }}">
                    </div>

                    {{-- User --}}
                    <div class="mb-2">
                        <label for="name" class="form-label">User</label>
                        <input type="text" class="form-control" id="user" name="user"
                            value="{{ $data->user }}" readonly>
                    </div>

                    {{-- Kode Invoice --}}
                    <div class="mb-2">
                        <label for="name" class="form-label">Kode Invoice</label>
                        <input type="text" class="form-control" id="invoice_code" name="invoice_code",
                            value="{{ $data->invoice_code }}" readonly>
                    </div>

                    {{-- Kode Barang --}}
                    <div class="mb-2">
                        <label for="name" class="form-label">Kode Barang</label>
                        <select class="form-select" id="item_code" name="item_code">
                            <option selected>Pilih Kode Barang</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id_mdgoods }}" data-name="{{ $item->name_mdgoods }}"
                                    data-unit="{{ $item->idunit_mdgoods }}"
                                    {{ $data->item_code == $item->id_mdgoods ? 'selected' : '' }}>
                                    {{ $item->code_mdgoods }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Nama Barang --}}
                    <div class="mb-2">
                        <label for="name" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="item_name" name="item_name"
                            value="{{ $data->item_name }}" readonly>
                    </div>

                    {{-- Satuan --}}
                    <div class="mb-2">
                        <label for="name" class="form-label">Satuan</label>
                        <input type="text" class="form-control" id="unit" name="unit"
                            value="{{ $data->unit }}" readonly>
                    </div>

                    <script>
                        document.getElementById('item_code').addEventListener('change', function() {
                            const selectedOption = this.options[this.selectedIndex];
                            const itemName = selectedOption.getAttribute('data-name');
                            const itemUnit = selectedOption.getAttribute('data-unit');
                            document.getElementById('item_name').value = itemName ? itemName : '';
                            document.getElementById('unit').value = itemUnit ? itemUnit : '';
                        });
                    </script>

                    {{-- Kode Supplier --}}

                    <div class="mb-2">
                        <label for="name" class="form-label">Kode Supplier</label>
                        <select class="form-select" id="supplier_code" name="supplier_code">
                            <option selected>Pilih Kode Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id_mdsupplier }}"
                                    data-name="{{ $supplier->name_mdsupplier }}"
                                    {{ $data->supplier_code == $supplier->id_mdsupplier ? 'selected' : '' }}>
                                    {{ $supplier->code_mdsupplier }}
                                </option>
                            @endforeach
                        </select>

                    </div>

                    {{-- Nama Supplier --}}

                    <div class="mb-2">
                        <label for="name" class="form-label">Nama Supplier</label>
                        <input type="text" class="form-control" id="supplier_name" name="supplier_name"
                            value="{{ $data->supplier_name }}" readonly>

                    </div>

                    <script>
                        document.getElementById('supplier_code').addEventListener('change', function() {
                            const selectedOption = this.options[this.selectedIndex];
                            const supplierName = selectedOption.getAttribute('data-name');
                            document.getElementById('supplier_name').value = supplierName ? supplierName : '';
                        });
                    </script>

                    {{-- Harga Beli --}}

                    <div class="mb-2">
                        <label for="name" class="form-label">Harga Beli</label>
                        <input type="number" class="form-control" id="purchase_price" name="purchase_price"
                            value="{{ $data->purchase_price }}">
                    </div>

                    {{-- Jumlah Barang --}}
                    <div class="mb-2">
                        <label for="name" class="form-label">Jumlah Barang</label>
                        <input type="number" class="form-control" id="quantity" name="quantity"
                            value="{{ $data->quantity }}">

                    </div>

                    {{-- Total Harga --}}

                    <div class="mb-2">
                        <label for="name" class="form-label">Total Harga</label>
                        <input type="number" class="form-control" id="total_price" name="total_price"
                            value="{{ $data->total_price }}" readonly>
                    </div>

                    <script>
                        document.getElementById('purchase_price').addEventListener('input', function() {
                            const purchasePrice = this.value;
                            const quantity = document.getElementById('quantity').value;
                            const totalPrice = purchasePrice * quantity;
                            document.getElementById('total_price').value = totalPrice;
                        });

                        document.getElementById('quantity').addEventListener('input', function() {
                            const quantity = this.value;
                            const purchasePrice = document.getElementById('purchase_price').value;
                            const totalPrice = purchasePrice * quantity;
                            document.getElementById('quantity').value = quantity;
                        });
                    </script>




                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


@include('dashboard.components.foodcomp')
