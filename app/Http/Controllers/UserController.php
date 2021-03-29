<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = DB::table("users")
        ->join('role_user','users.id','=','role_user.user_id')
        ->join('roles','role_user.role_id','=','roles.id')
        // -join('proyecto','users.id','=',)
        // ->where('roles.name','=','empleado')
        ->select('users.*','roles.name as Rol')
        ->get();
        return view('user.index', compact('users'));
        // return response()->json(
        //     $users->toArray()
        // );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = DB::table("users")
        ->join('role_user','users.id','=','role_user.user_id')
        ->join('roles','role_user.role_id','=','roles.id')
        // ->join('proyecto','users.id','=','')
        ->where('users.id','=',$id)
        ->select('users.*','roles.name as Rol')
        ->get()
        ->first();
        // return view('user.index', compact('user'));
        return view('user.show',compact('user'));
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function GetUsersProyectosInfo(Request $request)
    {
        if($request->UserRole == 'admin'||$request->UserRole == 'manager')
        {
            $users = DB::table("proyecto")
            ->join('users','users.id','=','proyecto.user_id')
            ->join('tarea','proyecto.id','=','tarea.proyecto_id')
            ->where('users.id','=',$request->UserId)
            // ->select('proyecto.id as ProyectoId','proyecto.nombre as Proyecto','tarea.estado')
            ->select('proyecto.id as ProyectoId','proyecto.nombre as Proyecto',DB::raw('count(tarea.id) as TotalTareas'),
            DB::raw('sum(tarea.estado) as TareasCompletadas'))
            ->groupBy('proyecto.id')
            ->get();
        }else{
            $users = DB::table("proyecto")
            ->join('users','users.id','=','proyecto.user_id')
            ->join('tarea','proyecto.id','=','tarea.proyecto_id')
            ->where('tarea.user_asigned_to','=',$request->UserId)
            ->select('proyecto.id as ProyectoId','proyecto.nombre as Proyecto',DB::raw('count(tarea.id) as TotalTareas'),
            DB::raw('sum(tarea.estado) as TareasCompletadas'))
            ->groupBy('proyecto.id')
            ->get();
        }
        return response()->json(
            $users->toArray()
        );
    }
    public function GetUsersTareaInfoByIdProyecto(Request $request)
    {
        $tareas = DB::table("tarea")
        ->where('tarea.proyecto_id','=',$request->IdProyecto)
        ->select('tarea.*')
        ->get();
            // $users = DB::table("proyecto")
            // ->join('users','users.id','=','proyecto.user_id')
            // ->join('tarea','proyecto.id','=','tarea.proyecto_id')
            // ->where('proyecto.id','=',$request->IdProyecto)
            // // ->select('proyecto.id as ProyectoId','proyecto.nombre as Proyecto','tarea.estado')
            // ->select('proyecto.id as ProyectoId','proyecto.nombre as Proyecto',DB::raw('count(tarea.id) as TotalTareas'),
            // DB::raw('count(tarea.estado) as TareasCompletadas'))
            // ->groupBy('proyecto.id')
            // ->get();
        return response()->json(
            $tareas->toArray()
        );
    }
    public function GetUsersListOnTareasByIdProyecto(Request $request)
    {
        $users = DB::table("tarea")
        ->join('users','users.id','=','tarea.user_asigned_to')
        ->where('tarea.proyecto_id','=',$request->IdProyecto)
        ->select('users.*')
        ->groupBy('users.id')
        ->get();
            // $users = DB::table("proyecto")
            // ->join('users','users.id','=','proyecto.user_id')
            // ->join('tarea','proyecto.id','=','tarea.proyecto_id')
            // ->where('proyecto.id','=',$request->IdProyecto)
            // // ->select('proyecto.id as ProyectoId','proyecto.nombre as Proyecto','tarea.estado')
            // ->select('proyecto.id as ProyectoId','proyecto.nombre as Proyecto',DB::raw('count(tarea.id) as TotalTareas'),
            // DB::raw('count(tarea.estado) as TareasCompletadas'))
            // ->groupBy('proyecto.id')
            // ->get();
        return response()->json(
            $users->toArray()
        );
    }
}
