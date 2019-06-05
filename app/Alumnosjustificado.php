<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumnosjustificado extends Model
{
    protected $fillable = ['justificacionalumno_id','estado','activo','borrado','colegio_id','seccion_id'];
    protected $guarded = ['id'];

    public function seccion()
    {
        return $this->belongsTo('App\Seccionjustificacionalumnos');
    }

    public function justificacionalumno()
    {
        return $this->belongsTo('App\Justificacionalumno');
    }
}
