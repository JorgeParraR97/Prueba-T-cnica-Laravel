<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('produccion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('maquina_id');
            $table->decimal('tiempo_produccion', 6, 2);  
            $table->decimal('tiempo_inactividad', 6, 2);  
            $table->dateTime('fecha_hora_inicio_inactividad')->nullable();
            $table->dateTime('fecha_hora_termino_inactividad')->nullable();
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('produccion');
    
    }
};
