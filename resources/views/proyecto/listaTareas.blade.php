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
            <button class="btn btn-success" type="submit"><i class="fa fa-btn fa-plus"></i> Guardar</button>
            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
          </div>
        </form> <!-- /form.nueva -->
      </div>

    </div>
  </div>
</div>
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
            </thead>
            <tbody>
              @foreach ($proyecto[0]->tarea as $t)
              <tr>
               
                <td class="table-text">
                  @if(Auth::User()->id == $t->user_asigned_by || Auth::User()->id == $t->user_asigned_to  )
                    <form class="modificar" action="{{route('tarea.updateTarea',[$proyecto[0]->id,$t->id])}}" method="POST">
                      {{ csrf_field() }}
                      {{ method_field('PUT') }}
                      <div class="checkbox">
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
                      </div>
                    </form><!-- /form.modificar -->
                  @else
                    X
                  @endif
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