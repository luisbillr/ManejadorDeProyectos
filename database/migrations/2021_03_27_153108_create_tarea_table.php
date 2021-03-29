<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTareaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarea', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proyecto_id');
            $table->unsignedBigInteger('user_asigned_by');
            $table->unsignedBigInteger('user_asigned_to');
            $table->string('Nombre');
            $table->string('Descripcion');
            $table->foreign('user_asigned_by')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            $table->foreign('user_asigned_to')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            $table->foreign('proyecto_id')
            ->references('id')
            ->on('proyecto')
            ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarea');
    }
}
