@include('dashboard.components.head')

<div class="container-fluid p-0">

    <h1 class="h3 mb-3"><strong>Data Master</strong> - Tambah Satuan</h1>
    <div class="row">
        <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill p-4">
                {{-- Form to add new unit --}}
                <form action="{{ route('storeUnit') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Satuan</label>
                        <input type="text" class="form-control" id="name" name="name_mdunit">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


@include('dashboard.components.foodcomp')
