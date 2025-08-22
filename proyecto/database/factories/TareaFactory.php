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
        // Inicio aleatorio en últimos 30 días, hora entre 07:00 y 14:45 (min 0/15/30/45)
        $inicio = Carbon::now()
            ->subDays(random_int(0, 30))
            ->setTime(random_int(7, 14), [0,15,30,45][array_rand([0,1,2,3])]);

        // Duración entre 5 y 120 horas (regla 2)
        $horas = random_int(5, 120);
        $termino = $inicio->copy()->addHours($horas);

        return [
            'id_maquina'         => null,     // se asigna con state() al crear
            'id_produccion'      => null,
            'fecha_hora_inicio'  => $inicio,
            'fecha_hora_termino' => $termino, // regla 1
            'tiempo_empleado'    => null,     // lo calcula tu rutina
            'tiempo_produccion'  => null,     // idem (regla 3)
            'estado'             => 'PENDIENTE', // regla 4
        ];
    }

    // Atajo para setear la máquina al crear
    public function paraMaquina(int $maquinaId): self
    {
        return $this->state(fn () => ['id_maquina' => $maquinaId]);
    }
}