<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Maquina;
use App\Models\Tarea;

class TareasAleatoriasSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Maquina::all() as $m) {
            Tarea::factory()->count(5)->paraMaquina($m->id)->create();
        }
    }
}