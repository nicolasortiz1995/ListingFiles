@section('title','Crear Usuarios')
@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Crear Usuarios</h1>  
            <div class="separator mb-5"></div>
        </div>
    </div>

    <div class="row"> 
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Agregar un nuevo usuario</h5>

                    <form action="{{ route('users.store')}}" method="POST">
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
                            <span>Rol</span>
                            <select class="form-control" name="rol" data-width="100%" required>
                                <option {{ (old("rol") == "Consultor" ? "selected":"") }} value="Consultor">Consultor</option>
                                <option {{ (old("rol") == "Administrador" ? "selected":"") }} value="Administrador">Administrador</option>
                                <option {{ (old("rol") == "Super Administrador" ? "selected":"") }} value="Super Administrador">Super Administrador</option>
                            </select>
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
                        
                        <a href="{{ route('users')}}" class="btn btn-secondary">Atras</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                          
                      </form>
                     
                </div>
            </div>
        </div>
    </div>

</div>
@endsection