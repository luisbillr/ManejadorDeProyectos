<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProyectoFormRequest;
use App\Models\Proyecto;
use App\Models\Tarea;
use App\Http\Controllers\TareaController;
use DB;
class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $q=$request->has('buscar')?'%'.$request->buscar.'%':'%';
       
        // if(Auth::user()->roles[0]->name == "admin")
        // {
            $proyectos = Proyecto::with('tarea') //obtener los objetos relacionados
            // ->where('user_id',Auth::user()->id) //solo los proyectos del usuario autenticado
           ->Where('nombre','like',$q) //busca los que contengan en el titulo la palabra buscar
           ->orderBy('user_id', 'desc') //en orden descendente por id
           ->paginate(10); //genere la paginación
        // }
        // else{
        //     $proyectos = Proyecto::with('tarea') //obtener los objetos relacionados
        //     ->where('user_id',Auth::user()->id) //solo los proyectos del usuario autenticado
        //    ->Where('nombre','like',$q) //busca los que contengan en el titulo la palabra buscar
        //    ->orderBy('user_id', 'desc') //en orden descendente por id
        //    ->paginate(10); //genere la paginación
        // }

        return view('proyecto.index', compact('proyectos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('proyecto.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProyectoFormRequest $request)
    {
        //
        $proyecto = new Proyecto();
        $proyecto->nombre = $request->input("nombre");
        $proyecto->descripcion = $request->input("descripcion");
        if (Auth::user()->roles[0]->name == "admin")
        {
            $proyecto->user_id =  $request->user_asigned_to;
        }else{
            Auth::user()->proyectos()->save($proyecto);
        }
        return redirect()->route('proyecto.index')->with('message', 'Nuevo Proyecto Guardado!!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->roles[0]->name == "admin")
        {
            $proyecto = Proyecto::with('tarea') 
            // ->where('user_id',Auth::user()->id) //solo los proyectos del usuario autenticado
           ->Where('id','=',$id) 
           ->orderBy('user_id', 'desc') 
           ->paginate(10); 
        }else{
            $proyecto = Proyecto::with('tarea') 
            ->where('user_id',Auth::user()->id) 
           ->Where('id','=',$id) 
           ->orderBy('user_id', 'desc') 
           ->paginate(10); 
        }
         return view('tarea.show', compact('proyecto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        // $proyecto = Proyecto::findOrFail($id);
  
        return view('proyecto.edit', compact('proyecto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $proyecto = Proyecto::findOrFail($id);
        $proyecto->titulo = $request->input("titulo");
        $proyecto->descripcion = $request->input("descripcion");
    
        $proyecto->save();
    
        return redirect()->route('proyecto.index')->with('message', 'Proyecto Actualizado!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    //     $proyecto = Proyecto::findOrFail($id);
    //     $proyecto->delete();
    
    //     return redirect()->route('proyecto.index')->with('message', 'Proyecto Eliminado!!!');
    // }

    public function GetUsuariosForProyecto(Request $request)
    {
        $users = DB::table("users")
        ->join('role_user','users.id','=','role_user.user_id')
         ->join('roles','role_user.role_id','=','roles.id')
        ->where('roles.name','=','manager')
        ->select('users.*')
        ->get();
        return response()->json(
            $users->toArray()
        );
    }
    public function GetUsuariosForTareas(Request $request)
    {
        $users = DB::table("users")
        ->join('role_user','users.id','=','role_user.user_id')
        ->join('roles','role_user.role_id','=','roles.id')
        ->where('roles.name','=','empleado')
        ->select('users.*')
        ->get();
        return response()->json(
            $users->toArray()
        );
    }
}
