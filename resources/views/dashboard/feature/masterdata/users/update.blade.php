@include('dashboard.components.head')

<div class="container-fluid p-0">

    <div class="d-flex align-items-center mb-3">
        <!-- Tombol Back -->
        <a href="{{ url()->previous() }}" class="btn btn-secondary me-3">
            &larr; Back
        </a>
        <h1 class="h3 mb-3"><strong>Data Master</strong> - Edit User</h1>
    </div>
    <div class="row">
        <div class="col-6 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill p-4">
                {{-- Form to add new User --}}
                <form action="{{ route('updateUser', $data->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama User</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $data->name }}">
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="username" class="form-control" id="username" name="username"
                            value="{{ $data->username }}">
                    </div>

                    <label for="password" class="form-label">Password Baru (kosongkan jika tidak ingin
                        mengubah)</label>
                    <div class="mb-2 password-wrapper">
                        <input class="form-control form-control-lg" id="password" type="password" name="password" />
                        <i class="toggle-password" data-feather="eye" onclick="togglePasswordVisibility()"></i>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@include('dashboard.components.foodcomp')
