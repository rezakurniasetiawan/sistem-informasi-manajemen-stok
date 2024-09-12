@include('dashboard.components.head')
<div class="container-fluid p-0">

    <h1 class="h3 mb-3"><strong>Data Master</strong> - Kategori</h1>
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill p-4">
                <div class="d-flex justify-content-between mb-3">
                    <a href="{{ route('addKategori') }}" type="button" class="btn btn-primary"> <i class="align-middle"
                            data-feather="plus"></i> Tambah
                        Baru</a>
                </div>

                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" style="width: 10%;">No</th>
                            <th scope="col" style="width: 70%;">Kategori</th>
                            <th scope="col" style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $datas)
                            <tr>
                                <td scope="row">{{ $loop->iteration }}.</td>
                                <td> {{ $datas->name_mdcategory }} </td>
                                <td>
                                    {{-- <button type="button" class="btn btn-warning">
                                        <i class="align-middle" data-feather="edit"></i> Edit
                                    </button> --}}
                                    <a href="{{ route('editKategori', $datas->id_mdcategory) }}" type="button"
                                        class="btn btn-warning"> <i class="align-middle" data-feather="edit"></i>
                                        Edit</a>


                                    <button type="button" class="btn btn-danger">
                                        <i class="align-middle" data-feather="trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('dashboard.components.foodcomp')
