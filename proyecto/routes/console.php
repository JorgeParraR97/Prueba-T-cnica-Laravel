<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Services\ProduccionService;
use App\Models\Maquina;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:procesar-produccion {--id_maquina=}', function () {
    $maquinaId = $this->option('id_maquina');
    $service = app(ProduccionService::class);

    $query = Maquina::query();
    if ($maquinaId) $query->where('id', $maquinaId);

    foreach ($query->get() as $m) {
        $prod = $service->procesarCiclo($m);
        $prod
            ? $this->info("✔ Producción #{$prod->id} en Máquina #{$m->id} ({$m->nombre})")
            : $this->warn("… Máquina #{$m->id} sin 5 tareas PENDIENTE.");
    }
})->describe('Procesa producción e inactividad para máquinas con 5 tareas PENDIENTE');
