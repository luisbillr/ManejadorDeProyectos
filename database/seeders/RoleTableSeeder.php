<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role = new Role();
        $role->name = 'admin';
        $role->description = 'Administrator';
        $role->save();
        $role = new Role();
        $role->name = 'user';
        $role->description = 'User';
        $role->save();
        $role = new Role();
        $role->name = 'manager';
        $role->description = 'Manager';
        $role->save();
        $role = new Role();
        $role->name = 'empleado';
        $role->description = 'Empleado';
        $role->save();
                // //creamos una instancia del servicio de faker para poder obtener valores aleatorios
                // $f = Factory::create();
                // //creamos 50 proyectos
                // for ($j=0; $j < 50 ; $j++) {
                //     $p1= new App\Models\Proyecto();
                //     $p1->titulo="proyecto $j :: ".$f->name;
                //     $p1->descripcion=$f->text;
                //     //asignamos el proyecto al usuario 1
                //     $u1->proyectos()->save($p1);
                //     //generamos entre 1 y 10 tareas para el proyecto
                //     for ($i=0; $i < $f->numberBetween(1,10) ; $i++) {
                //         $t=new App\Models\Tarea();
                //         $t->tarea="Tarea : ".$f->name;
                //         $p1->tareas()->save($t);
                //     } //for ($i=0; $i < 5 ; $i++)
                // } //for ($j=0; $j < 50 ; $j++)

    }
}
