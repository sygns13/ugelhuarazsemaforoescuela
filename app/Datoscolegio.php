<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Datoscolegio extends Model
{
    protected $fillable = ['zona','codigomod','clave8','tipoie_id','tipogestion_id','nivel_id','institucion_id','modalidad'];
    protected $guarded = ['id'];

    public function institucion()
    {
        return $this->belongsTo('App\Institucion');
    }
    public function tipoie()
    {
        return $this->belongsTo('App\Tipoie');
    }
    public function tipogestion()
    {
        return $this->belongsTo('App\Tipogestion');
    }
    public function nivel()
    {
        return $this->belongsTo('App\Nivel');
    }

    public function grado()
    {
        return $this->hasMany(Grado::class);
    }

}
