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
@endsection