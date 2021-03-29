<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregar Tarea a Proyecto: {{$proyecto[0]->Nombre}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('tarea.storeTarea',$proyecto[0]->id) }}" method="POST" autocomplete="off">
            {{ csrf_field() }}
            <!-- tarea -->
            <div class="form-group">
              {{-- <label for="tarea" class="control-label col-sm-offset-1">Tarea</label> --}}
              <input type="text" name="nombre" id="nombre" class="form-control " value="{{ old('nombre') }}" placeholder="Nueva Tarea">
              @if($errors->has("nombre"))
              <span class="help-block text-danger">{{ $errors->first("nombre") }}</span>
              @endif
            </div> <!-- tarea -->
            <!-- tarea -->
            <div class="form-group">
              {{-- <label for="tarea" class="control-label col-sm-offset-1">Tarea</label> --}}
              <input type="text" name="descripcion" id="descripcion" class="form-control " value="{{ old('descripcion') }}" placeholder="Descripcion De La Tarea">
              @if($errors->has("descripcion"))
              <span class="help-block text-danger">{{ $errors->first("descripcion") }}</span>
              @endif
            </div> <!-- tarea -->
            <div class="form-group">
               {{Auth::user()->roles[0]->name}}
               @if(Auth::user()->roles[0]->name == "admin" || Auth::user()->roles[0]->name == "manager")
                 <select  class="selectpicker form-control" name="user_asigned_to" id="user_asigned_to"  data-live-search="true" data-container="body" required>
                   <option select="selected" value="">Seleccionar Usuario </option>
                   </select>
                   @if($errors->has("user_asigned_to"))
                   <span class="help-block text-danger">{{ $errors->first("user_asigned_to") }}</span>
                   @endif
               @endif
            </div>
          
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button class="btn btn-info" type="submit"><i class="fa fa-btn fa-plus"></i> Guardar</button>
              {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
          </form> <!-- /form.nueva -->
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
			// console.log(datosUsuarios);
		$.each(JSON.parse(datosUsuarios), function (idx, obj) {
			$("#user_asigned_to").append('<option value="' + obj.id + '">' + obj.name + '</option>').selectpicker('refresh');
		});

  });
</script>