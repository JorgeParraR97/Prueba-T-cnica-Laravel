<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tarea extends Model
{
    use HasFactory;

    public const ESTADO_PENDIENTE  = 'PENDIENTE';
    public const ESTADO_COMPLETADA = 'COMPLETADA';

    protected $table = 'tareas';

    protected $fillable = [
        'id_maquina',
        'id_produccion',
        'fecha_hora_inicio',
        'fecha_hora_termino',
        'tiempo_empleado',
        'tiempo_produccion',
        'estado',
    ];

    protected $casts = [
        'fecha_hora_inicio'  => 'datetime',
        'fecha_hora_termino' => 'datetime',
        'tiempo_empleado'    => 'decimal:2',
        'tiempo_produccion'  => 'decimal:2',
    ];

    
   protected $attributes = ['estado' => 'PENDIENTE'];

    
    public function maquina(): BelongsTo
    {
        return $this->belongsTo(Maquina::class, 'id_maquina');
    }

    public function produccion(): BelongsTo
    {
        return $this->belongsTo(Produccion::class, 'id_produccion');
    }

    
    public function scopePendiente($q)
    {
        return $q->where('estado', self::ESTADO_PENDIENTE);
    }

    public function scopeCompletada($q)
    {
        return $q->where('estado', self::ESTADO_COMPLETADA);
    }

    public function scopeSinProduccion($q)
    {
        return $q->whereNull('id_produccion');
    }
}
