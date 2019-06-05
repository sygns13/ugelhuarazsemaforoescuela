<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $fillable = ['descripcion','codigo','activo','borrado','tipo','horaIni','horaFin'];
    protected $guarded = ['id'];

    public function configdia()
    {
    	return $this->hasMany(Configdia::class);
    }
}
