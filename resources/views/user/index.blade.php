@extends('layouts.admin')
@section('contenido')
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