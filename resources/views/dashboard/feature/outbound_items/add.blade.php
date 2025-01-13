@include('dashboard.components.head')
<div class="container-fluid p-0">

    <h1 class="h3 mb-3"><strong>Tambah</strong> - Transaksi Barang Keluar</h1>
    <div class="row">
        <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill p-4">
                {{-- Form to add new Goods --}}
                <form action="{{ route('storeOutboundItems') }}" method="POST">
                    @csrf

                    {{-- Tanggal Input --}}
                    <div class="mb-2">
                        <label for="name" class="form-label">Tanggal Input</label>
                        <input type="date" class="form-control" id="input_date" name="input_date"
                            value="{{ date('Y-m-d') }}">
                    </div>

                    {{-- User --}}
                    <div class="mb-2">
                        <label for="name" class="form-label">User</label>
                        <input type="text" class="form-control" id="user" name="user"
                            value="{{ Auth::user()->name }}" readonly>
                    </div>

                    {{-- Kode Invoice --}}
                    <div class="mb-2">
                        <label for="name" class="form-label">Kode Invoice</label>
                        <input type="text" class="form-control" id="invoice_code" name="invoice_code",
                            value="{{ $code }}" readonly>
                    </div>

                    {{-- Kode Barang --}}
                    <div class="mb-2">
                        <label for="name" class="form-label">Kode Barang</label>
                        <select class="form-select" id="item_code" name="item_code">
                            <option selected>Pilih Kode Barang</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id_mdgoods }}" data-name="{{ $item->name_mdgoods }}"
                                    data-unit="{{ $item->idunit_mdgoods }}">
                                    {{ $item->code_mdgoods }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Nama Barang --}}
                    <div class="mb-2">
                        <label for="name" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="item_name" name="item_name" readonly>
                    </div>

                    {{-- Satuan --}}
                    <div class="mb-2">
                        <label for="name" class="form-label">Satuan</label>
                        <input type="text" class="form-control" id="unit" name="unit" readonly>
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
                            <option selected>Pilih Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id_mdsupplier }}"
                                    data-name="{{ $supplier->name_mdsupplier }}">
                                    {{ $supplier->code_mdsupplier }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Nama Supplier --}}
                    <div class="mb-2">
                        <label for="name" class="form-label">Nama Supplier</label>
                        <input type="text" class="form-control" id="supplier_name" name="supplier_name" readonly>
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
                        <input type="text" class="form-control" id="hargabeli" name="purchase_price">
                    </div>

                    {{-- Jumlah Barang --}}
                    <div class="mb-2">
                        <label for="name" class="form-label">Jumlah Barang</label>
                        <input type="text" class="form-control" id="quantity" name="quantity">
                    </div>

                    {{-- Total Harga --}}
                    <div class="mb-2">
                        <label for="name" class="form-label">Total Harga</label>
                        <input type="text" class="form-control" id="total_price" name="total_price">
                    </div>



                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        var hargabeli = document.getElementById('hargabeli');
        hargabeli.addEventListener('keyup', function(e) {
            hargabeli.value = formatRupiah(this.value, 'Rp. ');
        });

        // total_price
        var total_price = document.getElementById('total_price');
        total_price.addEventListener('keyup', function(e) {
            total_price.value = formatRupiah(this.value, 'Rp. ');
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        var hargajual = document.getElementById('hargajual');
        hargajual.addEventListener('keyup', function(e) {
            hargajual.value = formatRupiah(this.value, 'Rp. ');
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    </script>
</div>

@include('dashboard.components.foodcomp')
