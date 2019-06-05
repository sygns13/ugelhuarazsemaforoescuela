<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configdia extends Model
{
    protected $fillable = ['tipo','tipodia_id','personal_id','seccion_id','activo','borrado','fechaini','fechafin','turno_id'];
    protected $guarded = ['id'];

    public function personal()
    {
        return $this->belongsTo('App\Personal');
    }

    public function seccion()
    {
        return $this->belongsTo('App\Seccion');
    }

    public function turno()
    {
        return $this->belongsTo('App\Turno');
    }

    public function tipodia()
    {
        return $this->belongsTo('App\Tipodia');
    }
}
