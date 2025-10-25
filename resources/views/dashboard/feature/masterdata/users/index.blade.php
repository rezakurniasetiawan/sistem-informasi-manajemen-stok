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
    <h1 class="h3 mb-3"><strong>Data Master</strong> - User</h1>
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill p-4">
                <div class="d-flex justify-content-between mb-3">
                    <div class="d-flex">
                        <a href="{{ route('createUser') }}" type="button" class="btn btn-primary me-2">
                            <i class="align-middle" data-feather="plus"></i> Tambah Baru
                        </a>

                        <a href="{{ route('pdfUser') }}" class="btn btn-danger me-2">
                            <i class="align-middle" data-feather="file"></i> Cetak PDF
                        </a>

                        <div class="align-self-center">
                            <span>Total Data: {{ $totalData }}</span>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="me-3">
                            <form action="{{ route('indexUser') }}" method="GET">
                                <input type="text" class="form-control" placeholder="Search..." id="searchInput"
                                    name="search" value="{{ request('search') }}">
                            </form>
                        </div>
                        <div>
                            <form action="{{ route('indexUser') }}" method="GET">
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
                            <th scope="col" style="width: 15%;">Tanggal Input</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Username</th>
                            <th scope="col">Hak Akses</th>
                            <th scope="col" style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $datas)
                            <tr>
                                <td scope="row">
                                    {{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}.</td>
                                <td> {{ \Carbon\Carbon::parse($datas->created_at)->locale('id')->translatedFormat('d F Y') }}
                                <td> {{ $datas->name }} </td>
                                <td> {{ $datas->username }} </td>
                                <td> {{ $datas->role }} </td>
                                <td>

                                    @if ($datas->role == 'admin')
                                        <a href="{{ route('editUser', $datas->id) }}" type="button"
                                            class="btn btn-warning"> <i class="align-middle" data-feather="edit"></i>
                                            Edit</a>
                                        <a href="{{ route('deleteUser', $datas->id) }}" type="button"
                                            class="btn btn-danger" id="deleteuserButton-{{ $datas->id }}">
                                            <i class="align-middle" data-feather="trash"></i> Hapus
                                        </a>

                                        <script>
                                            document.getElementById('deleteuserButton-{{ $datas->id }}').addEventListener('click', function(
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
                                                        window.location.href = "{{ route('deleteUser', $datas->id) }}";
                                                    }
                                                });
                                            });
                                        </script>
                                    @endif
                                    @if ($datas->role == 'superadmin' && Auth::user()->role == 'superadmin')
                                        <a href="{{ route('deleteUser', $datas->id) }}" type="button"
                                            class="btn btn-danger" id="notDeleteButton">
                                            <i class="align-middle" data-feather="trash"></i> Hapus
                                        </a>

                                        <script>
                                            document.getElementById('notDeleteButton').addEventListener('click', function(
                                                event) {
                                                event.preventDefault(); // Mencegah link langsung dijalankan

                                                Swal.fire({
                                                    title: 'Tidak Bisa Menghapus',
                                                    text: "Anda tidak bisa menghapus akun anda sendiri!",
                                                    icon: 'warning',
                                                    showCancelButton: false,
                                                    confirmButtonColor: '#3085d6',
                                                    confirmButtonText: 'Oke'
                                                });
                                            });
                                        </script>
                                    @elseif ($datas->role == 'superadmin')
                                        <a href="{{ route('deleteUser', $datas->id) }}" type="button"
                                            class="btn btn-danger" id="notDeleteButton">
                                            <i class="align-middle" data-feather="trash"></i> Hapus
                                        </a>

                                        <script>
                                            document.getElementById('notDeleteButton').addEventListener('click', function(
                                                event) {
                                                event.preventDefault(); // Mencegah link langsung dijalankan

                                                Swal.fire({
                                                    title: 'Tidak Bisa Menghapus',
                                                    text: "Anda tidak bisa menghapus superadmin!",
                                                    icon: 'warning',
                                                    showCancelButton: false,
                                                    confirmButtonColor: '#3085d6',
                                                    confirmButtonText: 'Oke'
                                                });
                                            });
                                        </script>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

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
