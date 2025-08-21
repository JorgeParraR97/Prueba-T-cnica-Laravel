<?php

namespace App\Services;

use App\Models\Maquina;
use App\Models\Produccion;
use App\Models\Tarea;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProduccionService
{
    public function __construct(
        private TareaService $tareaService,
        private InactividadService $inactividadService
    ) {}


    public function procesarCiclo(Maquina $maquina): ?Produccion
    {
        return DB::transaction(function () use ($maquina) {
           
            $tareas = Tarea::query()
                ->where('id_maquina', $maquina->id)
                ->where('estado', 'PENDIENTE')
                ->whereNull('id_produccion')
                ->orderBy('fecha_hora_termino') 
                ->lockForUpdate()
                ->limit(5)
                ->get();

            if ($tareas->count() < 5) {
                return null;
            }

            $sumaProd = 0.0;

            foreach ($tareas as $t) {
                $this->tareaService->calcularYCompletar($t);
                $sumaProd += (float)$t->tiempo_produccion;
            }

            $sumaProd = round($sumaProd, 2);

            $produccion = new Produccion();
            $produccion->maquina_id = $maquina->id;
            $produccion->tiempo_produccion = $sumaProd;
            $produccion->tiempo_inactividad = 0;
            $produccion->save();

            
            Tarea::whereIn('id', $tareas->pluck('id'))->update([
                'id_produccion' => $produccion->id,
                'updated_at' => now(),
            ]);

            
            $ultimoTermino = Carbon::parse($tareas->max('fecha_hora_termino'));

            
            $inact = $this->inactividadService->calcular($ultimoTermino, $sumaProd);

            $produccion->fecha_hora_inicio_inactividad  = $inact['inicio'];
            $produccion->fecha_hora_termino_inactividad = $inact['termino'];
            $produccion->tiempo_inactividad             = $inact['acumulado'];
            $produccion->save();

            return $produccion;
        });
    }
}
