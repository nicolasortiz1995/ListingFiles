<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


    <meta name="csrf-token" content="{{ csrf_token() }}">
    @csrf

    <!-- Icon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" sizes="192x192" href="{{ asset('favicon.ico') }}">
    

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('font/iconsmind-s/css/iconsminds.css') }}" />
    <link rel="stylesheet" href="{{ asset('font/simple-line-icons/css/simple-line-icons.css') }}" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/vendor/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/vendor/bootstrap.rtl.only.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/vendor/component-custom-switch.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/vendor/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/vendor/bootstrap-float-label.min.css') }}" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dore.light.bluenavy.min.css') }}" />

    <!-- Js -->
    <script src="{{ asset('js/sweetalert2.js') }}"></script>
    <script src="{{ asset('js/vendor/jquery-3.3.1.min.js') }}"></script>
    
</head>

<body id="app-container" class="menu-default show-spinner ltr rounded">
    <nav class="navbar fixed-top">
        <div class="d-flex align-items-center navbar-left">
            <a href="#" class="menu-button d-none d-md-block">
                <svg class="main" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 17">
                    <rect x="0.48" y="0.5" width="7" height="1" />
                    <rect x="0.48" y="7.5" width="7" height="1" />
                    <rect x="0.48" y="15.5" width="7" height="1" />
                </svg>
                <svg class="sub" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17">
                    <rect x="1.56" y="0.5" width="16" height="1" />
                    <rect x="1.56" y="7.5" width="16" height="1" />
                    <rect x="1.56" y="15.5" width="16" height="1" />
                </svg>
            </a>

            <a href="#" class="menu-button-mobile d-xs-block d-sm-block d-md-none">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 17">
                    <rect x="0.5" y="0.5" width="25" height="1" />
                    <rect x="0.5" y="7.5" width="25" height="1" />
                    <rect x="0.5" y="15.5" width="25" height="1" />
                </svg>
            </a> 
           
        </div>


        <a class="navbar-logo" href="#">
            <span class="logo-mobile d-none d-xs-block"></span>
            <span class="logo-mobile d-block d-xs-none"></span>
        </a>

        <div class="navbar-right"> 
            <div class="user d-inline-block">
                <button class="btn btn-empty p-0" type="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <span class="name">{{ auth()->user()->name }} </span>
                    <span>
                        <img alt="Profile Picture" src="{{ asset('img/profiles/manager.png') }}" />
                    </span>
                </button>

                <div class="dropdown-menu dropdown-menu-right mt-3"> 
                    <button type="button" class="dropdown-item" data-toggle="modal"
                    data-target="#ModalChangePassword" >Cambiar contraseña</button>

                    <form action="{{ route('signOut') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">Cerrar sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="menu">
        <div class="main-menu">
            <div class="scroll">
                <ul class="list-unstyled">
                    <li>
                        <a href="{{ route('dashboard') }}">
                            <i class="iconsminds-shop-4"></i>
                            <span>Dashboards</span>
                        </a>
                    </li>

                    @if(auth()->user()->rol != 'Consultor')
                    <li>
                        <a href="{{ route('users') }}">
                            <i class="iconsminds-user"></i> Usuarios
                        </a>
                    </li>
                    @endif

                </ul>
            </div>
        </div>  

    </div>

    <main>

        @yield('content')

    </main>

    <footer class="page-footer">
        <div class="footer-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <p class="mb-0 text-muted">Miguel Salazar Dev 2022</p>
                    </div> 
                </div>
            </div>
        </div>
    </footer>

     <!-- Modal -->
     <!-- Modal -->
     <div class="modal fade" id="ModalChangePassword" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar contraseña</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="javascript:formChangePassword()">
                    <div class="modal-body">  
                        <label class="form-group has-float-label mb-4">
                            <input class="form-control" type="password" name="password" placeholder=""  required/>
                            <span>Password</span>
                        </label> 

                        <label class="form-group has-float-label mb-4">
                            <input class="form-control" type="password" name="repeatPassword" placeholder=""  required/>
                            <small class="text-danger mt-1" style="display: none" id="repeatPassword">
                                las contraseña no son iguales <br>
                            </small>
                            <small class="text-danger mt-1" style="display: none" id="passwordLength">
                                las contraseña minimo deben mayor o igual a cuatro caracteres
                            </small>
                            <span>Repetir Contraseña</span>
                        </label>  
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"> Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    
    <script src="{{ asset('js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/vendor/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/vendor/mousetrap.min.js') }}"></script>
    <script src="{{ asset('js/dore.script.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    
</body>

</html>