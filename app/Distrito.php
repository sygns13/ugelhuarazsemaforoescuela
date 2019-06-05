<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $fillable = ['nombre','codigo','activo','borrado','provincia_id'];
    protected $guarded = ['id'];

    public function provincia()
    {
        return $this->belongsTo('App\Provincia');
    }

    public function institucion()
    {
        return $this->hasMany(Institucion::class);
    }
}
