<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    protected $fillable = ['nombre','cantalumnos','activo','borrado','grado_id','fechaini','fechafin'];
    protected $guarded = ['id'];

    public function grado()
    {
        return $this->belongsTo('App\Grado');
    }

    public function asistenciaalumno()
    {
    	return $this->hasMany(Asistenciaalumno::class);
    }

    public function configdia()
    {
    	return $this->hasMany(Configdia::class);
    }

    public function alumnosjustificado()
    {
        return $this->hasMany(Alumnosjustificado::class);
    }
}
