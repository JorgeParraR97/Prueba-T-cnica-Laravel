<?php

namespace Database\Factories;

use App\Models\Tarea;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class TareaFactory extends Factory
{
    protected $model = Tarea::class;

    public function definition(): array
    {
        
        $inicio = Carbon::now()
            ->subDays(random_int(0, 30))
            ->setTime(random_int(7, 14), [0,15,30,45][array_rand([0,1,2,3])]);

        
        $horas = random_int(5, 120);
        $termino = $inicio->copy()->addHours($horas);

        return [
            'id_maquina'         => null,     
            'id_produccion'      => null,
            'fecha_hora_inicio'  => $inicio,
            'fecha_hora_termino' => $termino, 
            'tiempo_empleado'    => null,     
            'tiempo_produccion'  => null,     
            'estado'             => 'PENDIENTE', 
        ];
    }

   
    public function paraMaquina(int $maquinaId): self
    {
        return $this->state(fn () => ['id_maquina' => $maquinaId]);
    }
}