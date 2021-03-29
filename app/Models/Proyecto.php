<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tarea;
use App\Http\Controllers\TareaController;
class Proyecto extends Model
{
        protected $table = 'Proyecto';
    //use HasFactory;
    //relacion pertenece a un User

    public function user()
    {
            return $this->belongsTo(User::class);
    }
    //relacion tiene muchas Tarea
    public function tarea()
    {
            return $this->hasMany(Tarea::class);
    }

}
