<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Maquina;


class MaquinaFactory extends Factory
{
    protected $model = Maquina::class;
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->company(),
            'coeficiente'=> $this->faker->randomFloat(2,1,3),
        ];
    }
}
