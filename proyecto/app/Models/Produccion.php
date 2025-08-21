<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produccion extends Model
{
    use HasFactory;

    protected $table = 'producciones';

    protected $fillable = [
        'id_maquina',
        'tiempo_produccion',
        'tiempo_inactividad',
        'fecha_hora_inicio_inactividad',
        'fecha_hora_termino_inactividad',
    ];

    protected $casts = [
        'tiempo_produccion'              => 'decimal:2',
        'tiempo_inactividad'             => 'decimal:2',
        'fecha_hora_inicio_inactividad'  => 'datetime',
        'fecha_hora_termino_inactividad' => 'datetime',
    ];

    public function maquina(): BelongsTo
    {
        return $this->belongsTo(Maquina::class, 'id_maquina');
    }

    public function tareas(): HasMany
    {
        return $this->hasMany(Tarea::class, 'id_produccion');
    }
}
