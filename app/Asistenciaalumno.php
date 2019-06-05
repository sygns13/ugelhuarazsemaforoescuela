<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistenciaalumno extends Model
{
    protected $fillable = ['nombre','cantasist','fecha','activo','borrado','canttotal','seccion_id','configdia_id'];
    protected $guarded = ['id'];

    public function seccion()
    {
        return $this->belongsTo('App\Seccion');
    }

}
