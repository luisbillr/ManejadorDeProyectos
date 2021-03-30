@include('tarea.create_modal')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Listado De Tareas</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          @if (count($proyecto[0]->tarea)>0)
          <table class="table table-striped table-hover">
            <thead>
              <th>Estado</td>
              <th>Nombre</th>
              <th>Descripcion</th>
              <th>Asignado a</th>
            </thead>
            <tbody>
              @foreach ($proyecto[0]->tarea as $t)
              <tr>
               
                <td class="table-text">
                  @if(Auth::User()->id == $t->user_asigned_by || Auth::User()->id == $t->user_asigned_to  )
                    <form class="modificar" action="{{route('tarea.updateTarea',[$proyecto[0]->id,$t->id])}}" method="POST">
                      {{ csrf_field() }}
                      {{ method_field('PUT') }}
                      {{-- <input type="hidden" id="EstadoValor" value=""> --}}
                      <div class="col-md-10">
                        <select name="estado" id="estado" onchange="this.form.submit();" class="form-control">
                          <option value="0" {{($t->estado==0)?'selected="selected"':''}}>Ninguno</option>
                          <option value="1" {{($t->estado==1)?'selected="selected"':''}}>Completada</option>
                          <option value="2" {{($t->estado==2)?'selected="selected"':''}}>Empezado</option>
                        </select>
                      </div>
                     
                      {{-- <div class="checkbox">
                        <label>
                          <input
                          type="checkbox"
                          {{($t->estado==1)?'checked="checked"':''}}
                          name="estado"
                          value="1"
                          onclick="$(this).parent().parent().parent().submit()"
                          >
                          {{($t->estado==1)?'Completada':'En Proceso'}}
                          {{-- {{ $t->Nombre }} --}}
                        </label>
                      <!--</div>-->
                    </form><!-- /form.modificar -->
                  @else
                    <b class="text-danger">X</b>
                  @endif
                </td>
                <td>{{$t->Nombre}}</td>
                <td>{{$t->Descripcion}}</td>
                @foreach ($participantes as $participante)
                  @if($t->user_asigned_to == $participante->id)           
                    <td>{{$participante->name}}</td>
                  @endif
                @endforeach

                <!-- eliminar -->
                <td>
                  @if(Auth::User()->id == $t->user_asigned_by || Auth::User()->id == $t->user_asigned_to && Auth::User()->roles[0]->name == "manager")
                  <form class="eliminar" action="{{route('tarea.destroyTarea',[$proyecto[0]->id,$t->id])}}" method="POST" onsubmit="return confirm('Está seguro de eliminar Tarea?')">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" id="delete-task-{{ $t->id }}" class="btn btn-danger pull-right" title="Eliminar Tarea">
                      <i class="fa fa-trash"></i>
                    </button>
                  </form><!-- /form.eliminar -->
                </td>
                @endif
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
// function myFunction(s) {
//   $(s).parent().parent().parent().submit()
//   // var x = document.getElementById("estado").value;
//    console.log(s);
// }
	$(document).ready(function(){
		// $('.selectpicker').selectpicker();
		// var urldatos = "http://127.0.0.1:8000/usersfortareas";
		// 	var datosUsuarios = $.ajax({
		// 		url: urldatos,
		// 		async: false
		// }).responseText;
		// 	// console.log(datosUsuarios);
		// $.each(JSON.parse(datosUsuarios), function (idx, obj) {
		// 	$("#user_asigned_to").append('<option value="' + obj.id + '">' + obj.name + '</option>').selectpicker('refresh');
		// });

  });
</script>