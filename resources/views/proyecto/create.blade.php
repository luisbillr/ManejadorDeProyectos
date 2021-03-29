@extends('layouts.admin')
@section('contenido')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="page-header">
	<h1><i class="fa fa-plus"></i> Proyectos / Nuevo </h1>
</div>
{{-- @include('common.error') --}}
<div class="row">
	<div class="col-md-12">
		<form action="{{ route('proyecto.store') }}" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<div class="form-group @if($errors->has('nombre')) has-error @endif">
				<label for="nombre-field">Nombre</label>
				<input type="text" id="nombre-field" name="nombre" class="form-control" value="{{ old("nombre") }}"/>
				@if($errors->has("nombre"))
				<span class="help-block text-danger">{{ $errors->first("nombre") }}</span>
				@endif
			</div>
			<div class="form-group @if($errors->has('descripcion')) has-error @endif">
				<label for="descripcion-field">Descripcion</label>
				<textarea class="form-control" id="descripcion-field" rows="3" name="descripcion">{{ old("descripcion") }}</textarea>
				@if($errors->has("descripcion"))
				<span class="help-block text-danger">{{ $errors->first("descripcion") }}</span>
				@endif
			</div>
			{{-- {{Auth::user()->roles[0]->name}} --}}
			@if(Auth::user()->roles[0]->name == "admin")
			<div class="col-md-6">
				<select class="selectpicker form-control" id="cbresponsable" name="user_asigned_to" data-live-search="true" data-container="body">
					<option select="selected">Select Location </option>
				
			  	</select>
			</div>
			@endif
			<div class="well well-sm">
				<button type="submit" class="btn btn-primary">Crear</button>
				<a class="btn btn-info" href="{{ route('proyecto.index') }}"><i class="fa fa-backward"></i> Atras</a>
			</div>
		</form>

	</div>
</div>
<!-- jQuery -->
<script src="{{asset('adminLTE/plugins/jquery/jquery.min.js')}}"></script>
<script>

	$(document).ready(function(){
		$('.selectpicker').selectpicker();
		var urldatos = "http://127.0.0.1:8000/usersforproyecto";
			var datosUsuarios = $.ajax({
				url: urldatos,
				async: false
		}).responseText;
			console.log(datosUsuarios);
		$.each(JSON.parse(datosUsuarios), function (idx, obj) {
			$("#cbresponsable").append('<option value="' + obj.id + '">' + obj.name + '</option>').selectpicker('refresh');
		});
	});
</script>
@endsection
