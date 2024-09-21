@include('dashboard.components.head')

<div class="container-fluid p-0">
    <div class="d-flex align-items-center mb-3">
        <!-- Tombol Back -->
        <a href="{{ url()->previous() }}" class="btn btn-secondary me-3">
            &larr; Back
        </a>
        <h1 class="h3 mb-3"><strong>Data Master</strong> - Edit Satuan</h1>
    </div>
    <div class="row">
        <div class="col-6 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill p-4">
                {{-- Form to add new unit --}}
                <form action="{{ route('updateUnit', $data->id_mdunit) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kategori</label>
                        <input type="text" value="{{ $data->id_mdunit }}" hidden>
                        <input type="text" class="form-control" id="name" name="name_mdunit"
                            value="{{ $data->name_mdunit }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@include('dashboard.components.foodcomp')
