@include('dashboard.components.head')

<div class="container-fluid p-0">

    <h1 class="h3 mb-3"><strong>Data Master</strong> - Tambah Barang</h1>
    <div class="row">
        <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill p-4">
                {{-- Form to add new Goods --}}
                <form action="{{ route('storeGoods') }}" method="POST">
                <form action="" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label for="name" class="form-label">Tanggal Input</label>
                        <input type="date" class="form-control" id="created_mdgoods" name="created_mdgoods"
                            value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="mb-2">
                        <label for="name" class="form-label">User</label>
                        <input type="text" class="form-control" id="id_user" name="id_user"
                            value="{{ Auth::user()->name }}" readonly>
                    </div>

                    <div class="mb-2">
                        <label for="name" class="form-label">Kode Barang</label>
                        <input type="text" class="form-control" id="code_mdgoods" name="code_mdgoods"
                            value="{{ $code }}" readonly>
                    </div>

                    <div class="mb-2">
                        <label for="name" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="name" name="name_mdgoods">
                    </div>

                    <div class="mb-2">
                        <label for="name" class="form-label">Kategori</label>
                        <select class="form-select" id="idcategory_mdgoods" name="idcategory_mdgoods">
                            <option selected>Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id_mdcategory }}">{{ $category->name_mdcategory }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="name" class="form-label">Satuan</label>
                        <select class="form-select" id="idunit_mdgoods" name="idunit_mdgoods">
                            <option selected>Pilih Satuan</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id_mdunit }}">{{ $unit->name_mdunit }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="name" class="form-label">Harga Beli</label>
                        <input type="text" class="form-control" id="purchase_price_mdgoods"
                            name="purchase_price_mdgoods">
                    </div>

                    <div class="mb-2">
                        <label for="name" class="form-label">Harga Jual</label>
                        <input type="text" class="form-control" id="selling_price_mdgoods"
                            name="selling_price_mdgoods">
                    </div>

                    <div class="mb-2">
                        <label for="name" class="form-label">Supplier</label>
                        <select class="form-select" id="idsupplier_mdgoods" name="idsupplier_mdgoods">
                            <option selected>Pilih Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id_mdsupplier }}"
                                    data-code="{{ $supplier->code_mdsupplier }}">{{ $supplier->name_mdsupplier }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="name" class="form-label">Kode Supplier</label>
                        <input type="text" class="form-control" id="code_supplier_mdgoods" name="code_supplier_mdgoods" readonly>
                    </div>

                    <script>
                        document.getElementById('idsupplier_mdgoods').addEventListener('change', function() {
                            const selectedOption = this.options[this.selectedIndex];
                            const supplierCode = selectedOption.getAttribute('data-code');
                            document.getElementById('code_supplier_mdgoods').value = supplierCode ? supplierCode : '';
                        });
                    </script>


                    <div class="mb-2">
                        <label for="name" class="form-label">Stok</label>
                        <input type="text" class="form-control" id="stock_mdgoods" name="stock_mdgoods">
                    </div>



                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


@include('dashboard.components.foodcomp')
