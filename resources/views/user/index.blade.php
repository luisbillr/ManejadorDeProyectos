@extends('layouts.admin')
@section('contenido')
<div class="page-header clearfix">
	<h1>
		 Usuarios
         @if(Auth::user()->roles[0]->name == 'admin' || Auth::user()->roles[0]->name == 'manager')
		    <a class="btn btn-success pull-right" href="{{ route('register') }}"><i class="fa fa-btn fa-plus"></i> Agregar Nuevo</a>
        @endif
	</h1>
</div>
<div class="row">
    <div class="col-md-12">
        <form action="/user" method="GET" class="form-horizontal form-search" role="search" >
            <div class="form-group">
                {{-- <label for="buscar" class="control-label col-sm-offset-1">Proyecto</label> --}}
                <div class="input-group col-sm-offset-1 col-sm-10">
                    <select name="TipoBusqueda" id="TipoBusqueda" class="form-control col-sm-2">
                        <option value="users.name">Nombre</option>
                        <option value="users.email">Correo</option>
                        <option value="roles.name">Rol</option>
                    </select>
                    <input type="text" name="buscar" id="buscar" class="form-control" value="" placeholder="Buscar Usuario">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="fa fa-btn fa-search"></i>buscar</button>
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <table class="table table-hover ">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->Rol}}</td>
                <td>
                    <a href="{{ route('user.show', $user->id) }}" class="btn btn-info">Info</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection