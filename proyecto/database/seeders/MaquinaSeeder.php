<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Maquina;

class MaquinaSeeder extends Seeder
{

    public function run(): void
    {
        Maquina::factory()->count(5)->create();

    }



}
