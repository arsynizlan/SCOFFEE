<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('mazer/assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/css/pages/auth.css') }}">
    <link rel="shortcut icon" href="{{ asset('mazer/assets/images/logo/logomini.png') }}" type="image/png">
    <script src="{{ asset('mazer/assets/js/bootstrap.js') }}"></script>
    <script src="{{ asset('mazer/assets/js/app.js') }}"></script>

</head>

<body>
    <div id="auth">
        <div class="container mx-auto mt-5 col-lg-5">
            <h1 class="auth-title">Log in.</h1>
            <p class="auth-subtitle mb-5">Log in with your email.</p>

            @if (session()->has('loginError'))
                <div class="alert alert-danger alert-dismissible show fade">
                    {{ session('loginError') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST">
                @csrf
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="email" name="email" class="form-control form-control-xl" placeholder="Email"
                        required>

                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="password" name="password" class="form-control form-control-xl" placeholder="Password"
                        required>
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>

                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-3">Log in</button>
            </form>
        </div>
    </div>
    </div>

    </div>
</body>

</html>
