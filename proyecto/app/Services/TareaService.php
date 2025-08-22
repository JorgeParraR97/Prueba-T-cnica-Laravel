<?php

namespace App\Services;

use App\Models\Tarea;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class TareaService
{

    public function calcularYCompletar(Tarea $tarea): Tarea
    {
        if (!$tarea->fecha_hora_inicio || !$tarea->fecha_hora_termino) {
            throw ValidationException::withMessages([
                'tarea' => 'La tarea requiere fecha_hora_inicio y fecha_hora_termino.',
            ]);
        }

        if ($tarea->tiempo_empleado === null) {
            $inicio  = Carbon::parse($tarea->fecha_hora_inicio);
            $termino = Carbon::parse($tarea->fecha_hora_termino);
            $min     = $inicio->diffInMinutes($termino);
            $tarea->tiempo_empleado = round($min / 60, 2);
        }


        if ($tarea->tiempo_empleado < 5 || $tarea->tiempo_empleado > 120) {
            throw ValidationException::withMessages([
                'tiempo_empleado' => 'El tiempo_empleado debe estar entre 5 y 120 horas.',
            ]);
        }

        $coef = (float) $tarea->maquina->coeficiente;
        dump('tiempo_empleado:', $tarea->tiempo_empleado, 'coeficiente:', $coef);
        $tarea->tiempo_produccion = round(((float)$tarea->tiempo_empleado) * $coef, 2);

        $tarea->estado = 'COMPLETADA';

        $tarea->save();

        return $tarea;
    }
}
