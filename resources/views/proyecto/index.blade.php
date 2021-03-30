@extends('layouts.admin')
@section('contenido')
<div class="page-header clearfix">
	<h1>
		 Proyectos
		 @if(Auth::user()->roles[0]->name == 'admin' || Auth::user()->roles[0]->name == 'manager')
			<a class="btn btn-success pull-right" href="{{ route('proyecto.create') }}"><i class="fa fa-btn fa-plus"></i> Agregar Nuevo</a>
		@endif
	</h1>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="search">
			<form action="/proyecto" method="GET" class="form-horizontal form-search" role="search" >
				<div class="form-group">
					{{-- <label for="buscar" class="control-label col-sm-offset-1">Proyecto</label> --}}
					<div class="input-group col-sm-offset-1 col-sm-10">
						<select name="TipoBusqueda" id="TipoBusqueda" class="form-control col-sm-2" onchange="TipoBusquedaFunc();">
							<option value="proyecto.nombre">Nombre</option>
							<option value="users.name">Responsable</option>
							<option value="Completo">Completo</option>
							<option value="Incompleto">Incompleto</option>
							<option value="Fecha">Fecha</option>
						</select>
						<div class="col-md-4" id="divBuscarFecha">
							
							<div class="form-group">
								<input type="date" id="dtpFechaDesde" name="FechaCreacionDesde" class="form-control">
								<input type="date" id="dtpFechaHasta" name="FechaCreacionHasta" class="form-control">
							</div>
							

						</div>

						<input type="text" name="buscar" id="buscar" class="form-control" value="" placeholder="Buscar Proyecto">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit"><i class="fa fa-btn fa-search"></i> Buscar</button>
						</span>
					</div>
				</div>
			</form>
		</div>
		@if($proyectos->count())
		<div class="list-group">
			@foreach($proyectos as $proyecto)
			@php
			if (count($tareas)>0) {
				$porciento=0;
				# code...
				// $tareitas = App\Http\Controllers\UserController::GetUsersTareaInfoByIdProyecto(1);
				$tareasRealizadas = 0;
				$TotalTareas = 0;
				foreach ($tareas as $tarea) {
					# code...
					if ($tarea->proyecto_id == $proyecto->id) {
						# code...
						$TotalTareas+=1;
						if ($tarea->estado == 1) {
							# code...
							$tareasRealizadas+=1;
						}
					}
				}
				//  $trabajo = (count($proyecto->tarea));
				if ($TotalTareas > 0) {
					# code...
					$porciento = ($tareasRealizadas/$TotalTareas)*100;
				}
				
			  }
			// if (count($proyecto->tarea)>0) {
			// 	# code...
			
			// 	 $trabajo = (count($proyecto->tarea));
			// 	 $tareasRealizadas = 0;
			// 	 foreach ($proyecto->tarea as $tcalc) {
			// 	   # code...
			// 	   if ($tcalc->estado == 1) {
			// 		 # code...
			// 		 $tareasRealizadas = $tareasRealizadas+1;
			// 	   }
				   
			// 	 }
			// 	 $porciento = ($tareasRealizadas/$trabajo)*100;
			//   }
			@endphp
				@method('GET')
				@csrf
				<a href="{{ route('proyecto.show', $proyecto->id) }}" class="list-group-item">
					<div class="row">
						<input type="text" class="knob" value="{{round($porciento,2)}}" data-width="70" data-height="70" data-fgColor="#3d9970" readonly disabled >
						<div class="col-md-10">
							<h4 class="list-group-item-heading text-info">{{$proyecto->Nombre}} <span class="badge text-warning">({{$TotalTareas}})</span></h4>
							<h4 class="list-group-item-heading text-dark">Responsable: <span class=" text-danger">{{$proyecto->Responsable}}<span></h4>
							<p class="list-group-item-text text-dark">{{$proyecto->Descripcion}}</p>
						</div>
					</div>
				</a>
				
			@endforeach
		</div>
		<div class="text-center">
		{{-- {!! $proyectos->render() !!} --}}
		</div>
		@else
		<h3 class="text-center alert alert-info">No Hay Proyectos!</h3>
		@endif
	</div>
</div>
@endsection
<!-- jQuery -->
<script src="{{asset('adminLTE/plugins/jquery/jquery.min.js')}}"></script>
<script>
	function TipoBusquedaFunc()
	{
		var now = new Date();
		var day = ("0" + now.getDate()).slice(-2);
		var month = ("0" + (now.getMonth() + 1)).slice(-2);
		var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
		$("#dtpFechaDesde").val(today);
		$("#dtpFechaHasta").val(today);
		var tipo = $("#TipoBusqueda").val();
		if (tipo == "Fecha") {
			$("#buscar").hide();
			$("#divBuscarFecha").show();
			// $("#dtpFechaDesde").show();
			// $("#dtpFechaHasta").show();
		}else{
			if (tipo == "Completo" || tipo == "Incompleto") {
				$("#buscar").hide();
				$("#divBuscarFecha").hide();
				// $("#dtpFechaDesde").hide();
				// $("#dtpFechaHasta").hide();
			}else{
				$("#buscar").show();
				$("#divBuscarFecha").hide();
				// $("#dtpFechaDesde").hide();
				// $("#dtpFechaHasta").hide();
			}
		}
	}
	$(document).ready(function(){
		TipoBusquedaFunc();
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