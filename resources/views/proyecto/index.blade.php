@extends('layouts.admin')
@section('contenido')
<div class="page-header clearfix">
	<h1>
		 Proyectos
		<a class="btn btn-success pull-right" href="{{ route('proyecto.create') }}"><i class="fa fa-btn fa-plus"></i>Nuevo</a>
	</h1>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="search">
			<form action="/proyectos" method="GET" class="form-horizontal">
				<div class="form-group">
					<label for="buscar" class="control-label col-sm-offset-1">Proyecto</label>
					<div class="input-group col-sm-offset-1 col-sm-10">
						<input type="text" name="buscar" id="buscar" class="form-control" value="{{ request()->buscar }}" placeholder="buscar Proyecto">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit"><i class="fa fa-btn fa-search"></i>buscar</button>
						</span>
					</div>
				</div>
			</form>
		</div>
		@if($proyectos->count())
		<div class="list-group">
			@foreach($proyectos as $proyecto)

				@method('GET')
				@csrf
			
				<a href="{{ route('proyecto.show', $proyecto->id) }}" class="list-group-item">
					<h4 class="list-group-item-heading">{{$proyecto->Nombre}} <span class="badge">{{$proyecto->tarea->count()}}</span></h4>
					<p class="list-group-item-text">{{$proyecto->Descripcion}}</p>
				</a>
			@endforeach
		</div>
		<div class="text-center">
		{!! $proyectos->render() !!}
		</div>
		@else
		<h3 class="text-center alert alert-info">No Hay Proyectos!</h3>
		@endif
	</div>
</div>
@endsection