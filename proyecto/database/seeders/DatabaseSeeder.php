<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Maquina;

class DatabaseSeeder extends Seeder
{
   
    public function run(): void
    {
        
        $faltantes = max(0, 5 - Maquina::count());

        if ($faltantes > 0) {
            Maquina::factory()->count($faltantes)->create();
        }
    }
   
}
