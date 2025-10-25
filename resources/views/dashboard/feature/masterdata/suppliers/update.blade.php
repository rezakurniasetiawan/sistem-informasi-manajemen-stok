@include('dashboard.components.head')

<div class="container-fluid p-0">
    <div class="d-flex align-items-center mb-3">
        <!-- Tombol Back -->
        <a href="{{ url()->previous() }}" class="btn btn-secondary me-3">
            &larr; Back
        </a>
        <h1 class="h3 mb-3"><strong>Data Master</strong> - Edit Supplier</h1>
    </div>
    <div class="row">
        <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill p-4">
                {{-- Form to add new unit --}}
                <form action="{{ route('updateSupplier', $data->id_mdsupplier) }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label for="name" class="form-label">Tanggal Input</label>
                        <input type="text" class="form-control" id="created_mdsupplier" name="created_mdsupplier"
                            value="{{ \Carbon\Carbon::parse($data->created_mdsupplier)->format('d-m-Y') }}" readonly>
                    </div>


                    <div class="mb-2">
                        <label for="name" class="form-label">User</label>
                        <input type="text" class="form-control" id="id_user" name="id_user"
                            value="{{ $data->name }}" readonly>
                    </div>

                    <div class="mb-2">
                        <label for="name" class="form-label">Kode Supplier</label>
                        <input type="text" class="form-control" id="code_mdsupplier" name="code_mdsupplier"
                            value="{{ $data->code_mdsupplier }}" readonly>
                    </div>

                    <div class="mb-2">
                        <label for="name" class="form-label">Nama Supplier</label>
                        <input type="text" class="form-control" id="name_mdsupplier" name="name_mdsupplier"
                            value="{{ $data->name_mdsupplier }}">
                    </div>

                    <div class="mb-2">
                        <label for="name" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="address_mdsupplier" name="address_mdsupplier"
                            value="{{ $data->address_mdsupplier }}">
                    </div>

                    <div class="mb-2">
                        <label for="name" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email_mdsupplier" name="email_mdsupplier"
                            value="{{ $data->email_mdsupplier }}">
                    </div>

                    <div class="mb-2">
                        <label for="name" class="form-label">No Telp</label>
                        <input type="text" class="form-control" id="phone_mdsupplier" name="phone_mdsupplier"
                            value="{{ $data->phone_mdsupplier }}">
                    </div>


                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


@include('dashboard.components.foodcomp')
