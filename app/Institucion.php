<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    protected $fillable = ['nombre','direccion','telefono','correo','activo','borrado','tipo','distritos_id','institucion_id'];
    protected $guarded = ['id'];

    public function distrito()
    {
        return $this->belongsTo('App\Distrito');
    }

    public function datoscolegio()
    {
        return $this->hasMany(Datoscolegio::class);
    }

    public function personal()
    {
        return $this->hasMany(Personal::class);
    }
}
