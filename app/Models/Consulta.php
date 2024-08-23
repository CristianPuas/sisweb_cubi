<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = ['nom_pac','ap_pac','edad_pac','tel_pac', 'motivo_cons','obs_cons','fecha_cons','hora_cons','tratamiento_id'];
    
    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class, 'tratamiento_id');
    }

    
}
