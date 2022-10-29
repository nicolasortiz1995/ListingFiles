@section('title','Actualizar Usuarios')
@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Actualizar Usuarios</h1>  
            <div class="separator mb-5"></div>
        </div>
    </div>

    <div class="row"> 
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Editar un usuario</h5>

                    <form action="{{ route('users.update', $users->id)}}" method="POST">
                        @csrf
                        @method("PUT")
                        <label class="has-float-label mb-4">
                            <input class="form-control" value="{{ $users->name}}" type="text" name="name" required/>
                            @error("name")
                                <small class="text-danger mt-1">
                                    {{ $message }}
                                </small>
                            @enderror
                            <span>Nombre</span>
                        </label>
                        
                        <label class="form-group has-float-label mb-4">
                            <input class="form-control" value="{{ $users->email}}" type="email" name="email"  disabled required/>
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
                                <option {{ ($users->rol == "Consultor" ? "selected":"") }} value="Consultor">Consultor</option>
                                <option {{ ($users->rol == "Administrador" ? "selected":"") }} value="Administrador">Administrador</option>
                                <option {{ ($users->rol == "Super Administrador" ? "selected":"") }} value="Super Administrador">Super Administrador</option>
                            </select>
                        </label>
                        

                        <p class="list-item-heading mt-4 text-danger">Si no cambiará contraseña dejar vacío los campos.</p>

                        <label class="form-group has-float-label mb-4">
                            <input class="form-control" type="password" name="password" placeholder="" />
                            @error("password")
                                <small class="text-danger mt-1">
                                    {{ $message }}
                                </small>
                            @enderror
                            <span>Password</span>
                        </label>
                        

                        <label class="form-group has-float-label mb-4">
                            <input class="form-control" type="password" name="repeatPassword" placeholder=""  />
                            @error("repeatPassword")
                                <small class="text-danger mt-1">
                                    {{ $message }}
                                </small>
                            @enderror
                            <span>Repetir Contraseña</span>
                        </label>
                        
                        <a href="{{ route('users')}}" class="btn btn-secondary">Atras</a>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                          
                      </form>
                     
                </div>
            </div>
        </div>
    </div>

</div>
@endsection