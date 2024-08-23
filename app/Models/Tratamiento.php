<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model
{
    use HasFactory;

    protected $fillable = ['cod_trat','nomb_trat', 'costo_trat'];

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
    public function paciente()
{
    return $this->belongsTo(Paciente::class,'paciente_id');
}
}
