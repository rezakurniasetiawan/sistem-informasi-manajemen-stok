@include('dashboard.components.head')

<div class="container-fluid p-0">

    <h1 class="h3 mb-3"><strong>Data Master</strong> - Edit User</h1>
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

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@include('dashboard.components.foodcomp')
