<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Justificacionalumno extends Model
{
    protected $fillable = ['titulo','descripcion','estado','activo','borrado','rutafile','fecha','fechaini','fechafin'];
    protected $guarded = ['id'];

    public function alumnosjustificado()
    {
        return $this->hasMany(Alumnosjustificado::class);
    }
}
