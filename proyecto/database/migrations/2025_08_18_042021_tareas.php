<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_maquina');
            $table->unsignedBigInteger('id_produccion')->nullable(); 
            $table->dateTime('fecha_hora_inicio');
            $table->dateTime('fecha_hora_termino');
            $table->decimal('tiempo_empleado', 4, 2);
            $table->decimal('tiempo_produccion', 4, 2);
            $table->enum('estado', ['PENDIENTE','COMPLETADA'])->default('PENDIENTE');
            $table->timestamps();

            $table->foreign('id_produccion')->references('id')->on('produccion')->onDelete('set null');

        
        });


          
    }

    
    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
