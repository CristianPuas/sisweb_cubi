<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = ['nombres_pc','ap_pat_pc','ap_mat_pc','edad','tel_pac','direccion_pc','ci_pc','genero_pc','trat_realizado','obs_trat', 'precio_trat','acuenta_trat','saldo_trat','fecha_trat','hora_trat', 'consulta', 'tratamiento','estado_trat'];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }

    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class);
    }
    public function tratamientos()
{
    return $this->hasMany(PacienteTratamiento::class,'paciente_id');
}

}
