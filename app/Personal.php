<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $fillable = ['ley','tiporegistro','fechaini','fechafin','estado','jornada','categoria','motivovacante','situacionlab','cargo','tipo','subtipo','codplaza','activo','borrado','persona_id','institucion_id'];
    protected $guarded = ['id'];

    public function persona()
    {
        return $this->belongsTo('App\Persona');
    }
    public function institucion()
    {
        return $this->belongsTo('App\Institucion');
    }

    public function asistenciapersonal()
    {
        return $this->hasMany(Asistenciapersonal::class);
    }

    public function configdia()
    {
        return $this->hasMany(Configdia::class);
    }

        public function justificacion()
    {
        return $this->hasMany(Justificacion::class);
    }
}
