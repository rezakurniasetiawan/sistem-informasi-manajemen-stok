@include('dashboard.components.head')

<div class="container-fluid p-0">

    <h1 class="h3 mb-3"><strong>Data Master</strong> - Tambah User</h1>
    <div class="row">
        <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill p-4">
                {{-- Form to add new category --}}
                <form action="{{ route('storeUser') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-2">
                        <label for="name" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <label for="name" class="form-label">Password</label>
                    <div class="mb-2 password-wrapper">
                        <input class="form-control form-control-lg" id="password" type="password" name="password"
                            placeholder="Enter your password" />
                        <i class="toggle-password" data-feather="eye" onclick="togglePasswordVisibility()"></i>
                    </div>
                    <div class="mb-4">
                        <label for="name" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role">
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


@include('dashboard.components.foodcomp')
