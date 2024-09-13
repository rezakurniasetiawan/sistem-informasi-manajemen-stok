@include('dashboard.components.head')

<div class="container-fluid p-0">

    <h1 class="h3 mb-3"><strong>Data Master</strong> - Edit Satuan</h1>
    <div class="row">
        <div class="col-6 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill p-4">
                {{-- Form to add new satuan --}}
                <form action="{{ route('updateSatuan', $data->id_mdsatuan) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kategori</label>
                        <input type="text" value="{{ $data->id_mdsatuan }}" hidden>
                        <input type="text" class="form-control" id="name" name="name_mdsatuan"
                            value="{{ $data->name_mdsatuan }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@include('dashboard.components.foodcomp')
