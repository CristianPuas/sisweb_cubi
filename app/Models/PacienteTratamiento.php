<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacienteTratamiento extends Model
{
    use HasFactory;
    protected $fillable = [
        'paciente_id',
        'tratamiento_id',
        'trat_realizado',
        'obs_trat',
        'precio_trat',
        'acuenta_trat',
        'saldo_trat',
        'fecha_trat',
        'hora_trat',
        'estado_trat',
    ];
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class);
    }
}
