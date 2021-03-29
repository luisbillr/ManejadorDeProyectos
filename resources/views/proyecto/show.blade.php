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
				<div class="col-md-8">
					<div class="row">
						<input type="hidden" id="txtIdProyecto" value="{{$proyecto[0]->id}}">
						<input type="hidden" id="txtResponsable" value="{{$proyecto[0]->user_id}}">
						<div class="form-group">
							<h4><b>Proyecto:</b> {{$proyecto[0]->Nombre}}<!-- Button trigger modal -->
								@if(Auth::user()->roles[0]->name == "admin" || Auth::user()->roles[0]->name == "manager")
										<button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
										Agregar Tarea
										</button>
								@endif
							</h4>
							<h5><b>Descripcion:</b> {{$proyecto[0]->Descripcion}}</h5>
						</div>
						{{-- <form action="{{ route('proyectos.destroy', $proyecto->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Estas seguro de Eliminar?')) { return true } else {return false };">
							<input type="hidden" name="_method" value="DELETE">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="btn-group pull-right" role="group" aria-label="...">
								<a class="btn btn-warning btn-group" role="group" href="{{ route('proyectos.edit', $proyecto->id) }}" title="Editar Proyecto"><i class="fa fa-edit"></i></a>
								<button type="submit" class="btn btn-danger" title="Eliminar Proyecto"><i class="fa fa-trash"></i></button>
							</div>
						</form> --}}
						

					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card card-olive">
								<div class="card-header">
									<h3 class="card-title">Participantes</h3>
								</div>
								<div class="card-body">
									<div class="row">
										<h3>Responsable: <span class="text-danger">{{$proyecto[0]->user->name}}</span></h3>
									</div>
									
									<hr>
									<table class="table table-hover" id="tblUsuarios">
										<thead>
											<tr>
												<th>Nombre</th>
												<th>Correo</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

				</div>
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-12">
							<div class="card card-olive">
							  <div class="card-header">
								<h3 class="card-title">Progreso Del Proyecto</h3>
							  </div>
							  <div class="card-body">
								  <div class="row">
									<div class="col-md-12 text-center">
										<canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
										<b>Grafica De Donas</b>
									</div>
									
								  </div>
								  <hr>
								
								  <div class="row">
									<div class="col-md-12 text-center">
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
										  <b>Porciento Completado | {{round($porciento,2)}}%</b>
										{{-- <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas> --}}
									</div>
								  </div>
		
							  </div>
							</div>
						  </div>
					</div>
				</div>
			</div>

			
		</div>

	</div>
</div>
<div class="row">
	@include('tarea.listaTareas', ['tareas' => $proyecto[0]->tarea])
</div>

<div class="row">
	<a class="btn btn-default" href="{{ route('proyecto.index') }}"><i class="fa fa-backward"></i> Atras</a>
</div>

<!-- jQuery -->
<script src="{{asset('adminLTE/plugins/jquery/jquery.min.js')}}"></script>
<script>
function GetDatosTarea(id)
{
	var datosTareas = $.ajax({
		url: "http://127.0.0.1:8000/GetUsersTareaInfoByIdProyecto",
		async: false,
		data:{
			'IdProyecto':id,
		},
	}).responseText;
	return datosTareas;
}
function GetUsuariosDelProyecto(id)
{
	var datosTareas = $.ajax({
		url: "http://127.0.0.1:8000/GetUsersListOnTareasByIdProyecto",
		async: false,
		data:{
			'IdProyecto':id,
		},
	}).responseText;
	datos = JSON.parse(datosTareas);
	datos.forEach(element => {
		$("#tblUsuarios > tbody ").append('<tr>'
		+'<td>'+ element.name +'<td/>'
		+'<td>'+ element.email +'<td/>'
		+ '</tr>');
	});
	return datosTareas;
}
$(document).ready(function(){
	var TareasCompletadas = 0;
	var TCPorciento = 0;
	var TareasEmpezadas = 0;
	var TEPorciento = 0;
	var TareasSinEstado = 0;
	var TSPorciento = 0;
	let idproyecto =  $("#txtIdProyecto").val();
	var listadeusuarios = JSON.parse(GetUsuariosDelProyecto(idproyecto));
	console.log(listadeusuarios);
	var listatareas = JSON.parse(GetDatosTarea(idproyecto));
		console.log(listatareas.length)
		listatareas.forEach(element => {
			if (element.estado == 1) {
				TareasCompletadas+=1;
			}else{
				if(element.estado == 2){
					TareasEmpezadas+=1;
				}else{
					TareasSinEstado +=1;
				}
			}
		});
	    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'Ninguno',
          'Completado',
          'Empezado',
      ],
      datasets: [
        {
          data: [TareasSinEstado,TareasCompletadas,TareasEmpezadas],
          backgroundColor : ['grey', '#00a65a', '#f39c12'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })


	    //Funciones de Charts
    $('.knob').knob({
      /*change : function (value) {
       //console.log("change : " + value);
       },
       release : function (value) {
       console.log("release : " + value);
       },
       cancel : function () {
       console.log("cancel : " + this.value);
       },*/
      draw: function () {

        // "tron" case
        if (this.$.data('skin') == 'tron') {

          var a   = this.angle(this.cv)  // Angle
            ,
              sa  = this.startAngle          // Previous start angle
            ,
              sat = this.startAngle         // Start angle
            ,
              ea                            // Previous end angle
            ,
              eat = sat + a                 // End angle
            ,
              r   = true

          this.g.lineWidth = this.lineWidth

          this.o.cursor
          && (sat = eat - 0.3)
          && (eat = eat + 0.3)

          if (this.o.displayPrevious) {
            ea = this.startAngle + this.angle(this.value)
            this.o.cursor
            && (sa = ea - 0.3)
            && (ea = ea + 0.3)
            this.g.beginPath()
            this.g.strokeStyle = this.previousColor
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false)
            this.g.stroke()
          }

          this.g.beginPath()
          this.g.strokeStyle = r ? this.o.fgColor : this.fgColor
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false)
          this.g.stroke()

          this.g.lineWidth = 2
          this.g.beginPath()
          this.g.strokeStyle = this.o.fgColor
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false)
          this.g.stroke()

          return false
        }
      }
    })
    /* END JQUERY KNOB */
	
});

</script>
@endsection