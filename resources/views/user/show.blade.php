@extends('layouts.admin')
@section('contenido')

<div class="card card-olive">
    <div class="card-header">
        <h3 class="card-title">Informacion Del Usuario</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-olive">
                    <div class="card-header">
                        <h3 class="card-title">Informacion Personal</h3>
                    </div>
                    <div class="card-body">
                        <p>Nombre: {{$user->name}}</p>
                        <p>Correo: {{$user->email}}</p>
                        <p>Rol: {{$user->Rol}}</p>
                        <input type="hidden" id="txtUserRole" value="{{$user->Rol}}">
                        <input type="hidden" id="txtUserId" value="{{$user->id}}">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-olive">
                    <div class="card-header">
                        <h3 class="card-title">Informacion De Proyectos</h3>
                    </div>
                    <div class="card-body">
                        <div id="listaProyectos" class="list-group">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
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
    $(document).ready(function(){
        var userRole = $("#txtUserRole").val();
        var userId = $("#txtUserId").val();
        var Proyectoid = 0;
        var datosProyectos = $.ajax({
            url: "http://127.0.0.1:8000/GetUsersProyectosInfo",
            async: false,
            data:{
                'UserRole':userRole,
                'UserId': userId
            },
        }).responseText;
        $.each(JSON.parse(datosProyectos), function (idx, obj) {
            var listatareas = JSON.parse(GetDatosTarea(obj.ProyectoId));
            var porciento = 0;
            var TareasCompletadas = 0;
            console.log(obj);
            console.log(listatareas.length)
            listatareas.forEach(element => {
                if (element.estado == 1) {
                    TareasCompletadas+=1;
                }
            });
            porciento = (TareasCompletadas/listatareas.length)*100;

            $("#listaProyectos").append('<a href="' + "http://127.0.0.1:8000/proyecto/"+obj.ProyectoId + '">' 
                +'<div class="row">'
                    +'<input type="text" class="knob" value="'+Math.round(porciento)+'" data-width="70" data-height="70" data-fgColor="#3d9970" readonly disabled >'
                    +'<h6 class="list-group-item-heading text-info">'+ obj.Proyecto +'<span class="badge text-warning">('+listatareas.length+')</span></h6>'
                +'</div>'
            +'</a>');
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