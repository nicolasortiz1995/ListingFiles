<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registro</title>
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
                                Utilice este formulario para registrarse.
                                <br>Si es miembro, por favor
                                <h5><a href="{{ url('auth/login') }}" class="btn btn-secondary btn-lg btn-shadow">Inicia sesión</a>.</h5>
                            </p>
                        </div>
                        <div class="form-side">
                            <a href="javascript::void(0)">
                                <span class="logo-single"></span>
                            </a>
                            <h6 class="mb-4">Registro</h6>

                            <form action="" method="POST">
                                @csrf
                                <label class="has-float-label mb-4">
                                    <input class="form-control" value="{{ old('name') }}" type="text" name="name" required/>
                                    @error("name")
                                        <small class="text-danger mt-1">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                    <span>Nombre</span>
                                </label>
                                
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
                                

                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" type="password" name="repeatPassword" placeholder=""  required/>
                                    @error("repeatPassword")
                                        <small class="text-danger mt-1">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                    <span>Repetir Contraseña</span>
                                </label>

                                <div class="d-flex justify-content-end align-items-center">
                                    <button class="btn btn-primary btn-lg btn-shadow" type="submit">Registrarse</button>
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