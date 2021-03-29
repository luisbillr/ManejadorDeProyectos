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
	<div class="card card-olive">
		<div class="card-header">
			<h3 class="card-title">Informacion Del Proyecto</h3>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-12">
					<h2>Nombre Del Proyecto: {{$proyecto[0]->Nombre}}<!-- Button trigger modal -->
						@if(Auth::user()->roles[0]->name == "admin" || Auth::user()->roles[0]->name == "manager")
								<button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
								Agregar Tarea
								</button>
						
						@endif
					</h2>
					{{-- <form action="{{ route('proyectos.destroy', $proyecto->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Estas seguro de Eliminar?')) { return true } else {return false };">
						<input type="hidden" name="_method" value="DELETE">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="btn-group pull-right" role="group" aria-label="...">
							<a class="btn btn-warning btn-group" role="group" href="{{ route('proyectos.edit', $proyecto->id) }}" title="Editar Proyecto"><i class="fa fa-edit"></i></a>
							<button type="submit" class="btn btn-danger" title="Eliminar Proyecto"><i class="fa fa-trash"></i></button>
						</div>
					</form> --}}
					
						<div class="form-group">
							{{-- <label for="descripcion">DESCRIPCION</label> --}}
							<p class="form-control-static"><b>Descripcion:</b> {{$proyecto[0]->Descripcion}}</p>
						</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="card card-olive">
					  <div class="card-header">
						<h3 class="card-title">Progreso Del Proyecto</h3>
					  </div>
					  <div class="card-body">
						<div class="text-center">
						  @php
						  $porciento=0;
						  if (count($proyecto[0]->tarea)>0) {
							  # code...
						  
							   $trabajo = (count($proyecto[0]->tarea));
							   $tareasRealizadas = 0;
							   foreach ($proyecto[0]->tarea as $tcalc) {
								 # code...
								 if ($tcalc->estado == 1) {
								   # code...
								   $tareasRealizadas = $tareasRealizadas+1;
								 }
								 
							   }
							   $porciento = ($tareasRealizadas/$trabajo)*100;
							}
						  @endphp
						
						  <input type="text" class="knob" value="{{round($porciento,2)}}" data-width="160" data-height="160" data-fgColor="#3d9970" readonly disabled >
		  
						  {{-- <div class="knob-label">New Visitors</div> --}}
						</div>
					  </div>
					</div>
				  </div>
			</div>
			
		</div>

	</div>
</div>
<div class="row">
	@include('proyecto.listaTareas', ['tareas' => $proyecto[0]->tarea])
</div>

<div class="row">
	<a class="btn btn-default" href="{{ route('proyecto.index') }}"><i class="fa fa-btn fa-backward"></i> Volver</a>
</div>
@endsection