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
    <h1 class="h3 mb-3"><strong>Data Master</strong> - Kategori</h1>
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill p-4">
                <div class="d-flex justify-content-between mb-3">
                    <div class="d-flex">
                        <a href="{{ route('createCategory') }}" type="button" class="btn btn-primary me-2">
                            <i class="align-middle" data-feather="plus"></i> Tambah Baru
                        </a>

                        <a href="" class="btn btn-danger me-2">
                            <i class="align-middle" data-feather="file"></i> Cetak PDF
                        </a>

                        <div class="align-self-center">
                            <span>Total Data: {{ $totalData }}</span>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="me-3">
                            <input type="text" class="form-control" placeholder="Search..." id="searchInput">
                        </div>
                        <div>
                            <select class="form-select" id="entriesDropdown">
                                <option value="10">Show 10</option>
                                <option value="25">Show 25</option>
                                <option value="50">Show 50</option>
                                <option value="100">Show 100</option>
                            </select>
                        </div>
                    </div>
                </div>


                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" style="width: 5%;">No</th>
                            <th scope="col" style="width: 15%;">Tanggal Input</th>
                            <th scope="col" style="width: 60%;">Nama Kategori</th>
                            <th scope="col" style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $datas)
                            <tr>
                                <td scope="row">{{ $loop->iteration }}.</td>
                                <td> {{ \Carbon\Carbon::parse($datas->created_at)->locale('id')->translatedFormat('d F Y H:i') }}
                                </td>
                                <td> {{ $datas->name_mdcategory }} </td>
                                <td>
                                    <a href="{{ route('editCategory', $datas->id_mdcategory) }}" type="button"
                                        class="btn btn-warning"> <i class="align-middle" data-feather="edit"></i>
                                        Edit</a>
                                    <a href="{{ route('deleteCategory', $datas->id_mdcategory) }}" type="button"
                                        class="btn btn-danger" id="deleteCategoryButton-{{ $datas->id_mdcategory }}">
                                        <i class="align-middle" data-feather="trash"></i> Hapus
                                    </a>

                                    <script>
                                        document.getElementById('deleteCategoryButton-{{ $datas->id_mdcategory }}').addEventListener('click', function(
                                            event) {
                                            event.preventDefault(); // Mencegah link langsung dijalankan

                                            Swal.fire({
                                                title: 'Apakah Anda yakin?',
                                                text: "Data yang dihapus tidak dapat dikembalikan!",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#d33',
                                                cancelButtonColor: '#3085d6',
                                                confirmButtonText: 'Ya, hapus!',
                                                cancelButtonText: 'Batal'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = "{{ route('deleteCategory', $datas->id_mdcategory) }}";
                                                }
                                            });
                                        });
                                    </script>

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
