<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="{{ asset('font/iconsmind-s/css/iconsminds.css') }}" />
    <link rel="stylesheet" href="{{ asset('font/simple-line-icons/css/simple-line-icons.css') }}" />

    <link rel="stylesheet" href="{{ asset('css/vendor/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/vendor/bootstrap.rtl.only.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/vendor/bootstrap-float-label.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dore.light.bluenavy.min.css') }}" />
</head>

<body class="background show-spinner no-footer">
    <div class="fixed-background"></div>
    <main>
        <div class="container">
            <div class="row h-100">
                <div class="col-12 col-md-10 mx-auto my-auto">
                    <div class="card auth-card">
                        <div class="position-relative image-side ">

                            <p class=" text-white h2">Sistema de archivos</p>

                            <p class="white mb-0">
                                Utilice sus credenciales para iniciar sesión.
                                <br>Si no es miembro, por favor
                                <h5><a href="{{ url('auth/register') }}" class="btn btn-secondary btn-lg btn-shadow">Registrate</a>.</h5> 
                            </p>
                        </div>
                        <div class="form-side">
                            <a href="javascript:void(0)">
                                <span class="logo-single" style="margin-bottom: 30px !important;"></span>
                            </a>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show rounded mb-4" role="alert">
                                    <strong>Hey !</strong> {{ session('success') }}.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @error("invalid_credentials")
                                <div class="alert alert-warning alert-dismissible fade show rounded mb-4" role="alert">
                                    <strong>Hey !</strong> {{ $message }}.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror

                            <h6 class="mb-4">Acceso</h6>
                            <form action="" method="POST">
                                @csrf
                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" value="{{ old('email') }}" type="email" name="email"  required/>
                                    @error("email")
                                        <small class="text-danger mt-1">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                    <span>E-mail</span>
                                </label>

                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" type="password" name="password" placeholder=""  required/>
                                    @error("password")
                                        <small class="text-danger mt-1">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                    <span>Password</span>
                                </label>
 

                                <div class="d-flex justify-content-between align-items-center">
                                    {{-- <a href="#">¿Contraseña olvidada?</a> --}}
                                    <button class="btn btn-primary btn-lg btn-shadow" type="submit">Iniciar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="{{ asset('js/vendor/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/dore.script.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>

</html>