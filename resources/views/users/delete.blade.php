@section('title','Borrar Usuarios')
@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Borrar Usuarios</h1>  
            <div class="separator mb-5"></div>
        </div>
    </div>

    <div class="row"> 
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">¿Estas seguro que quiere eliminar este usuario?</h5>

                    <div class="alert alert-danger  fade show  mb-4" role="alert"> 
            
                      <div class="table table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Rol</th> 
                                </tr>
                            </thead>
                            <tbody>  
                                <tr>
                                    <th scope="row">{{ $users->id }}</th>
                                    <td>{{ $users->name }}</td>
                                    <td>{{ $users->email }}</td>
                                    <td>{{ $users->rol }}</td>
                                </tr> 
                            </tbody>
                        </table>
                        <br>
                        <form action="{{ route('users.destroy', $users->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('users')}}" class="btn btn-secondary">Atras</a>
                            <button class="btn btn-danger">Borrar</button>
                        </form>
                    </div>
                     
                </div>
            </div>
        </div>
    </div>

</div>
@endsection