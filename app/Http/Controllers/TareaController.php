<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\TareaFormRequest;
use App\Http\Controllers\Controller;
//use App\Requests\ClienteFormRequest;
use App\Models\Proyecto;
use App\Models\Tarea;
// use App\Models\Tarea;
use App\Http\Controllers\TareaController;
use DB;
class TareaController extends Controller
{
    public function show($id)
    {
        if(Auth::user()->roles[0]->name == "admin")
        {
            $proyecto = Proyecto::with('tarea') //obtener los objetos relacionados
            // ->where('user_id',Auth::user()->id) //solo los proyectos del usuario autenticado
           ->Where('id','=',$id) //busca los que contengan en el titulo la palabra buscar
           ->orderBy('user_id', 'desc') //en orden descendente por id
           ->paginate(10); //genere la paginación
        }else{
            $proyecto = Proyecto::with('tarea') //obtener los objetos relacionados
            ->where('user_id',Auth::user()->id) //solo los proyectos del usuario autenticado
           ->Where('id','=',$id) //busca los que contengan en el titulo la palabra buscar
           ->orderBy('user_id', 'desc') //en orden descendente por id
           ->paginate(10); //genere la paginación
        }
        //     $proyecto = Proyecto::with('tarea') //obtener los objetos relacionados
        //     ->where('user_id',Auth::user()->id) //solo los proyectos del usuario autenticado
        //    ->Where('id','=',$id) //busca los que contengan en el titulo la palabra buscar
        //    ->orderBy('user_id', 'desc') //en orden descendente por id
        //    ->paginate(10); //genere la paginación
        // return response (compact('proyecto'));
        // return response($proyecto);
         return view('tarea.show', compact('proyecto'));
    }
    
    // public function store(Request $request,$id)
    // {
    //     $proyecto = Proyecto::findOrFail($id);
    //     $tarea = new Tarea();
    //     $tarea->user_asigned_by = $request->user()->id;
    //     $tarea->user_asigned_to = $request->user_asigned_to;
    //     $tarea->nombre = $request->input("nombre");
    //     // $tarea->completo = false;

    //     $tarea->descripcion = "descripcion nueva";
    //     $proyecto->tarea()->save($tarea);
    //     return redirect()->route('tarea.show',$id)->with('message', 'Nueva Tarea Guardada!!!');
    // }
      /**
     * Agrega una nueva Tarea al Proyecto
    *
    * @param  int  $id
    * @return Response
    */
    public function storeTarea(TareaFormRequest $request,$id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $tarea = new Tarea();
        $tarea->user_asigned_by = $request->user()->id;
        $tarea->user_asigned_to = $request->user_asigned_to;
        $tarea->nombre = $request->input("nombre");
        // $tarea->completo = false;
        $tarea->descripcion = $request->input('descripcion');
        $proyecto->tarea()->save($tarea);
        return redirect()->route('tarea.show',$id)->with('message', 'Nueva Tarea Guardada!!!');
    }
    /**
    * Elimina una Tarea
    *
    * @param  int  $id
    * @return Response
    */
    public function destroyTarea($id,$idTarea)
    {
        $tarea=Tarea::findOrFail($idTarea);
        $tarea->delete();
        return redirect()->route('proyecto.show',$id)->with('message', 'Tarea Eliminada!!!');
    }
    /**
     * actualiza una Tarea
    *
    * @param  int  $id
    * @return Response
    */
    public function updateTarea(Request $request,$id,$idTarea)
    {
        $tarea=Tarea::findOrFail($idTarea);
        $tarea->estado=$request->input('estado');
        $tarea->save();
        // return response($idTarea);
        return redirect()->route('tarea.show',$id)->with('message', 'Tarea Actualizada!!!');
    }
}
