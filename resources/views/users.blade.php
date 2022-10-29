@section('title','Usuarios')
@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Usuarios</h1>
            <div class="text-zero top-right-button-container">
                <a href="{{ route('users.create')}}" class="btn btn-primary btn-lg top-right-button mr-1">Agregar</a>                 
            </div> 
            
            <div class="separator mb-5"></div>
        </div>
    </div>

    <div class="row"> 

        @if(session('success'))
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show rounded mb-4" role="alert">
                    <strong>Hey !</strong> {{ session('success') }}.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Listado</h5>

                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Email</th>
                                <th scope="col">Rol</th>
                                <th scope="col">Editar</th>
                                <th scope="col">Borrar</th>
                            </tr>
                        </thead>
                        <tbody> 
                            @foreach ($dato as $item)
                            <tr>
                                <th scope="row">{{ $item->id }}</th>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->rol }}</td>
                                
                                <td><a href="{{ route('users.edit', $item->id)}}" class="btn btn-primary"><i class="glyph-icon simple-icon-note"></i></a></td>
                                @if(auth()->user()->rol != $item->rol)
                                    <td><a href="{{ route('users.show', $item->id)}}" class="btn btn-danger"><i class="simple-icon-trash"></i></a></td>
                                @endif

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection