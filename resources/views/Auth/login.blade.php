<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="icon" href="{{asset('template/assets/dist/img/gg.png')}}">

    @include('layouts.style')
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="text-center">
            <!-- <img class="items-align-center" src="{{asset('template/assets/dist/img/logo_nyai2.png')}}" alt=""> -->
        </div>
        <div class="card card-outline card-success">
            <div class="card-header text-center">
                <a class="h3">Login Admin</a>
            </div>
            <div class="card-body">
                @if (session('loginError'))
                <script>
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Error!",
                        text: "Username atau password salah.",
                        showConfirmButton: true,
                    });
                </script>
                @endif
                <form action="/login" method="post">
                    @csrf
                    @method('POST')
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-block">Sign In</button>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    @include('layouts.script')
</body>

</html>