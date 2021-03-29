<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Listado De Tareas</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Crear Tarea</h3>
            </div>
            <div class="card-body">
              <form action="{{ route('proyecto.storeTarea',$proyecto[0]->id) }}" method="POST" >
                {{ csrf_field() }}
                <!-- tarea -->
                <div class="form-group">
                  {{-- <label for="tarea" class="control-label col-sm-offset-1">Tarea</label> --}}
                  <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('tarea') }}" placeholder="Nueva Tarea">
                  <span class="input-group-btn">
                    
                  </span>
                </div> <!-- tarea -->
                <div class="form-group">
                   {{-- {{Auth::user()->roles[0]->name}} --}}
                   @if(Auth::user()->roles[0]->name == "admin" || Auth::user()->roles[0]->name == "manager")
                   
                     <select class="selectpicker form-control" id="user_asigned_to" name='user_asigned_to' data-live-search="true" data-container="body">
                       <option select="selected">Seleccionar Usuario </option>
                       </select>
                   
                   @endif
                </div>
                <button class="btn btn-success" type="submit"><i class="fa fa-btn fa-plus"></i> Agregar</button>
              </form> <!-- /form.nueva -->
            </div>
          </div>
         
        </div>
      </div>
      <br/>
      <div class="row">
        <div class="col-md-12">
          @if (count($proyecto[0]->tarea)>0)
          <table class="table table-striped table-hover">
            <thead>
              <th></td>
              <th>Nombre</th>
              <th>Descripcion</th>
            </thead>
            <tbody>
              @foreach ($proyecto[0]->tarea as $t)
              {{$t}}
              <tr>
                <td class="table-text">
                  <form class="modificar" action="{{route('proyecto.updateTarea',[$proyecto[0]->id,$t->id])}}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="checkbox">
                      <label>
                        <input
                        type="checkbox"
                        {{($t->completo==1)?'checked="checked"':''}}
                        name="completo"
                        value="1"
                        onclick="$(this).parent().parent().parent().submit()"
                        >
                        {{ $t->tarea }}
                      </label>
                    </div>
                  </form><!-- /form.modificar -->
                </td>
                <td>{{$t->Nombre}}</td>
                <td>{{$t->Descripcion}}</td>
                <!-- eliminar -->
                <td>
                  {{-- <form class="eliminar" action="{{route('proyecto.destroyTarea',[$proyecto->id,$t->id])}}" method="POST" onsubmit="return confirm('Está seguro de eliminar Tarea?')">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" id="delete-task-{{ $t->id }}" class="btn btn-danger pull-right" title="Eliminar Tarea">
                      <i class="fa fa-trash"></i>
                    </button>
                  </form><!-- /form.eliminar --> --}}
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @else
          <h3>No Hay Tareas</h3>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
<!-- jQuery -->
<script src="{{asset('adminLTE/plugins/jquery/jquery.min.js')}}"></script>
<script>

	$(document).ready(function(){
		$('.selectpicker').selectpicker();
		var urldatos = "http://127.0.0.1:8000/usersfortareas";
			var datosUsuarios = $.ajax({
				url: urldatos,
				async: false
		}).responseText;
			console.log(datosUsuarios);
		$.each(JSON.parse(datosUsuarios), function (idx, obj) {
			$("#user_asigned_to").append('<option value="' + obj.id + '">' + obj.name + '</option>').selectpicker('refresh');
		});
	});
</script>