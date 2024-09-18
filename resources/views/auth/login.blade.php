<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="{{ asset('img/icons/icon-48x48.png') }}" />

    <title>Sign In</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        /* Styling for mobile access message */
        .mobile-warning {
            display: none;
            text-align: center;
            margin-top: 20px;
            font-size: 1.2em;
            color: red;
        }
    </style>
</head>

<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-6 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <!-- Message for mobile access -->
                        <div class="mobile-warning">
                            Sementata ini, Akses hanya bisa di browser laptop.
                        </div>

                        <!-- Sign in form -->
                        <div class="card login-form">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <div class="text-center mt-4">
                                        <h1 class="h2">Welcome back Admin</h1>
                                    </div>
                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            <b>Opps!</b> {{ session('error') }}
                                        </div>
                                    @endif
                                    <form action="{{ route('actionlogin') }}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input class="form-control form-control-lg" type="username" name="username"
                                                placeholder="Enter your username" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input class="form-control form-control-lg" type="password" name="password"
                                                placeholder="Enter your password" />
                                        </div>
                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-lg btn-primary w-100">Sign in</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Function to check if the device is mobile
        function isMobileDevice() {
            return /Mobi|Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
        }

        // Hide the login form and show warning message for mobile devices
        if (isMobileDevice()) {
            document.querySelector('.login-form').style.display = 'none';
            document.querySelector('.mobile-warning').style.display = 'block';
        }
    </script>

    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>
