<?php

namespace App\Console\Commands;

use App\Models\Maquina;
use App\Services\ProduccionService;
use Illuminate\Console\Command;

class ProcesarProduccionCommand extends Command
{
    
    protected $signature = 'app:procesar-produccion {--id_maquina=}';

    protected $description = 'Detecta 5 tareas PENDIENTE por máquina, completa, crea Producción e Inactividad.';

    public function __construct(private ProduccionService $produccionService)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $maquinaId = $this->option('maquina');

        $query = Maquina::query();
        if ($maquinaId) $query->where('id', $maquinaId);

        foreach ($query->get() as $m) {
            $prod = $this->produccionService->procesarCiclo($m);
            if ($prod) {
                $this->info("✔ Producción #{$prod->id} en Máquina #{$m->id} ({$m->nombre})");
            } else {
                $this->warn("… Máquina #{$m->id} aún no tiene 5 tareas PENDIENTE sin producción.");
            }
        }

        return self::SUCCESS;
    }
}
